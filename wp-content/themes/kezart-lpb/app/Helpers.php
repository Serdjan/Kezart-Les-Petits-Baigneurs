<?php

declare(strict_types=1);

namespace RS\Theme\App;

class Helpers
{
    public static function getPartialsFromBlueprints(
        string|int|bool $location = false,
        array $allowed = [],
        string $key = 'page_blueprints'
    ): void {
        $blueprints = get_field($key, $location);

        if (empty($blueprints)) {
            return;
        }

        if ($key !== 'page_blueprints') {
            $blueprints = $blueprints['page_blueprints'];
        }

        global $sectionCount;
        $sectionCount = 0;
        foreach ($blueprints as $blueprint) {
            $blueprintName = $blueprint['acf_fc_layout'];

            if (!empty($allowed) && !in_array($blueprintName, $allowed)) {
                continue;
            }

            if (!file_exists(get_theme_file_path("resources/views/partials/$blueprintName.php"))) {
                continue;
            }

            if ($blueprintName === 'section') {
                $sectionCount++;
            }

            get_template_part(
                "resources/views/partials/$blueprintName",
                null,
                !empty($location) ? array_merge($blueprint, ['pageID' => $location]) : $blueprint
            );
        }
    }
}
