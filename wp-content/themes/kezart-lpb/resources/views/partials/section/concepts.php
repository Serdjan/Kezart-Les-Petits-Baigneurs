<?php

declare(strict_types=1);

if (empty($args['items'])) {
    return;
}

extract($args); ?>

<div id="concept" class="grid grid-cols-1 sm:grid-cols-2 gap-8 px-6">
    <?php
    foreach ($items as $item) : ?>
        <div class="<?php
        echo !empty($item['full_width']) ? 'rounded-30 overflow-hidden sm:col-span-2' : 'bg-white rounded-20 p-5'; ?>">
            <?php
            if (!empty($item['full_width'])) : ?>
                <div class="relative w-full overflow-hidden rounded-20 lg:rounded-30 lg:aspect-[2.86/1]">
                    <?php
                    echo wp_get_attachment_image(
                        $item['image'],
                        'large',
                        false,
                        ['class' => 'lg:absolute inset-0 size-full object-cover object-center']
                    ); ?>
                    <div class="bg-white lg:rounded-20 lg:max-w-[415px] w-full p-8 lg:absolute lg:top-1/2 lg:right-20 lg:-translate-y-1/2 drop-shadow-concept">
                        <h4 class="text-[26px] leading-[29px] font-extrabold text-blue-dark mb-4"><?php
                            echo wp_kses_post($item['title']); ?></h4>
                        <p class="text-lg text-blue"><?php
                            echo wp_kses_post($item['description']); ?></p>
                    </div>
                </div>
            <?php
            else : ?>
                <div class="relative w-full aspect-[1.63/1] rounded-20 overflow-hidden mb-3">
                    <?php
                    echo wp_get_attachment_image(
                        $item['image'],
                        'large',
                        false,
                        ['class' => 'absolute inset-0 size-full object-cover object-center']
                    ); ?>
                </div>
                <h4 class="text-xl md:text-32 md:leading-[51px] font-extrabold text-blue-dark mb-2 md:mb-0"><?php
                    echo wp_kses_post($item['title']); ?></h4>
                <p class="text-base md:text-lg text-blue md:max-w-[350px]"><?php
                    echo wp_kses_post($item['description']); ?></p>
            <?php
            endif; ?>
        </div>
    <?php
    endforeach; ?>
</div>