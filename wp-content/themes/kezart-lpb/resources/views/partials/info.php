<?php

declare(strict_types=1);

extract($args); ?>

<div class="py-16 lg:py-32" style="background-color: <?php
echo $bg_color; ?>;">
    <div class="container px-20 text-center">
        <h3 class="text-32 lg:text-52 leading-none text-blue-dark font-extrabold mb-12"><?php
            echo wp_kses_post($title); ?></h3>
        <p class="text-blue text-xl lg:text-[26px] lg:leading-[31px] max-w-2xl lg:max-w-4xl mx-auto"><?php
            echo wp_kses_post($subtitle); ?></p>
    </div>
</div>
