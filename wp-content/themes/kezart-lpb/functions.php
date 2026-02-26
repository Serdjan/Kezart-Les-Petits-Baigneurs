<?php

declare(strict_types=1);

namespace RS\Theme;

const RS_THEME_DIR = __DIR__;

use RS\Theme\App\Core\Bootstrap;

require __DIR__ . '/vendor/autoload.php';

Bootstrap::instance();

add_filter('acf/fields/google_map/api', function ($api) {
    $api['key'] = 'AIzaSyDmK88g2x7pwU3aRpLQNwuBq2NT8EtzLy8';
    return $api;
});

function donner_menus_aux_editeurs(): void
{
    $role = get_role('editor');
    if ($role) {
        $role->add_cap('edit_theme_options');
    }
}
add_action('init', __NAMESPACE__ . '\donner_menus_aux_editeurs');
