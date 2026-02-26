<?php

declare(strict_types=1);

return [
    'add' => [
        'html5' => [
            'caption',
            'comment-form',
            'comment-list',
            'gallery',
            'search-form',
            'script',
            'style',
        ],
        'align-wide',
        'title-tag',
        'post-thumbnails',
        'responsive-embeds',
        'customize-selective-refresh-widgets',
        'appearance-tools',
        'woocommerce' => [
            'single_image_width' => 416,
            'thumbnail_image_width' => 324,
            'product_grid' => [
                'default_columns' => 3,
                'default_rows' => 4,
                'min_columns' => 1,
                'max_columns' => 6,
                'min_rows' => 1,
            ],
        ],
        'wc-product-gallery-zoom',
        'wc-product-gallery-lightbox',
        'wc-product-gallery-slider',
    ],
    'remove' => [
        'block-templates',
        'core-block-patterns',
    ],
];
