<?php

namespace RS\Theme\App\Core;

use Exception;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Js;
use Illuminate\Support\Traits\Macroable;

class Vite implements Htmlable
{
    use Macroable;

    /**
     * The Content Security Policy nonce to apply to all generated tags.
     *
     * @var string|null
     */
    protected ?string $nonce;

    /**
     * The key to check for integrity hashes within the manifest.
     *
     * @var string|false
     */
    protected string|false $integrityKey = 'integrity';

    /**
     * The configured entry points.
     *
     * @var array
     */
    protected array $entryPoints = [];

    /**
     * The path to the "hot" file.
     *
     * @var string|null
     */
    protected ?string $hotFile;

    /**
     * The path to the build directory.
     *
     * @var string
     */
    protected string $buildDirectory = 'build';

    /**
     * The name of the manifest file.
     *
     * @var string
     */
    protected string $manifestFilename = 'manifest.json';

    /**
     * The custom asset path resolver.
     *
     * @var callable|null
     */
    protected $assetPathResolver = null;

    /**
     * The script tag attributes resolvers.
     *
     * @var array
     */
    protected array $scriptTagAttributesResolvers = [];

    /**
     * The style tag attributes resolvers.
     *
     * @var array
     */
    protected array $styleTagAttributesResolvers = [];

    /**
     * The preload tag attributes resolvers.
     *
     * @var array
     */
    protected array $preloadTagAttributesResolvers = [];

    /**
     * The preloaded assets.
     *
     * @var array
     */
    protected array $preloadedAssets = [];

    /**
     * The cached manifest files.
     *
     * @var array
     */
    protected static array $manifests = [];

    /**
     * The prefetching strategy to use.
     *
     * @var null|'waterfall'|'aggressive'
     */
    protected ?string $prefetchStrategy = null;

    /**
     * The number of assets to load concurrently when using the "waterfall" strategy.
     *
     * @var int
     */
    protected int $prefetchConcurrently = 3;

    /**
     * The name of the event that should trigger prefetching. The event must be dispatched on the `window`.
     *
     * @var string
     */
    protected string $prefetchEvent = 'load';

    /**
     * Get the Content Security Policy nonce applied to all generated tags.
     *
     * @return string|null
     */
    public function cspNonce(): ?string
    {
        return $this->nonce;
    }

    /**
     * Set the Vite entry points.
     *
     * @param array $entryPoints
     * @return $this
     */
    public function withEntryPoints(array $entryPoints): static
    {
        $this->entryPoints = $entryPoints;

        return $this;
    }

    /**
     * Get the Vite "hot" file path.
     *
     * @return string
     */
    public function hotFile(): string
    {
        return $this->hotFile ?? get_theme_file_path('public/hot');
    }

