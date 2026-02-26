<?php

declare(strict_types=1);

extract($args); ?>

<div class="section-cta container py-16">
    <div class="rounded-20 bg-white p-5 md:py-10 md:px-12 flex flex-col-reverse md:flex-row items-center gap-10 md:gap-16">
        <div class="flex flex-col gap-y-6">
            <div class="mb-2 text-lg leading-none uppercase font-bold text-orange"><?php
                echo wp_kses_post($above_title); ?></div>
            <h2 class="text-32 lg:text-52 leading-none text-blue-dark font-extrabold"><?php
                echo wp_kses_post($title); ?></h2>
            <p class="text-lg text-blue"><?php
                echo wp_kses_post($description); ?></p>
            <div class="max-w-[335px]">
                <?php
                get_template_part(
                    'resources/views/partials/components/button',
                    null,
                    $button
                ); ?>
            </div>
        </div>
        <div class="rounded-2xl relative overflow-hidden aspect-[1.41/1] shrink-0 w-full lg:w-[400px] xl:w-[652px]">
            <?php
            echo wp_get_attachment_image($image, 'medium', false, ['class' => 'absolute inset-0 size-full object-cover object-center']); ?>
        </div>
    </div>
</div>
