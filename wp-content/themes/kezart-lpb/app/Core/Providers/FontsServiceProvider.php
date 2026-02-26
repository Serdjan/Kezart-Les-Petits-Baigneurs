<?php

declare(strict_types=1);

namespace RS\Theme\App\Core\Providers;

use Illuminate\Support\Collection;
use RS\Theme\App\Core\Config;
use RS\Theme\App\Core\Interfaces\Service;
use RS\Theme\App\Core\Vite;

class FontsServiceProvider implements Service
{
    public function register(): void
    {
        add_action('wp_head', function (): void {
            $fonts = Config::instance()->get('fonts');
            $Vite = new Vite();

            if (!empty($fonts)) {
                Collection::make($fonts)->each(function ($weights, $prefix) use ($Vite) {
                    Collection::make($weights)->each(function ($weight) use ($prefix, $Vite) {
                        $fontPath = "resources/fonts/$prefix$weight.woff2";
                        $fontName = $Vite->asset($fontPath);
                        echo '<link rel="preload" href="' . $fontName . '" as="font" type="font/woff2" crossorigin>';
                    });
                });
            }
        });
    }
}