    /**
     * Generate Vite tags for an entrypoint.
     *
     * @param string|string[] $entrypoints
     * @param string|null $buildDirectory
     * @return HtmlString
     *
     * @throws Exception
     */
    public function __invoke(array|string $entrypoints, ?string $buildDirectory = null)
    {
        $entrypoints = new Collection($entrypoints);
        $buildDirectory ??= $this->buildDirectory;

        if ($this->isRunningHot()) {
            return new HtmlString(
                $entrypoints
                    ->prepend('@vite/client')
                    ->map(
                        fn ($entrypoint) => $this->makeTagForChunk($entrypoint, $this->hotAsset($entrypoint), null, null)
                    )
                    ->join('')
            );
        }

        $manifest = $this->manifest($buildDirectory);

        $tags = new Collection();
        $preloads = new Collection();

        foreach ($entrypoints as $entrypoint) {
            $chunk = $this->chunk($manifest, $entrypoint);

            $preloads->push([
                $chunk['src'],
                $this->assetPath("{$buildDirectory}/{$chunk['file']}"),
                $chunk,
                $manifest,
            ]);

            foreach ($chunk['imports'] ?? [] as $import) {
                $preloads->push([
                    $import,
                    $this->assetPath("{$buildDirectory}/{$manifest[$import]['file']}"),
                    $manifest[$import],
                    $manifest,
                ]);

                foreach ($manifest[$import]['css'] ?? [] as $css) {
                    $partialManifest = (new Collection($manifest))->where('file', $css);

                    $preloads->push([
                        $partialManifest->keys()->first(),
                        $this->assetPath("{$buildDirectory}/{$css}"),
                        $partialManifest->first(),
                        $manifest,
                    ]);

                    $tags->push(
                        $this->makeTagForChunk(
                            $partialManifest->keys()->first(),
                            $this->assetPath("{$buildDirectory}/{$css}"),
                            $partialManifest->first(),
                            $manifest
                        )
                    );
                }
            }

            $tags->push(
                $this->makeTagForChunk(
                    $entrypoint,
                    $this->assetPath("{$buildDirectory}/{$chunk['file']}"),
                    $chunk,
                    $manifest
                )
            );

            foreach ($chunk['css'] ?? [] as $css) {
                $partialManifest = (new Collection($manifest))->where('file', $css);

                $preloads->push([
                    $partialManifest->keys()->first(),
                    $this->assetPath("{$buildDirectory}/{$css}"),
                    $partialManifest->first(),
                    $manifest,
                ]);

                $tags->push(
                    $this->makeTagForChunk(
                        $partialManifest->keys()->first(),
                        $this->assetPath("{$buildDirectory}/{$css}"),
                        $partialManifest->first(),
                        $manifest
                    )
                );
            }
        }

        [$stylesheets, $scripts] = $tags->unique()->partition(fn ($tag) => str_starts_with($tag, '<link'));

        $preloads = $preloads->unique()
            ->sortByDesc(fn ($args) => $this->isCssPath($args[1]))
            ->map(fn ($args) => $this->makePreloadTagForChunk(...$args));

        $base = $preloads->join('') . $stylesheets->join('') . $scripts->join('');

        if ($this->prefetchStrategy === null || $this->isRunningHot()) {
            return new HtmlString($base);
        }

        $discoveredImports = [];

        return (new Collection($entrypoints))
            ->flatMap(fn ($entrypoint) => (new Collection($manifest[$entrypoint]['dynamicImports'] ?? []))
                ->map(fn ($import) => $manifest[$import])
                ->filter(fn ($chunk) => str_ends_with($chunk['file'], '.js') || str_ends_with($chunk['file'], '.css'))
                ->flatMap(
                    $f = function ($chunk) use (&$f, $manifest, &$discoveredImports) {
                        return (new Collection([...$chunk['imports'] ?? [], ...$chunk['dynamicImports'] ?? []]))
                            ->reject(function ($import) use (&$discoveredImports) {
                                if (isset($discoveredImports[$import])) {
                                    return true;
                                }

                                return !$discoveredImports[$import] = true;
                            })
                            ->reduce(
                                fn ($chunks, $import) => $chunks->merge(
                                    $f($manifest[$import])
                                ),
                                new Collection([$chunk])
                            )
                            ->merge(
                                (new Collection($chunk['css'] ?? []))->map(
                                    fn ($css) => (new Collection($manifest))->first(
                                        fn ($chunk) => $chunk['file'] === $css
                                    ) ?? [
                                        'file' => $css,
                                    ],
                                )
                            );
                    }
                )
                ->map(function ($chunk) use ($buildDirectory, $manifest) {
                    return (new Collection([
                        ...$this->resolvePreloadTagAttributes(
                            $chunk['src'] ?? null,
                            $url = $this->assetPath("{$buildDirectory}/{$chunk['file']}"),
                            $chunk,
                            $manifest,
                        ),
                        'rel' => 'prefetch',
                        'fetchpriority' => 'low',
                        'href' => $url,
                    ]))->reject(
                        fn ($value) => in_array($value, [null, false], true)
                    )->mapWithKeys(fn ($value, $key) => [
                        $key = (is_int($key) ? $value : $key) => $value === true ? $key : $value,
                    ])->all();
                })
                ->reject(fn ($attributes) => isset($this->preloadedAssets[$attributes['href']])))
            ->unique('href')
            ->values()
            ->pipe(fn ($assets) => with(Js::from($assets), fn ($assets) => match ($this->prefetchStrategy) {
                'waterfall' => new HtmlString(
                    $base . <<<HTML

                    <script{$this->nonceAttribute()}>
                         window.addEventListener('{$this->prefetchEvent}', () => window.setTimeout(() => {
                            const makeLink = (asset) => {
                                const link = document.createElement('link')

                                Object.keys(asset).forEach((attribute) => {
                                    link.setAttribute(attribute, asset[attribute])
                                })

                                return link
                            }

                            const loadNext = (assets, count) => window.setTimeout(() => {
                                if (count > assets.length) {
                                    count = assets.length

                                    if (count === 0) {
                                        return
                                    }
                                }

                                const fragment = new DocumentFragment

                                while (count > 0) {
                                    const link = makeLink(assets.shift())
                                    fragment.append(link)
                                    count--

                                    if (assets.length) {
                                        link.onload = () => loadNext(assets, 1)
                                        link.onerror = () => loadNext(assets, 1)
                                    }
                                }

                                document.head.append(fragment)
                            })

                            loadNext({$assets}, {$this->prefetchConcurrently})
                        }))
                    </script>
                    HTML
                ),
                'aggressive' => new HtmlString(
                    $base . <<<HTML

                    <script{$this->nonceAttribute()}>
                         window.addEventListener('{$this->prefetchEvent}', () => window.setTimeout(() => {
                            const makeLink = (asset) => {
                                const link = document.createElement('link')

                                Object.keys(asset).forEach((attribute) => {
                                    link.setAttribute(attribute, asset[attribute])
                                })

                                return link
                            }

                            const fragment = new DocumentFragment;
                            {$assets}.forEach((asset) => fragment.append(makeLink(asset)))
                            document.head.append(fragment)
                         }))
                    </script>
                    HTML
                ),
            }));
    }

