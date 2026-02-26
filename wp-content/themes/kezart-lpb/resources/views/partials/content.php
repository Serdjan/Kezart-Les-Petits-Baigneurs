<?php

declare(strict_types=1);

if (empty($args['editor'])) {
    return;
} ?>

<div id="action" class="container py-20">
    <?php
    echo $args['editor']; ?>
</div>
