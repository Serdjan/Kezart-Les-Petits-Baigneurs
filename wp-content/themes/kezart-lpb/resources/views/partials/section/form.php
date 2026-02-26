<?php

declare(strict_types=1);

if (empty($args['shortcode'])) {
    return;
} ?>

<div id="form" class="mx-auto max-w-3xl w-full">
    <?php
    echo do_shortcode($args['shortcode']); ?>
</div>