    /**
     * Make tag for the given chunk.
     *
     * @param string $src
     * @param string $url
     * @param array|null $chunk
     * @param array|null $manifest
     * @return string
     */
    protected function makeTagForChunk(string $src, string $url, ?array $chunk, ?array $manifest): string
    {
        if (
            $this->nonce === null
            && $this->integrityKey !== false
            && !array_key_exists($this->integrityKey, $chunk ?? [])
            && $this->scriptTagAttributesResolvers === []
            && $this->styleTagAttributesResolvers === []) {
            return $this->makeTag($url);
        }

        if ($this->isCssPath($url)) {
            return $this->makeStylesheetTagWithAttributes(
                $url,
                $this->resolveStylesheetTagAttributes($src, $url, $chunk, $manifest)
            );
        }

        return $this->makeScriptTagWithAttributes(
            $url,
            $this->resolveScriptTagAttributes($src, $url, $chunk, $manifest)
        );
    }

    /**
     * Make a preload tag for the given chunk.
     *
     * @param string $src
     * @param string $url
     * @param array $chunk
     * @param array $manifest
     * @return string
     */
    protected function makePreloadTagForChunk(string $src, string $url, array $chunk, array $manifest): string
    {
        $attributes = $this->resolvePreloadTagAttributes($src, $url, $chunk, $manifest);

        if ($attributes === false) {
            return '';
        }

        $this->preloadedAssets[$url] = $this->parseAttributes(
            (new Collection($attributes))->forget('href')->all()
        );

        return '<link ' . implode(' ', $this->parseAttributes($attributes)) . ' />';
    }

    /**
     * Resolve the attributes for the chunks generated script tag.
     *
     * @param string $src
     * @param string $url
     * @param array|null $chunk
     * @param array|null $manifest
     * @return array
     */
    protected function resolveScriptTagAttributes(string $src, string $url, ?array $chunk, ?array $manifest): array
    {
        $attributes = $this->integrityKey !== false
            ? ['integrity' => $chunk[$this->integrityKey] ?? false]
            : [];

        foreach ($this->scriptTagAttributesResolvers as $resolver) {
            $attributes = array_merge($attributes, $resolver($src, $url, $chunk, $manifest));
        }

        return $attributes;
    }

