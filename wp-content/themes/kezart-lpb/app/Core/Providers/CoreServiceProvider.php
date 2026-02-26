<?php

declare(strict_types=1);

namespace RS\Theme\App\Core\Providers;

use RS\Theme\App\Core\Interfaces\Service;
use RS\Theme\App\Core\PageTemplates;

class CoreServiceProvider implements Service
{
    public function register(): void
    {
        add_action('after_setup_theme', function (): void {
            load_theme_textdomain('kezart-lpb', trailingslashit(WP_LANG_DIR) . 'themes');
            load_theme_textdomain('kezart-lpb', get_stylesheet_directory() . '/languages');
            load_theme_textdomain('kezart-lpb', get_template_directory() . '/languages');
        });

        new PageTemplates();
    }
}
