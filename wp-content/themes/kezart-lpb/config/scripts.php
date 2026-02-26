<?php

declare(strict_types=1);

return [
    'site' => [
        'resources/js/site.js',
        [],
        wp_get_theme()->get('Version'),
        true,
    ],
];
