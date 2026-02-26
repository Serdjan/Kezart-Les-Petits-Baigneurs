<?php

declare(strict_types=1);

namespace RS\Theme\App\Core\Providers;

use Illuminate\Support\Collection;
use RS\Theme\App\Core\Config;
use RS\Theme\App\Core\Interfaces\Service;
use RS\Theme\App\Core\Vite;

class AssetsServiceProvider implements Service
{
    public function register(): void
    {
        $scripts = Config::instance()->get('scripts');
        $Vite = new Vite();

        add_action('wp_enqueue_scripts', function () use ($scripts, $Vite): void {
            $viteDevServer = $_ENV['VITE_DEV_SERVER_URL'] ?? 'http://localhost:5173';
            $isViteRunning = ($_ENV['VITE_DEV_MODE'] ?? 'false') === 'true';

            if ($isViteRunning) {
                wp_enqueue_script_module('vite-client', $viteDevServer . '/@vite/client', [], null);
            }

            $styles = Config::instance()->get('styles');
            if (!empty($styles)) {
                Collection::make($styles)->each(function ($params, $handle) use ($Vite) {
                    $collection = Collection::make($params);
                    wp_enqueue_style(
                        $handle,
                        $Vite->asset(strval($collection->first())),
                        ...$collection->forget($collection->keys()->first())->toArray()
                    );
                });
            }

            if (!empty($scripts)) {
                $functionToCall = $isViteRunning ? 'wp_enqueue_script_module' : 'wp_enqueue_script';

                Collection::make($scripts)->each(function ($params, $handle) use ($Vite, $functionToCall, $isViteRunning) {
                    $collection = Collection::make($params);
                    $args = $isViteRunning ? [$handle, $Vite->asset(strval($collection->first()))] : [
                        $handle,
                        $Vite->asset(strval($collection->first())),
                        ...$collection->forget($collection->keys()->first())->toArray()
                    ];
                    call_user_func($functionToCall, ...$args);
                });
            }
        });
    }
}
