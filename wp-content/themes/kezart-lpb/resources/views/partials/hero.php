<?php

declare(strict_types=1);

extract($args);

$uploadsDir = wp_get_upload_dir();
$pageID = !empty($pageID) ? $pageID : null; ?>

<div class="hero relative -mt-[2.1875rem] isolate overflow-hidden">
    <div class="absolute right-0 bottom-0 left-0 z-10 h-[4.25rem] w-full bg-repeat-x bg-center bg-vagues"
         aria-hidden="true" style="background-image: url('<?php
    echo esc_url(get_theme_file_uri('resources/images/vagues.svg')); ?>');"></div>
    <div class="poisson-container">
        <img src="<?php
        echo !empty($icon) ? esc_url($icon) : $uploadsDir['baseurl'] . '/2025/05/minis.png'; ?>" alt="poisson"
             class="poisson">
    </div>
    <div class="absolute right-0 bottom-0 left-0 z-20 w-full bg-[#E8F0FE] h-8" aria-hidden="true"></div>
    <div class="relative max-w-[1530px] mx-auto overflow-hidden rounded-30 drop-shadow-(--drop-shadow-hero)">
        <?php
        if (has_post_thumbnail($pageID)) :
            echo get_the_post_thumbnail(
                $pageID,
                'full',
                ['class' => 'absolute inset-0 size-full object-cover object-center']
            );
        endif; ?>
        <span aria-hidden="true" class="bg-blue-dark/70 lg:bg-blue-dark/50 absolute inset-0"></span>
        <div class="flex flex-col justify-center text-white px-5 lg:px-40 pt-40 pb-32 lg:pt-[300px] lg:pb-[160px] lg:max-w-[980px] relative z-10 gap-y-5">
            <div class="uppercase flex flex-wrap items-center gap-x-1 gap-y-5 font-bold text-lg leading-none animation-lines [&>div]:!flex [&>div]:!gap-x-1 [&>div]:!items-center">
                <svg width="21" height="12" viewBox="0 0 21 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.0400391 3.67233C0.0400391 3.78033 0.0506931 3.88833 0.0684498 4.00083C0.210503 4.77483 0.821333 5.25633 1.43216 5.07633C2.30224 4.81983 3.02671 4.33383 3.49904 3.95133C4.53248 4.64883 5.68666 5.11233 6.85861 5.11233C7.99148 5.11233 9.01072 4.66683 9.71388 4.26183C9.91986 4.14033 10.1081 4.02333 10.2679 3.91533C10.4277 4.02333 10.6124 4.14483 10.8219 4.26183C11.5251 4.66683 12.5443 5.11233 13.6772 5.11233C14.8491 5.11233 16.0033 4.64883 17.0332 3.95133C17.5091 4.32933 18.23 4.81983 19.1001 5.07633C19.7109 5.25633 20.3217 4.77483 20.4638 4.00083C20.4851 3.89283 20.4922 3.78033 20.4922 3.67233C20.4922 3.01983 20.1371 2.42583 19.615 2.27283C18.9722 2.08383 18.3294 1.67433 17.818 1.13884C17.4238 0.715835 16.8485 0.684334 16.4259 1.06233C15.6446 1.74633 14.6325 2.23233 13.6772 2.23233C12.7006 2.23233 11.7239 1.75533 10.9249 1.05783C10.5307 0.702334 10.0051 0.702334 9.61089 1.05783C8.81184 1.75533 7.83522 2.23233 6.85861 2.23233C5.9033 2.23233 4.89472 1.74633 4.10987 1.05783C3.68371 0.675334 3.11195 0.706835 2.71775 1.13433C2.20635 1.66983 1.56356 2.07933 0.920771 2.26833C0.395173 2.42583 0.0400391 3.01533 0.0400391 3.67233Z"
                          fill="white"/>
                    <path d="M0.0400391 9.67233C0.0400391 9.78033 0.0506931 9.88833 0.0684498 10.0008C0.210503 10.7748 0.821333 11.2563 1.43216 11.0763C2.30224 10.8198 3.02671 10.3338 3.49904 9.95133C4.53248 10.6488 5.68666 11.1123 6.85861 11.1123C7.99148 11.1123 9.01072 10.6668 9.71388 10.2618C9.91986 10.1403 10.1081 10.0233 10.2679 9.91533C10.4277 10.0233 10.6124 10.1448 10.8219 10.2618C11.5251 10.6668 12.5443 11.1123 13.6772 11.1123C14.8491 11.1123 16.0033 10.6488 17.0332 9.95133C17.5091 10.3293 18.23 10.8198 19.1001 11.0763C19.7109 11.2563 20.3217 10.7748 20.4638 10.0008C20.4851 9.89283 20.4922 9.78033 20.4922 9.67233C20.4922 9.01983 20.1371 8.42583 19.615 8.27283C18.9722 8.08383 18.3294 7.67433 17.818 7.13884C17.4238 6.71584 16.8485 6.68433 16.4259 7.06233C15.6446 7.74633 14.6325 8.23233 13.6772 8.23233C12.7006 8.23233 11.7239 7.75533 10.9249 7.05783C10.5307 6.70233 10.0051 6.70233 9.61089 7.05783C8.81184 7.75533 7.83522 8.23233 6.85861 8.23233C5.9033 8.23233 4.89472 7.74633 4.10987 7.05783C3.68371 6.67533 3.11195 6.70683 2.71775 7.13433C2.20635 7.66983 1.56356 8.07933 0.920771 8.26833C0.395173 8.42583 0.0400391 9.01533 0.0400391 9.67233Z"
                          fill="white"/>
                </svg>
                <span><?php
                    echo esc_html(get_bloginfo('name')); ?></span>
                <span> - </span>
                <span>
                    <?php
                    if (is_archive()) {
                        echo get_the_archive_title();
                    } else {
                        echo get_the_title($pageID);
                    }
                    ?>
                </span>
            </div>

            <?php
            if (!empty($title)) :
                if (is_singular('post')) {
                    $title = get_the_title(get_queried_object_id());
                } ?>
                <h2 class="font-extrabold text-4xl sm:text-52 leading-none lg:text-[64px] lg:leading-[59px] -tracking-[1px] animation-lines"><?php
                    echo esc_html(wp_strip_all_tags($title)); ?></h2>
            <?php
            endif; ?>

            <?php
            if (!empty($subtitle)) :
                if (is_singular('post')) {
                    $subtitle = get_the_excerpt();
                } ?>
                <p class="text-lg lg:text-xl leading-normal mb-1.5 animation-lines"><?php
                    echo esc_html(wp_strip_all_tags($subtitle)); ?></p>
            <?php
            endif; ?>

            <?php
            if (!empty($buttons)) : ?>
                <div class="flex flex-col lg:flex-row items-start lg:items-center gap-4 animation-lines">
                    <?php
                    foreach ($buttons as $button) {
                        get_template_part(
                            'resources/views/partials/components/button',
                            null,
                            $button['button'],
                        );
                    } ?>
                </div>
            <?php
            endif; ?>
        </div>
    </div>
