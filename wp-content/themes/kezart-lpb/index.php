<?php

declare(strict_types=1);

use RS\Theme\App\Helpers;

get_header();

$pageID = get_option('page_for_posts');
Helpers::getPartialsFromBlueprints($pageID, ['hero',]); ?>

    <div id="main" class="container pt-6 pb-28">
        <div class="text-lg leading-none uppercase font-bold text-blue text-center mb-20">
            <?php
            if (is_archive()) :
                the_archive_title();
            else : ?>
                blog et conseils
            <?php
            endif; ?>
        </div>

        <div class="lg:grid lg:grid-cols-12 lg:gap-10 lg:px-[30px]">
            <div class="lg:col-span-8 flex flex-col gap-11">
                <?php
                if (have_posts()) : ?>
                    <?php
                    while (have_posts()) : the_post();
                        $authorID = get_the_author_meta('ID');
                        $author = get_userdata($authorID);
                        ?>
                        <article id="post-<?php
                        the_ID(); ?>" <?php
                        post_class('overflow-hidden rounded-[20px] flex flex-col'); ?>>
                            <a href="<?php
                            the_permalink(); ?>" class="relative block w-full aspect-[1.98/1] grow-0 shrink-0">
                                <?php
                                the_post_thumbnail(
                                    'medium',
                                    ['class' => 'absolute inset-0 size-full object-cover object-center']
                                ); ?>
                            </a>
                            <div class="bg-white p-10 flex flex-col grow">
                                <div class="flex flex-wrap items-center gap-4 lg:gap-10 mb-5">
                                    <a href="<?php
                                    echo get_author_posts_url($authorID); ?>"
                                       class="flex items-center gap-1 text-sm text-violet">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                             class="size-4 text-blue" fill="currentColor">
                                            <path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464l349.5 0c-8.9-63.3-63.3-112-129-112l-91.4 0c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3z"/>
                                        </svg>
                                        <span><?php
                                            echo sprintf(
                                                __('By %s', 'kezart-lpb'),
                                                $author->display_name,
                                            ); ?></span>
                                    </a>

                                    <div class="flex items-center gap-1 text-sm text-violet">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                             fill="currentColor" class="size-4 text-blue">
                                            <path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 40L64 64C28.7 64 0 92.7 0 128l0 16 0 48L0 448c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-256 0-48 0-16c0-35.3-28.7-64-64-64l-40 0 0-40c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 40L152 64l0-40zM48 192l352 0 0 256c0 8.8-7.2 16-16 16L64 464c-8.8 0-16-7.2-16-16l0-256z"/>
                                        </svg>
                                        <span><?php
                                            echo get_the_time(get_option('date_format')); ?></span>
                                    </div>

                                    <?php
                                    if (comments_open()) : ?>
                                        <a href="<?php
                                        echo get_permalink() . '#comments'; ?>"
                                           class="flex items-center gap-1 text-sm text-violet">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"
                                                 class="size-4 text-blue" fill="currentColor">
                                                <path d="M88.2 309.1c9.8-18.3 6.8-40.8-7.5-55.8C59.4 230.9 48 204 48 176c0-63.5 63.8-128 160-128s160 64.5 160 128s-63.8 128-160 128c-13.1 0-25.8-1.3-37.8-3.6c-10.4-2-21.2-.6-30.7 4.2c-4.1 2.1-8.3 4.1-12.6 6c-16 7.2-32.9 13.5-49.9 18c2.8-4.6 5.4-9.1 7.9-13.6c1.1-1.9 2.2-3.9 3.2-5.9zM208 352c114.9 0 208-78.8 208-176S322.9 0 208 0S0 78.8 0 176c0 41.8 17.2 80.1 45.9 110.3c-.9 1.7-1.9 3.5-2.8 5.1c-10.3 18.4-22.3 36.5-36.6 52.1c-6.6 7-8.3 17.2-4.6 25.9C5.8 378.3 14.4 384 24 384c43 0 86.5-13.3 122.7-29.7c4.8-2.2 9.6-4.5 14.2-6.8c15.1 3 30.9 4.5 47.1 4.5zM432 480c16.2 0 31.9-1.6 47.1-4.5c4.6 2.3 9.4 4.6 14.2 6.8C529.5 498.7 573 512 616 512c9.6 0 18.2-5.7 22-14.5c3.8-8.8 2-19-4.6-25.9c-14.2-15.6-26.2-33.7-36.6-52.1c-.9-1.7-1.9-3.4-2.8-5.1C622.8 384.1 640 345.8 640 304c0-94.4-87.9-171.5-198.2-175.8c4.1 15.2 6.2 31.2 6.2 47.8l0 .6c87.2 6.7 144 67.5 144 127.4c0 28-11.4 54.9-32.7 77.2c-14.3 15-17.3 37.6-7.5 55.8c1.1 2 2.2 4 3.2 5.9c2.5 4.5 5.2 9 7.9 13.6c-17-4.5-33.9-10.7-49.9-18c-4.3-1.9-8.5-3.9-12.6-6c-9.5-4.8-20.3-6.2-30.7-4.2c-12.1 2.4-24.8 3.6-37.8 3.6c-61.7 0-110-26.5-136.8-62.3c-16 5.4-32.8 9.4-50 11.8C279 439.8 350 480 432 480z"/>
                                            </svg>
                                            <span><?php
                                                echo sprintf(
                                                    __('Comments (%s)', 'kezart-lpb'),
                                                    get_comments_number(),
                                                ); ?></span>
                                        </a>
                                    <?php
                                    endif; ?>
                                </div>
                                <h4 class="text-3xl text-blue-dark font-bold mb-7"><a href="<?php
                                    the_permalink(); ?>"><?php
                                        the_title(); ?></a></h4>
                                <div class="mb-7 text-base text-blue">
                                    <?php
                                    the_excerpt(); ?>
                                </div>
                                <div>
                                    <?php
                                    get_template_part(
                                        'resources/views/partials/components/button',
                                        null,
                                        [
                                            'link' => get_permalink(),
                                            'size' => 'small',
                                            'type' => 'primary',
                                            'label' => 'En savoir plus',
                                        ]
                                    ); ?>
                                </div>
                            </div>
                        </article>
                    <?php
                    endwhile; ?>
                    <?php
                    the_posts_pagination([
                        'prev_text' => '<svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.71875 0.71875L0.21875 5.96875C0.0729167 6.11458 0 6.29167 0 6.5C0 6.70833 0.0729167 6.88542 0.21875 7.03125L5.71875 12.2812C6.09375 12.5729 6.44792 12.5729 6.78125 12.2812C7.07292 11.9062 7.07292 11.5521 6.78125 11.2188L2.625 7.25H13.25C13.7083 7.20833 13.9583 6.95833 14 6.5C13.9583 6.04167 13.7083 5.79167 13.25 5.75H2.625L6.78125 1.78125C7.07292 1.44792 7.07292 1.09375 6.78125 0.71875C6.44792 0.427083 6.09375 0.427083 5.71875 0.71875Z" fill="#3D4BA8"/></svg>',
                        'next_text' => '<svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.28125 0.71875L13.7812 5.96875C13.9271 6.11458 14 6.29167 14 6.5C14 6.70833 13.9271 6.88542 13.7812 7.03125L8.28125 12.2812C7.90625 12.5729 7.55208 12.5729 7.21875 12.2812C6.92708 11.9062 6.92708 11.5521 7.21875 11.2188L11.375 7.25H0.75C0.291667 7.20833 0.0416667 6.95833 0 6.5C0.0416667 6.04167 0.291667 5.79167 0.75 5.75H11.375L7.21875 1.78125C6.92708 1.44792 6.92708 1.09375 7.21875 0.71875C7.55208 0.427083 7.90625 0.427083 8.28125 0.71875Z" fill="#3D4BA8"/></svg>',
                    ]); ?>
                <?php
                else : ?>
                <?php
                endif; ?>
            </div>
            <div class="mt-10 lg:mt-0 lg:col-span-4">
                <div class="sidebar-blog lg:sticky <?php
                echo is_admin_bar_showing() ? 'lg:top-8' : 'lg:top-0'; ?>">
                    <?php
                    dynamic_sidebar('sidebar-blog'); ?>
                </div>
            </div>
        </div>
    </div>

<?php
get_footer();
