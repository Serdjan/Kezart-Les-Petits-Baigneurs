<?php

declare(strict_types=1);

$blogQuery = new WP_Query([
    'post_type' => 'post',
    'posts_per_page' => 3,
    'no_found_rows' => true,
]);

if (!$blogQuery->have_posts()) {
    wp_reset_postdata();
    return;
}

extract($args); ?>

<div id="blog" class="blog container py-10 lg:py-30 animate-fadeInUp">
    <h2 class="text-center text-blue uppercase text-lg leading-none mb-12 font-bold"><?php
        echo wp_kses_post($title); ?></h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
        <?php
        while ($blogQuery->have_posts()) : $blogQuery->the_post(); ?>
            <div class="card-hover overflow-hidden rounded-20 flex flex-col h-full">
                <a href="<?php
                the_permalink(); ?>" class="relative block w-full aspect-[1.548/1] grow-0 shrink-0 image-effect">
                    <?php
                    the_post_thumbnail('medium', ['class' => 'absolute inset-0 size-full object-cover object-center']
                    ); ?>
                </a>
                <div class="bg-white p-7 flex flex-col grow">
                    <h4 class="text-lg text-blue-dark font-bold mb-9"><a href="<?php
                        the_permalink(); ?>"><?php
                            the_title(); ?></a></h4>
                    <div class="mt-auto">
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
            </div>
        <?php
        endwhile;
        wp_reset_postdata(); ?>
    </div>
</div>