</div>

<?php
// Promo section from ACF Global Components
$promo_activate = get_option('global_components_promo_activate');
$promo_link = maybe_unserialize(get_option('global_components_promo_content_promo_link'));
$promo_img_id = get_option('global_components_promo_content_promo_img');

if ($promo_activate && !empty($promo_img_id)) :
    $promo_img = wp_get_attachment_image_src($promo_img_id, 'full');
    $promo_img_alt = get_post_meta($promo_img_id, '_wp_attachment_image_alt', true);

    if (!empty($promo_img)) : ?>
        <div class="promo">
            <?php if (!empty($promo_link) && !empty($promo_link['url'])) : ?>
                <a href="<?php echo esc_url($promo_link['url']); ?>"
                   <?php if (!empty($promo_link['target'])) : ?>target="<?php echo esc_attr($promo_link['target']); ?>"<?php endif; ?>
                   <?php if (!empty($promo_link['title'])) : ?>aria-label="<?php echo esc_attr($promo_link['title']); ?>"<?php endif; ?>>
                    <img src="<?php echo esc_url($promo_img[0]); ?>"
                         alt="<?php echo esc_attr($promo_img_alt ?: 'Promotion'); ?>"
                         width="<?php echo esc_attr($promo_img[1]); ?>"
                         height="<?php echo esc_attr($promo_img[2]); ?>">
                </a>
            <?php else : ?>
                <img src="<?php echo esc_url($promo_img[0]); ?>"
                     alt="<?php echo esc_attr($promo_img_alt ?: 'Promotion'); ?>"
                     width="<?php echo esc_attr($promo_img[1]); ?>"
                     height="<?php echo esc_attr($promo_img[2]); ?>">
            <?php endif; ?>
        </div>
    <?php endif;
endif; ?>
