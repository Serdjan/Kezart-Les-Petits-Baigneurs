<?php

declare(strict_types=1);

if (empty($args['items'])) {
    return;
}

extract($args); ?>

<div id="people-<?php
echo uniqid(); ?>" class="flex flex-wrap justify-center gap-8">
    <?php
    foreach ($items as $item): ?>
        <div class="w-full sm:w-[calc(50%-24px)] md:w-[calc(25%-24px)] p-4 rounded-20 <?php
        echo empty($item['bg_color']) ? 'bg-white' : ''; ?>" <?php
        echo !empty($item['bg_color']) ? 'style="background-color: ' . $item['bg_color'] . ';"' : ''; ?>>
            <div class="relative w-full aspect-[1.22/1] overflow-hidden rounded-20 mb-10">
                <?php
                echo wp_get_attachment_image(
                    $item['image'],
                    'medium',
                    false,
                    ['class' => 'absolute inset-0 size-full object-cover object-center']
                ); ?>
            </div>
            <h4 class="text-32 leading-[44px] font-extrabold <?php
            echo !empty($item['bg_color']) ? 'text-white' : 'text-blue-dark'; ?>"><?php
                echo wp_kses_post($item['title']); ?></h4>
            <h5 class="text-lg font-bold mb-2.5 <?php
            echo !empty($item['bg_color']) ? 'text-white' : 'text-blue'; ?>"><?php
                echo wp_kses_post($item['position']); ?></h5>
            <p class="text-sm font-light mb-4 <?php
            echo !empty($item['bg_color']) ? 'text-white' : 'text-blue'; ?>"><?php
                echo wp_kses_post($item['description']); ?></p>
        </div>
    <?php
    endforeach; ?>
</div>
