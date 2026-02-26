<?php

declare(strict_types=1);

$className = !empty($block['className']) ? 'example ' . esc_attr($block['className']) : 'example';
$className = !empty($block['align']) ? $className . ' align' . esc_attr($block['align']) : $className;

$anchor = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : ''; ?>

<div <?php
echo $anchor; ?> class="<?php
echo esc_attr($className); ?>">
    Example block!
</div>