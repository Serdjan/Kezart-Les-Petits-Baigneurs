<?php

declare(strict_types=1);

use RS\Theme\App\Helpers;

$courseID = get_queried_object_id();

$pools = get_field('course_pools');
$buttons = get_field('course_buttons');
$duration = get_field('course_duration');
$size = get_the_terms($courseID, 'group_size');
$coach = get_the_terms($courseID, 'group_coach');
$age = get_the_terms($courseID, 'group_age');
$aboveTitle = get_field('course_above_title');

get_header(); ?>

    <div class="hero relative -mt-[2.1875rem] isolate overflow-hidden">
        <div class="absolute right-0 bottom-0 left-0 z-10 h-[4.25rem] w-full bg-repeat-x bg-center" aria-hidden="true"
             style="background-image: url('<?php
             echo esc_url(get_theme_file_uri('resources/images/vagues.svg')); ?>');"></div>
        <div class="absolute right-0 bottom-0 left-0 z-20 w-full bg-[#E8F0FE] h-8" aria-hidden="true"></div>
        <div class="relative max-w-[1530px] mx-auto overflow-hidden rounded-30 drop-shadow-(--drop-shadow-hero)">
            <?php
            if (has_post_thumbnail()) :
                the_post_thumbnail(
                    'full',
                    ['class' => 'absolute inset-0 size-full object-cover object-center']
                );
            endif; ?>
            <span aria-hidden="true" class="bg-blue-dark/70 lg:bg-blue-dark/50 absolute inset-0"></span>
            <div class="flex flex-col justify-center text-white px-5 lg:px-40 pt-40 pb-32 lg:pt-[300px] lg:pb-[160px] max-w-[980px] relative z-10 gap-y-5">
                <?php
                if (!empty($aboveTitle)) : ?>
                    <div class="uppercase font-bold text-lg leading-none">
                        <span><?php
                            echo wp_kses_post($aboveTitle); ?></span>
                    </div>
                <?php
                endif; ?>

                <h2 class="font-extrabold text-32 lg:text-[64px] lg:leading-[59px] -tracking-[1px]"><?php
                    the_title(); ?></h2>

                <?php
                if (!empty($age)) : $age = $age[0]->name; ?>
                    <div class="text-xl leading-normal"><?php
                        echo wp_kses_post($age); ?></div>
                <?php
                endif; ?>

                <div class="text-xl leading-normal mb-1.5"><?php
                    the_excerpt(); ?></div>

                <div class="flex flex-col sm:flex-row sm:items-center gap-6 text-base font-bold uppercase text-white">
                    <?php
                    if (!empty($duration)) : ?>
                        <div class="inline-flex items-center gap-2.5">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M8 0.25C3.71875 0.25 0.25 3.71875 0.25 8C0.25 12.2812 3.71875 15.75 8 15.75C12.2812 15.75 15.75 12.2812 15.75 8C15.75 3.71875 12.2812 0.25 8 0.25ZM5.125 10.0312C5.0625 9.96875 5 9.84375 5 9.71875C5 9.5625 5.09375 9.4375 5.1875 9.34375L7 8V3.5C7 3.25 7.25 3 7.5 3H8.5C8.78125 3 9 3.25 9 3.5V8.375C9 8.78125 8.84375 9.125 8.53125 9.34375L6.4375 10.9062C6.375 10.9688 6.25 11.0312 6.15625 11.0312C5.96875 11.0312 5.84375 10.9375 5.75 10.8125L5.125 10.0312Z"
                                      fill="white"/>
                            </svg>
                            <span><?php
                                echo wp_kses_post($duration); ?></span>
                        </div>
                    <?php
                    endif; ?>

                    <?php
                    if (!empty($size)) :
                        $size = $size[0]->name; ?>
                        <div class="inline-flex items-center gap-2.5">
                            <svg width="21" height="14" viewBox="0 0 21 14" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.5 6C18.625 6 19.5 5.125 19.5 4C19.5 2.90625 18.625 2 17.5 2C16.4062 2 15.5 2.90625 15.5 4C15.5 5.125 16.4062 6 17.5 6ZM3.5 6C4.625 6 5.5 5.125 5.5 4C5.5 2.90625 4.625 2 3.5 2C2.40625 2 1.5 2.90625 1.5 4C1.5 5.125 2.40625 6 3.5 6ZM2.5 7C1.40625 7 0.5 7.90625 0.5 9V10C0.5 10.5625 0.96875 11 1.5 11H3.5625C3.78125 9.53125 4.65625 8.28125 5.9375 7.59375C5.5625 7.25 5.0625 7 4.5 7H2.5ZM10.5 7C12.4375 7 14 5.4375 14 3.5C14 1.59375 12.4375 0 10.5 0C8.59375 0 7 1.59375 7 3.5C7 5.4375 8.59375 7 10.5 7ZM8.125 8C6.125 8 4.5 9.625 4.5 11.625V12.5C4.5 13.3438 5.1875 14 6 14H15C15.8438 14 16.5 13.3438 16.5 12.5V11.625C16.5 9.625 14.9062 8 12.9062 8H12.6562C12 8.3125 11.2812 8.5 10.5 8.5C9.75 8.5 9.03125 8.3125 8.375 8H8.125ZM15.0938 7.59375C16.375 8.28125 17.25 9.53125 17.4688 11H19.5C20.0625 11 20.5 10.5625 20.5 10V9C20.5 7.90625 19.625 7 18.5 7H16.5C15.9688 7 15.4688 7.25 15.0938 7.59375Z"
                                      fill="white"/>
                            </svg>
                            <span><?php
                                echo wp_kses_post($size); ?></span>
                        </div>
                    <?php
                    endif; ?>

                    <?php
                    if (!empty($coach)) :
                        $coach = $coach[0]->name; ?>
                        <div class="inline-flex items-center gap-2.5">
                            <svg width="20" height="11" viewBox="0 0 20 11" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.0938 7.71875C14.25 7.5625 14.4062 7.46875 14.5938 7.34375L12.4375 4.28125C12.2188 3.96875 11.9375 3.6875 11.5938 3.46875L9.09375 1.65625C8.3125 1.09375 7.3125 0.875 6.34375 1.09375L3.1875 1.75C2.40625 1.9375 1.875 2.75 2.0625 3.53125C2.21875 4.34375 3.03125 4.875 3.84375 4.6875L6.96875 4.03125C7.09375 4 7.25 4.03125 7.375 4.09375L7.9375 4.5L4.40625 7.03125C4.9375 7.0625 5.46875 7.28125 5.9375 7.71875C6.0625 7.8125 6.40625 8 7 8C7.625 8 7.96875 7.8125 8.09375 7.71875C8.59375 7.25 9.15625 7 9.75 7H10.2812C10.875 7 11.4375 7.25 11.9375 7.71875C12.0625 7.8125 12.4062 8 13 8C13.625 8 13.9688 7.8125 14.0938 7.71875ZM0.5 9C0.25 9 0 9.25 0 9.5V10.5C0 10.7812 0.25 11 0.5 11H1C2.21875 11 3.28125 10.625 4 10.0312C4.75 10.625 5.8125 11 7 11C8.21875 11 9.28125 10.625 10 10.0312C10.75 10.625 11.8125 11 13 11C14.2188 11 15.2812 10.625 16 10.0312C16.75 10.625 17.8125 11 19 11H19.5C19.7812 11 20 10.7812 20 10.5V9.5C20 9.25 19.7812 9 19.5 9H19C18.1875 9 17.5938 8.75 17.25 8.46875C17 8.1875 16.6562 8 16.2812 8H15.75C15.375 8 15.0312 8.1875 14.7812 8.46875C14.4375 8.75 13.8438 9 13 9C12.1875 9 11.5938 8.75 11.25 8.46875C11 8.1875 10.6562 8 10.2812 8H9.75C9.375 8 9.03125 8.1875 8.78125 8.46875C8.4375 8.75 7.84375 9 7 9C6.1875 9 5.59375 8.75 5.25 8.46875C5 8.1875 4.65625 8 4.28125 8H3.75C3.375 8 3.03125 8.1875 2.78125 8.46875C2.4375 8.75 1.84375 9 1 9H0.5ZM16.5 6C17.9062 6 19 4.90625 19 3.5C19 2.125 17.9062 1 16.5 1C15.125 1 14 2.125 14 3.5C14 4.90625 15.125 6 16.5 6Z"
                                      fill="white"/>
                            </svg>
                            <span><?php
                                echo wp_kses_post($coach); ?></span>
                        </div>
                    <?php
                    endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container pt-6 pb-28">
        <div class="text-lg leading-none uppercase font-bold text-blue text-center mb-20" aria-hidden="true"><?php
            the_title(); ?></div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <div class="prose-xl max-w-none text-blue prose-headings:font-extrabold prose-img:rounded-20">
                <?php
                the_content(); ?>
            </div>
            <?php
            if (!empty($pools)) : ?>
                <div>
                    <div class="sticky <?php
                    echo is_admin_bar_showing() ? 'top-8' : 'top-5'; ?>">
                        <div class="bg-white rounded-20 p-[30px] mb-10 flex flex-col gap-7">
                            <h3 class="text-blue-dark font-semibold text-2xl">Nos piscines partenaire qui propose ce
                                programme</h3>
                            <div class="flex flex-col gap-4">
                                <?php
                                foreach ($pools as $poolID) :
                                    $address = get_field('pool_location', $poolID);
                                    $rating = get_field('pool_rating', $poolID); ?>
                                    <article id="pool-<?php
                                    the_ID(); ?>" <?php
                                    post_class(
                                        'relative bg-blue-light sm:py-7 rounded-[10px] overflow-hidden w-full'
                                    ); ?>>
                                        <a href="<?php
                                        echo esc_url(get_permalink($poolID)); ?>" aria-hidden="true"
                                           class="absolute inset-0 z-10"><span class="sr-only">View Pool</span></a>
                                        <div class="hidden absolute top-4 right-7 sm:flex items-center gap-1">
                                            <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10.9634 3.34014C10.4219 2.05296 8.57749 2.05296 8.03598 3.34014L6.64759 6.64039L3.04381 6.92603C1.63825 7.03743 1.06832 8.77163 2.13921 9.67855L4.8849 12.0039L4.04604 15.4806C3.71887 16.8367 5.21099 17.9085 6.41434 17.1818L9.49967 15.3187L12.585 17.1818C13.7884 17.9085 15.2805 16.8367 14.9533 15.4806L14.1145 12.0039L16.8601 9.67855C17.931 8.77162 17.3611 7.03743 15.9555 6.92603L12.3518 6.64039L10.9634 3.34014Z"
                                                      fill="#F25B38"/>
                                            </svg>
                                            <span class="text-lg font-bold text-gray-dark relative top-0.5"><?php
                                                echo $rating; ?></span>
                                        </div>
                                        <?php
                                        if (has_post_thumbnail($poolID)) : ?>
                                            <div class="relative sm:absolute top-0 left-0 bottom-0 aspect-[1.5/1] sm:w-[188px]">
                                                <?php
                                                echo get_the_post_thumbnail(
                                                    $poolID,
                                                    'medium',
                                                    ['class' => 'absolute inset-0 size-full object-cover object-center']
                                                ); ?>
                                            </div>
                                        <?php
                                        endif; ?>
                                        <div class="p-4 sm:py-4 sm:max-w-[200px] sm:ml-[218px]">
                                            <h4 class="text-lg font-extrabold text-blue-dark mb-4"><?php
                                                echo get_the_title($poolID); ?></h4>
                                            <div class="flex flex-col text-lg text-blue">
                                                <?php
                                                if (!empty($address['name'])) : ?>
                                                    <span><?php
                                                        echo esc_html(wp_strip_all_tags($address['name'])); ?></span>
                                                <?php
                                                endif; ?>
                                                <?php
                                                if (!empty($address['post_code']) && !empty($address['city'])) : ?>
                                                    <span><?php
                                                        echo esc_html(
                                                            wp_strip_all_tags(
                                                                $address['post_code'] . ', ' . $address['city']
                                                            )
                                                        ); ?></span>
                                                <?php
                                                endif; ?>
                                            </div>
                                        </div>
                                    </article>
                                <?php
                                endforeach; ?>
                            </div>
                        </div>
                        <?php
                        if (!empty($buttons)) : ?>
                            <div class="flex flex-col gap-y-4">
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
            <?php
            endif; ?>
        </div>

        <?php
        Helpers::getPartialsFromBlueprints('option', [], 'course_blueprints'); ?>
    </div>

<?php
get_footer();