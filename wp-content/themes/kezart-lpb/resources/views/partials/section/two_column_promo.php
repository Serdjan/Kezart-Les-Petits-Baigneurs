<?php

declare(strict_types=1);

extract($args); ?>

<div class="section-two-column-promo lg:px-30 flex items-center gap-10 lg:gap-32">
    <div class="hidden md:block w-[325px] shrink-0">
        <?php
        echo wp_get_attachment_image($image, 'full'); ?>
    </div>
    <div class="flex flex-col gap-6 md:gap-11">
        <?php
        if (!empty($above_title)) : ?>
            <div class="text-lg leading-none uppercase font-bold text-blue"><?php
                echo wp_kses_post($above_title); ?></div>
        <?php
        endif; ?>
        <?php
        if (!empty($title)) : ?>
            <h2 class="text-32 lg:text-52 leading-none text-blue-dark font-extrabold"><?php
                echo wp_kses_post($title); ?></h2>
        <?php
        endif; ?>

        <?php
        if (!empty($description)) : ?>
            <p class="text-base/6"><?php
                echo wp_kses_post($description); ?></p>
        <?php
        endif; ?>

        <div>
            <?php
            get_template_part(
                'resources/views/partials/components/button',
                null,
                $button
            ); ?>
        </div>
    </div>
</div>
