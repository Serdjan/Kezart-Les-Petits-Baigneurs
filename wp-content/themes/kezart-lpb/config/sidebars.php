<?php

declare(strict_types=1);

return [
    'register' => [
        ['name' => __('Blog', 'kezart-lpb'), 'id' => 'sidebar-blog'],
        ['name' => __('Footer', 'kezart-lpb'), 'id' => 'sidebar-footer'],
    ],

    'config' => [
        'before_widget' => '<div class="widget %1$s %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ],
];
