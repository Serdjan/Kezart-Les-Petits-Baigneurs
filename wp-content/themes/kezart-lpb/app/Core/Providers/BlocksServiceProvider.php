<?php

declare(strict_types=1);

namespace RS\Theme\App\Core\Providers;

use RS\Theme\App\Core\Config;
use RS\Theme\App\Core\Interfaces\Service;

class BlocksServiceProvider implements Service
{
    public function register(): void
    {
        if (! class_exists('ACF')) {
            return;
        }

        $blocks = Config::instance()->get('blocks');
        if (empty($blocks)) {
            return;
        }

        add_action('init', function () use ($blocks): void {
            foreach ($blocks as $block) {
                $blockFilePath = get_theme_file_path("resources/views/blocks/$block/block.json");
                if (! file_exists($blockFilePath)) {
                    continue;
                }

                register_block_type($blockFilePath);
            }
        });
    }
}
