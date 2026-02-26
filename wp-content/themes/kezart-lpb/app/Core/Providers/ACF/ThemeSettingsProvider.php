<?php

declare(strict_types=1);

namespace RS\Theme\App\Core\Providers\ACF;

use RS\Theme\App\Core\Interfaces\Service;

class ThemeSettingsProvider implements Service
{
    public function register(): void
    {
        add_action('acf/init', function (): void {
            if (!function_exists('acf_add_options_page')) {
                return;
            }

            acf_add_options_page([
                'page_title' => __('Theme Settings', 'kezart-lpb'),
                'menu_slug' => 'theme-settings',
                'parent_slug' => 'themes.php',
                'capability' => 'activate_plugins',
            ]);
        });
    }
}
