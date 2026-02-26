<?php

declare(strict_types=1);

use RS\Theme\App\Helpers;

$hours = get_field('pool_hours');
$course = get_field('pool_course');
$parking = get_field('pool_parking');
$icon = get_field('pool_animation_icon');
$external = get_field('pool_external_scripts');
$links = get_field('pool_additional_links');

get_header(); ?>

    <div class="hero relative -mt-[2.1875rem] isolate overflow-hidden">
        <div class="absolute right-0 bottom-0 left-0 z-10 h-[4.25rem] w-full bg-repeat-x bg-center bg-vagues"
             aria-hidden="true"
             style="background-image: url('<?php
             echo esc_url(get_theme_file_uri('resources/images/vagues.svg')); ?>');"></div>
        <?php
        if (!empty($icon)) : ?>
            <div class="poisson-container">
                <img src="<?php
                echo esc_url($icon); ?>" alt="poisson" class="poisson">
            </div>
        <?php
        endif; ?>
        <div class="absolute right-0 bottom-0 left-0 z-20 w-full bg-[#E8F0FE] h-8" aria-hidden="true"></div>
        <div class="relative max-w-[1530px] mx-auto overflow-hidden rounded-30 drop-shadow-(--drop-shadow-hero)">
            <?php
            if (has_post_thumbnail()) :
                the_post_thumbnail(
                    'full',
                    ['class' => 'absolute inset-0 size-full object-cover object-center']
                );
            endif; ?>
            <span aria-hidden="true" class="bg-blue-dark/50 absolute inset-0"></span>
            <div class="text-white px-5 lg:px-40 pt-40 pb-32 lg:pt-[300px] lg:pb-[160px] relative z-10">
                <div class="max-w-[660px] flex flex-col gap-y-8 mb-10">
                    <h2 class="font-extrabold text-52 lg:text-[64px] lg:leading-[59px] -tracking-[1px] animation-lines"><?php
                        the_title(); ?></h2>

                    <div class="text-xl leading-normal mb-1.5 animation-lines"><?php
                        the_excerpt(); ?></div>
                </div>
                <div class="overflow-hidden rounded-20 grid grid-cols-1 sm:grid-cols-3 gap-px text-blue">
                    <div class="bg-white py-5 px-8">
                        <div class="text-xl lg:text-2xl leading-8 mb-1.5 font-extrabold text-blue-dark"><?php
                            echo wp_kses_post($hours['title']); ?></div>
                        <p class="font-bold sm:max-w-[300px]"><?php
                            echo wp_kses_post($hours['content']); ?></p>
                    </div>
                    <div class="bg-white py-5 px-8">
                        <div class="text-xl lg:text-2xl leading-8 mb-1.5 font-extrabold text-blue-dark"><?php
                            echo wp_kses_post($course['title']); ?></div>
                        <p class="sm:max-w-[300px] text-sm"><?php
                            echo wp_kses_post($course['content']); ?></p>
                    </div>
                    <div class="bg-white py-5 px-8">
                        <div class="text-xl lg:text-2xl leading-8 mb-1.5 font-extrabold text-blue-dark"><?php
                            echo wp_kses_post($parking['title']); ?></div>
                        <p class="sm:max-w-[300px] text-sm"><?php
                            echo wp_kses_post($parking['content']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div x-data x-tabs default-index="1">
        <div x-tabs:list class="flex flex-wrap items-center justify-center gap-4 sm:gap-6 px-4">
            <button x-tabs:tab type="button"
                    :class="$tab.isSelected ? 'button--tertiary' : 'button--quaternary'"
                    class="button button--base button--orange-hover"><span>Réserver un cours</span>
                <span class="wave" aria-hidden="true"></span>
            </button>
            <button x-tabs:tab type="button"
                    :class="$tab.isSelected ? 'button--tertiary' : 'button--quaternary'"
                    class="button button--base button--orange-hover"><span>voir nos tarifs</span>
                <span class="wave" aria-hidden="true"></span>
            </button>
            <?php if (!empty($links)) : ?>
                <?php foreach ($links as $item) :
                    $link = $item['link'];
                    if (!empty($link)) :
                        $link_url = $link['url'];
                        $link_title = $link['title'];
                        $link_target = !empty($link['target']) ? $link['target'] : '_self';
                ?>
                <a class="button button--base button--orange-hover button--tertiary"
                   href="<?php echo esc_url($link_url); ?>"
                   target="<?php echo esc_attr($link_target); ?>">
                    <span><?php echo esc_html($link_title); ?></span>
                    <span class="wave" aria-hidden="true"></span>
                </a>
                <?php
                    endif;
                endforeach; ?>
            <?php endif; ?>
        </div>

        <div x-tabs:panels>
            <div x-tabs:panel>
                <div class="container py-12">
                    <?php
                    echo get_field('pool_code'); ?>
                </div>
            </div>
            <div x-tabs:panel class="pb-10">
                <?php
                Helpers::getPartialsFromBlueprints(); ?>
            </div>
        </div>
    </div>

<?php
if (!empty($external)) {
    echo $external;
} ?>

<?php
get_footer();
