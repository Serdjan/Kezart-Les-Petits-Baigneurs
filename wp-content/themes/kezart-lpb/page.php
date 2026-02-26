<?php

declare(strict_types=1);

get_header();

if (have_posts()) {
    echo '<div class="container">';
    while (have_posts()) : the_post();
        the_content();
    endwhile;
    echo '</div>';
}

get_footer();