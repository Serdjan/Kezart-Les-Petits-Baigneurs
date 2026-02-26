<?php

declare(strict_types=1);

global $sectionCount;

extract($args); ?>

<div <?php
echo !empty($sectionCount) && $sectionCount === 1 ? 'id="main"' : ''; ?>
        class="section relative py-10 lg:py-20 overflow-hidden" style="background-color: <?php
echo esc_attr($background_color); ?>;">
    <div class="container">
        <?php
        if (!empty($section_blueprints)) :
            foreach ($section_blueprints as $blueprint) {
                $blueprintName = $blueprint['acf_fc_layout'];
                if (!file_exists(get_theme_file_path("resources/views/partials/section/$blueprintName.php"))) {
                    continue;
                }
                get_template_part("resources/views/partials/section/$blueprintName", null, $blueprint);
            }
        endif; ?>
    </div>
</div>