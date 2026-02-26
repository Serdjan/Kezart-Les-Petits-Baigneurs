<?php

declare(strict_types=1);

extract($args); ?>

<div class="container text-center py-9">
    <?php
    if (!empty($above_title)) : ?>
        <div class="text-center text-blue uppercase text-lg leading-none mb-8 font-bold"><?php
            echo wp_kses_post($title); ?></div>
    <?php
    endif; ?>
    <div class="max-w-[650px] mx-auto mb-24">
        <?php
        if (!empty($title)) : ?>
            <h2 class="text-52 leading-none font-extrabold text-blue-dark mb-12"><?php
                echo wp_kses_post($title); ?></h2>
        <?php
        endif; ?>
        <?php
        if (!empty($subtitle)) : ?>
            <h3 class="text-32 leading-none font-extrabold text-blue-dark mb-5"><?php
                echo wp_kses_post($subtitle); ?></h3>
        <?php
        endif; ?>
        <?php
        if (!empty($description)) : ?>
            <p class="text-lg text-blue"><?php
                echo wp_kses_post($description); ?></p>
        <?php
        endif; ?>
    </div>

    <?php
    if (!empty($plans)) : ?>
        <div class="<?php
        echo !empty($type) ? 'pool-pricing-carousel swiper' : 'grid grid-cols-1 md:grid-cols-3 gap-12 md:gap-7'; ?> py-5">
            <?php
            if (!empty($type)) : ?>
            <div class="swiper-wrapper">
                <?php
                endif; ?>
                <?php
                foreach ($plans as $plan) : ?>
                    <div class="pool-plan<?php
                    echo !empty($plan['recommended']) ? ' pool-plan--recommended' : ''; ?><?php
                    echo !empty($type) ? ' swiper-slide pool-plan--carousel' : ''; ?>">
                        <?php
                        if (!empty($type) && !empty($plan['image'])) : ?>
                            <div class="pool-plan__image">
                                <?php
                                echo wp_get_attachment_image(
                                    $plan['image'],
                                    'medium',
                                ); ?>
                            </div>
                        <?php
                        endif; ?>
                        <?php
                        if (!empty($plan['recommended']) && empty($type)) : ?>
                            <div class="pool-plan__recommended">Le plus économique</div>
                        <?php
                        endif; ?>
                        <div class="pool-plan__header">
                            <div class="pool-plan__header__name"><?php
                                echo wp_kses_post($plan['name']); ?></div>
                            <?php
                            if (!empty($plan['subtitle']) && empty($type)) : ?>
                                <div class="pool-plan__header__subtitle"><?php
                                    echo wp_kses_post($plan['subtitle']); ?></div>
                            <?php
                            endif; ?>

                            <?php
                            if (!empty($plan['price']) && !empty($plan['price_unit']) && empty($type)) : ?>
                                <div class="pool-plan__header__price">
                                    <div class="pool-plan__header__price__val"><?php
                                        echo wp_kses_post($plan['price']); ?></div>
                                    <div class="pool-plan__header__price__unit">/ <?php
                                        echo wp_kses_post($plan['price_unit']); ?></div>
                                </div>
                            <?php
                            endif; ?>

                            <div class="pool-plan__header__commitment">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor"
                                     class="size-10">
                                    <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/>
                                </svg>
                                <div>
                                    <div class="pool-plan__header__commitment__val"><?php
                                        echo wp_kses_post($plan['commitment']); ?></div>
                                    <div class="pool-plan__header__commitment__price"><?php
                                        echo wp_kses_post($plan['course_price']); ?></div>
                                </div>
                            </div>
                        </div>
                        <ul class="pool-plan__features">
                            <?php
                            foreach ($plan['features'] as $feature) : ?>
                                <li><?php
                                    echo wp_kses_post($feature['item']); ?></li>
                            <?php
                            endforeach; ?>
                        </ul>


                        <?php
                        $link_or_mindbody = $plan['button']['link_or_mindbody'] ?? false;
                        $script_mindbody = $plan['button']['script_mindbody'] ?? '';
                        ?>

                        <?php
                        if ($link_or_mindbody) : ?>
                            <a href="<?php
                            echo esc_url($plan['button']['link']); ?>"
                               class="button button--base <?php
                               echo !empty($plan['recommended']) ? 'button--quinary' : 'button--quaternary'; ?>">
                                    <span><?php
                                        echo wp_kses_post($plan['button']['label']); ?></span>
                                <span class="wave" aria-hidden="true"></span>
                            </a>
                        <?php
                        elseif (!empty($script_mindbody)) : ?>
                            <div class="button button--base button--mindbody <?php
                            echo !empty($plan['recommended']) ? 'button--quinary' : 'button--quaternary'; ?>">
                                    <span><?php
                                        echo $script_mindbody; ?></span>
                                <span class="wave" aria-hidden="true"></span>
                            </div>
                        <?php
                        endif; ?>
                    </div>
                <?php
                endforeach; ?>
                <?php
                if (!empty($type)) : ?>
            </div>
            <div class="hidden lg:block">
                <button class="button-prev z-10 absolute top-0 bottom-0 left-0 cursor-pointer">
                    <svg width="160" height="613" viewBox="0 0 160 613" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="160" height="659" fill="url(#paint0_linear_4221_1118)"/>
                        <path d="M50.3508 323.85C47.2258 326.975 47.2258 332.05 50.3508 335.175L90.3508 375.175C93.4758 378.3 98.5508 378.3 101.676 375.175C104.801 372.05 104.801 366.975 101.676 363.85L67.3258 329.5L101.651 295.15C104.776 292.025 104.776 286.95 101.651 283.825C98.5258 280.7 93.4508 280.7 90.3258 283.825L50.3258 323.825L50.3508 323.85Z"
                              fill="#010F34"/>
                        <defs>
                            <linearGradient id="paint0_linear_4221_1118" x1="0" y1="329.5" x2="160" y2="329.5"
                                            gradientUnits="userSpaceOnUse">
                                <stop offset="0.25" stop-color="#E8EDFE"/>
                                <stop offset="1" stop-color="white" stop-opacity="0"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </button>
                <button class="button-next z-10 absolute top-0 bottom-0 right-0 cursor-pointer">
                    <svg width="188" height="613" viewBox="0 0 188 613" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="188" height="659" transform="matrix(-1 0 0 1 188 0)"
                              fill="url(#paint0_linear_4221_1121)"/>
                        <path d="M109.649 323.85C112.774 326.975 112.774 332.05 109.649 335.175L69.6492 375.175C66.5242 378.3 61.4492 378.3 58.3242 375.175C55.1992 372.05 55.1992 366.975 58.3242 363.85L92.6742 329.5L58.3492 295.15C55.2242 292.025 55.2242 286.95 58.3492 283.825C61.4742 280.7 66.5492 280.7 69.6742 283.825L109.674 323.825L109.649 323.85Z"
                              fill="#010F34"/>
                        <defs>
                            <linearGradient id="paint0_linear_4221_1121" x1="0" y1="329.5" x2="188" y2="329.5"
                                            gradientUnits="userSpaceOnUse">
                                <stop offset="0.25" stop-color="#E8EDFE"/>
                                <stop offset="1" stop-color="white" stop-opacity="0"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </button>
            </div>
        <?php
        endif; ?>
        </div>
    <?php
    endif; ?>
</div>
