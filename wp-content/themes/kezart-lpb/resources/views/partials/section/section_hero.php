<?php

declare(strict_types=1);

extract($args); ?>

<div class="section-hero flex flex-col text-center gap-y-8 mx-auto mb-18">
    <?php
    if (!empty($above_title)) : ?>
        <div class="text-lg leading-none uppercase font-bold text-blue"><?php
            echo wp_kses_post($above_title); ?></div>
    <?php
    endif; ?>
    <?php
    if (!empty($title)) : ?>
        <h2 class="<?php echo ! empty($smaller_title) ? 'text-32' : 'text-32 lg:text-52'; ?> leading-none text-blue-dark font-extrabold"><?php
            echo wp_kses_post($title); ?></h2>
    <?php
    endif; ?>
    <?php
    if (!empty($below_title)) : ?>
        <div class="text-xl text-blue max-w-[500px] mx-auto"><?php
            echo wp_kses_post($below_title); ?></div>
    <?php
    endif; ?>
</div>
