<?php

declare(strict_types=1);

$cards = !empty($args['card']) ? $args['card'] : []; ?>

<?php
if (!empty($args['title'])) : ?>
    <div class="max-w-xl text-center mx-auto text-32 leading-[37px] font-extrabold text-blue-dark mb-11"><?php
        echo wp_kses_post($args['title']); ?></div>
<?php
endif; ?>

<div class="section-feature-cards grid grid-cols-1 md:grid-cols-3 gap-y-20 md:gap-8 animate-fadeInUp">
    <?php
    foreach ($cards as $card) : ?>
        <div class="flex flex-col items-center text-center gap-4 md:gap-7">
            <div class="block relative aspect-[1.35/1] size-full rounded-2xl overflow-hidden image-effect">
                <?php
                echo wp_get_attachment_image(
                    $card['image'],
                    'medium',
                    false,
                    ['class' => 'absolute inset-0 size-full object-cover object-center']
                ); ?>
            </div>
            <h3 class="text-xl md:text-[27px] md:leading-[30px] font-extrabold mb-1"><?php
                echo wp_kses_post($card['title']); ?></h3>

            <?php
            if (!empty($card['subtitle'])) : ?>
                <p class="text-blue"><?php
                    echo wp_kses_post($card['subtitle']); ?></p>
            <?php
            endif; ?>

            <?php
            if (!empty($card['button'])) : ?>
                <?php
                get_template_part(
                    'resources/views/partials/components/button',
                    null,
                    $card['button']
                ); ?>
            <?php
            endif; ?>
        </div>
    <?php
    endforeach; ?>
</div>
