<?php

declare(strict_types=1);

namespace RS\Theme\App\Core\Providers;

use Illuminate\Support\Collection;
use RS\Theme\App\Core\Config;
use RS\Theme\App\Core\Interfaces\Service;

class SidebarsServiceProvider implements Service
{
    public function register(): void
    {
        add_action('widgets_init', function (): void {
            $sidebars = Config::instance()->get('sidebars');
            if (empty($sidebars)) {
                return;
            }

            if (empty($sidebars['register']) || empty($sidebars['config'])) {
                return;
            }

            Collection::make($sidebars['register'])
                ->map(fn ($instance) => register_sidebar(
                    array_merge($sidebars['config'], $instance)
                ));
        });
    }
}