    /**
     * Resolve the attributes for the chunks generated stylesheet tag.
     *
     * @param string $src
     * @param string $url
     * @param array|null $chunk
     * @param array|null $manifest
     * @return array
     */
    protected function resolveStylesheetTagAttributes(string $src, string $url, ?array $chunk, ?array $manifest): array
    {
        $attributes = $this->integrityKey !== false
            ? ['integrity' => $chunk[$this->integrityKey] ?? false]
            : [];

        foreach ($this->styleTagAttributesResolvers as $resolver) {
            $attributes = array_merge($attributes, $resolver($src, $url, $chunk, $manifest));
        }

        return $attributes;
    }

    /**
     * Resolve the attributes for the chunks generated preload tag.
     *
     * @param string $src
     * @param string $url
     * @param array $chunk
     * @param array $manifest
     * @return array|false
     */
    protected function resolvePreloadTagAttributes(string $src, string $url, array $chunk, array $manifest): false|array
    {
        $attributes = $this->isCssPath($url) ? [
            'rel' => 'preload',
            'as' => 'style',
            'href' => $url,
            'nonce' => $this->nonce ?? false,
            'crossorigin' => $this->resolveStylesheetTagAttributes(
                $src,
                $url,
                $chunk,
                $manifest
            )['crossorigin'] ?? false,
        ] : [
            'rel' => 'modulepreload',
            'href' => $url,
            'nonce' => $this->nonce ?? false,
            'crossorigin' => $this->resolveScriptTagAttributes($src, $url, $chunk, $manifest)['crossorigin'] ?? false,
        ];

        $attributes = $this->integrityKey !== false
            ? array_merge($attributes, ['integrity' => $chunk[$this->integrityKey] ?? false])
            : $attributes;

        foreach ($this->preloadTagAttributesResolvers as $resolver) {
            if (false === ($resolvedAttributes = $resolver($src, $url, $chunk, $manifest))) {
                return false;
            }

            $attributes = array_merge($attributes, $resolvedAttributes);
        }

        return $attributes;
    }

    /**
     * Generate an appropriate tag for the given URL in HMR mode.
     *
     * @param string $url
     * @return string
     * @deprecated Will be removed in a future Laravel version.
     *
     */
    protected function makeTag(string $url): string
    {
        if ($this->isCssPath($url)) {
            return $this->makeStylesheetTag($url);
        }

        return $this->makeScriptTag($url);
    }

    /**
     * Generate a script tag for the given URL.
     *
     * @param string $url
     * @return string
     * @deprecated Will be removed in a future Laravel version.
     *
     */
    protected function makeScriptTag(string $url): string
    {
        return $this->makeScriptTagWithAttributes($url, []);
    }

    /**
     * Generate a stylesheet tag for the given URL in HMR mode.
     *
     * @param string $url
     * @return string
     * @deprecated Will be removed in a future Laravel version.
     *
     */
    protected function makeStylesheetTag(string $url): string
    {
        return $this->makeStylesheetTagWithAttributes($url, []);
    }

    /**
     * Generate a script tag with attributes for the given URL.
     *
     * @param string $url
     * @param array $attributes
     * @return string
     */
    protected function makeScriptTagWithAttributes(string $url, array $attributes): string
    {
        $attributes = $this->parseAttributes(array_merge([
            'type' => 'module',
            'src' => $url,
            'nonce' => $this->nonce ?? false,
        ], $attributes));

        return '<script ' . implode(' ', $attributes) . '></script>';
    }

    /**
     * Generate a link tag with attributes for the given URL.
     *
     * @param string $url
     * @param array $attributes
     * @return string
     */
    protected function makeStylesheetTagWithAttributes(string $url, array $attributes): string
    {
        $attributes = $this->parseAttributes(array_merge([
            'rel' => 'stylesheet',
            'href' => $url,
            'nonce' => $this->nonce ?? false,
        ], $attributes));

        return '<link ' . implode(' ', $attributes) . ' />';
    }

