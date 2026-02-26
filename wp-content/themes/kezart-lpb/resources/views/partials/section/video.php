<?php

declare(strict_types=1);

extract($args);

if (empty($video_code)) {
    return;
} ?>

<div class="section-video video-embed-wrap">
    <?php
    echo $video_code; ?>
</div>
