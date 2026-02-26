<?php

declare(strict_types=1);

if (is_null($args)) {
    return;
}

extract($args);

$link = match ($custom_link) {
    'page-link' => $link,
    'url' => $url,
    default => !empty($link) ? $link : '',
};

$mindbody = $custom_link === 'mindbody';
$tag = $custom_link !== 'mindbody' ? 'a' : 'div';

if ($mindbody && empty($script_mindbody)) {
    return;
}

if (!$mindbody && empty($link)) {
    return;
} ?>

<<?php
echo $tag; ?> <?php
echo empty($mindbody) ? 'href="' . esc_url($link) . '"' : ''; ?> class="button <?php
echo match ($size) {
    'small' => 'button--sm',
    default => 'button--base',
}; ?> <?php
echo match ($type) {
    'secondary' => 'button--secondary',
    'tertiary' => 'button--tertiary',
    'quaternary' => 'button--quaternary',
    'quinary' => 'button--quinary',
    default => 'button--primary',
}; ?> <?php
echo !empty($class) ? $class : ''; ?>">
<span>
        <?php
        if (empty($mindbody)) : ?>
            <?php
            echo esc_html(wp_strip_all_tags($label)); ?>
        <?php
        else : ?>
            <?php
            echo $script_mindbody; ?>
        <?php
        endif; ?>
    </span>
<span class="wave" aria-hidden="true"></span>
<?php
if (!empty($has_icon)) : ?>
    <svg width="10" height="7" viewBox="0 0 10 7" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M4.91016 5.90234L1.19141 2.18359C0.917969 1.91016 0.917969 1.5 1.19141 1.25391L1.79297 0.625C2.06641 0.378906 2.47656 0.378906 2.72266 0.625L5.34766 3.27734L8 0.625C8.24609 0.378906 8.65625 0.378906 8.92969 0.625L9.53125 1.25391C9.80469 1.5 9.80469 1.91016 9.53125 2.18359L5.8125 5.90234C5.56641 6.14844 5.15625 6.14844 4.91016 5.90234Z"
              fill="white"/>
    </svg>
<?php
endif; ?>
</<?php
echo $tag; ?>>