    /**
     * Determine whether the given path is a CSS file.
     *
     * @param string $path
     * @return bool
     */
    protected function isCssPath(string $path): bool
    {
        return preg_match('/\.(css|less|sass|scss|styl|stylus|pcss|postcss)(\?[^\.]*)?$/', $path) === 1;
    }

    /**
     * Parse the attributes into key="value" strings.
     *
     * @param array $attributes
     * @return array
     */
    protected function parseAttributes(array $attributes): array
    {
        return (new Collection($attributes))
            ->reject(fn ($value, $key) => in_array($value, [false, null], true))
            ->flatMap(fn ($value, $key) => $value === true ? [$key] : [$key => $value])
            ->map(fn ($value, $key) => is_int($key) ? $value : $key . '="' . $value . '"')
            ->values()
            ->all();
    }

    /**
     * Get the path to a given asset when running in HMR mode.
     *
     * @return string
     */
    protected function hotAsset($asset): string
    {
        return rtrim(file_get_contents($this->hotFile())) . '/' . $asset;
    }

    /**
     * Get the URL for an asset.
     *
     * @param string $asset
     * @param string|null $buildDirectory
     * @return string
     */
    public function asset(string $asset, string $buildDirectory = null): string
    {
        $buildDirectory ??= $this->buildDirectory;

        if ($this->isRunningHot()) {
            return $this->hotAsset($asset);
        }

        $chunk = $this->chunk($this->manifest($buildDirectory), $asset);

        return $this->assetPath($buildDirectory . '/' . $chunk['file']);
    }

    /**
     * Get the content of a given asset.
     *
     * @param string $asset
     * @param string|null $buildDirectory
     * @return string
     *
     * @throws Exception
     */
    public function content(string $asset, string $buildDirectory = null): string
    {
        $buildDirectory ??= $this->buildDirectory;

        $chunk = $this->chunk($this->manifest($buildDirectory), $asset);

        $path = get_theme_file_path($buildDirectory . '/' . $chunk['file']);

        if (!is_file($path) || !file_exists($path)) {
            throw new Exception("Unable to locate file from Vite manifest: {$path}.");
        }

        return file_get_contents($path);
    }

    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    protected function assetPath(string $path, bool $secure = null): string
    {
        return ($this->assetPathResolver ?? Config::instance()->asset(...))($path, $secure);
    }

    /**
     * Get the manifest file for the given build directory.
     *
     * @param string $buildDirectory
     * @return array
     *
     * @throws Exception
     */
    protected function manifest(string $buildDirectory): array
    {
        $path = $this->manifestPath("public/$buildDirectory");

        if (!isset(static::$manifests[$path])) {
            if (!is_file($path)) {
                throw new Exception("Vite manifest not found at: $path");
            }

            static::$manifests[$path] = json_decode(file_get_contents($path), true);
        }

        return static::$manifests[$path];
    }

    /**
     * Get the path to the manifest file for the given build directory.
     *
     * @param string $buildDirectory
     * @return string
     */
    protected function manifestPath(string $buildDirectory): string
    {
        return get_theme_file_path($buildDirectory . '/' . $this->manifestFilename);
    }

    /**
     * Get the chunk for the given entry point / asset.
     *
     * @param array $manifest
     * @param string $file
     * @return array
     *
     * @throws Exception
     */
    protected function chunk(array $manifest, string $file): array
    {
        if (!isset($manifest[$file])) {
            throw new Exception("Unable to locate file in Vite manifest: {$file}.");
        }

        return $manifest[$file];
    }

    /**
     * Get the nonce attribute for the prefetch script tags.
     *
     * @return HtmlString
     */
    protected function nonceAttribute(): HtmlString
    {
        if ($this->cspNonce() === null) {
            return new HtmlString('');
        }

        return new HtmlString(' nonce="' . $this->cspNonce() . '"');
    }

    /**
     * Determine if the HMR server is running.
     *
     * @return bool
     */
    public function isRunningHot(): bool
    {
        return is_file($this->hotFile());
    }

    /**
     * Get the Vite tag content as a string of HTML.
     *
     * @return string
     */
    public function toHtml(): string
    {
        return $this->__invoke($this->entryPoints)->toHtml();
    }
}
