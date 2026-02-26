<?php

declare(strict_types=1);

$coursesQuery = new WP_Query([
    'post_type' => 'course',
    'posts_per_page' => 6,
    'no_found_rows' => true,
]);

if (!$coursesQuery->have_posts()) {
    wp_reset_postdata();
    return;
}

extract($args); ?>

<div id="courses" class="container bg-blue-light py-10">
    <h2 class="text-center text-blue uppercase text-lg leading-none mb-12 font-bold"><?php
        echo wp_kses_post($title); ?></h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7 animate-fadeInUp">
        <?php
        while ($coursesQuery->have_posts()) : $coursesQuery->the_post();
            $courseID = get_the_ID();
            $groups = get_the_terms($courseID, 'group_age'); ?>
            <div class="card-hover bg-white rounded-30 flex flex-col h-full p-4">
                <a href="<?php
                the_permalink(); ?>"
                   class="overflow-hidden relative block w-full aspect-[1.68/1] grow-0 shrink-0 rounded-[15px] image-effect">
                    <?php
                    the_post_thumbnail('medium', ['class' => 'absolute inset-0 size-full object-cover object-center']
                    ); ?>
                </a>
                <div class="bg-white p-3.5 flex flex-col grow">
                    <div class="mb-3">
                        <h4 class="text-lg leading-none text-blue-dark font-extrabold"><a href="<?php
                            the_permalink(); ?>"><?php
                                the_title(); ?></a></h4>
                        <?php
                        if (!empty($groups)) :
                            $groupName = $groups[0]->name;
                            ?>
                            <a href="<?php
                            echo esc_url(get_term_link($groups[0], 'group')); ?>" class="text-violet font-bold">
                                <?php
                                echo esc_html("($groupName)"); ?>
                            </a>
                        <?php
                        endif; ?>
                    </div>
                    <div class="mt-auto flex items-end">
                        <div>
                            <div class="text-gray mb-5"><?php
                                the_excerpt(); ?></div>
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
                        <?php
                        if (!empty($groups)) :
                            $groupName = $groups[0]->name;
                            $groupImage = get_field('icon', $groups[0]);
                            if (!empty($groupImage)) :
                                ?>
                                <div class="shrink-0 w-[110px] px-2.5 py-1 transition-all">
                                    <img src="<?php
                                    echo esc_url($groupImage); ?>" alt="<?php
                                    echo esc_attr($groupName); ?>" loading="lazy">
                                </div>
                            <?php
                            endif;
                        endif; ?>
                    </div>
                </div>
            </div>
        <?php
        endwhile;
        wp_reset_postdata(); ?>
    </div>
</div>
