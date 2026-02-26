<?php

declare(strict_types=1);

namespace RS\Theme\App\Core\Providers;

use Illuminate\Support\Collection;
use RS\Theme\App\Core\Config;
use RS\Theme\App\Core\Interfaces\Service;

class ImagesServiceProvider implements Service
{
    public function register(): void
    {
        add_action('after_setup_theme', function (): void {
            $images = Config::instance()->get('images');
            if (empty($images)) {
                return;
            }

            Collection::make($images)
                ->each(fn ($params, $name) => add_image_size($name, ...$params));
        });
    }
}
