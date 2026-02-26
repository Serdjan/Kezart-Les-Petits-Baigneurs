<?php

declare(strict_types=1);

extract($args); ?>

<div class="section-testimonials container">
    <h2 class="text-center text-white uppercase text-lg leading-none font-bold mb-12"><?php
        echo wp_kses_post($title); ?></h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
        <?php
        foreach ($testimonials as $testimonial) : ?>
            <div class="rounded-20 bg-white p-7 flex flex-col gap-y-2">
                <p class="text-sm text-blue"><?php
                    echo wp_kses_post($testimonial['quote']); ?></p>
                <div class="flex flex-col gap-y-1 mt-auto">
                    <h3 class="text-blue-dark font-extrabold text-xl"><?php
                        echo wp_kses_post($testimonial['name']); ?></h3>
                    <p class="text-violet text-sm leading-none mb-1"><?php
                        echo wp_kses_post($testimonial['position']); ?></p>
                    <div class="flex items-center gap-x-1">
                        <?php
                        for ($rating = 1; $rating <= $testimonial['rating']; $rating++) : ?>
                            <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.92969 3.58105L12.3047 4.09668C12.6016 4.14355 12.8047 4.30762 12.9141 4.58887C12.9922 4.88574 12.9297 5.14355 12.7266 5.3623L10.2891 7.75293L10.8516 11.1982C10.8984 11.4951 10.7969 11.7373 10.5469 11.9248C10.2969 12.0967 10.0391 12.1123 9.77344 11.9717L6.75 10.3779L3.75 11.9717C3.46875 12.1123 3.20312 12.0967 2.95312 11.9248C2.71875 11.7373 2.61719 11.4951 2.64844 11.1982L3.23438 7.75293L0.796875 5.3623C0.578125 5.14355 0.515625 4.88574 0.609375 4.58887C0.703125 4.30762 0.898438 4.14355 1.19531 4.09668L4.57031 3.58105L6.07031 0.487305C6.22656 0.22168 6.45312 0.0810547 6.75 0.0654297C7.0625 0.0810547 7.28906 0.22168 7.42969 0.487305L8.92969 3.58105Z"
                                      fill="#F25B38"/>
                            </svg>
                        <?php
                        endfor; ?>
                    </div>
                </div>
            </div>
        <?php
        endforeach; ?>
    </div>
</div>
