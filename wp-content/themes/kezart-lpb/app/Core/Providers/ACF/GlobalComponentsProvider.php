<?php

declare(strict_types=1);

namespace RS\Theme\App\Core\Providers\ACF;

use RS\Theme\App\Core\Interfaces\Service;

class GlobalComponentsProvider implements Service
{
    public function register(): void
    {
        add_action('acf/init', function () {
            $this->registerGlobalComponents();
        });
        add_filter('acf/load_field/name=component', [$this, 'populateGlobalComponentsSelect']);
    }

    private function registerGlobalComponents(): void
    {
        acf_add_options_page([
            'page_title' => __('Global Components', 'kezart-lpb'),
            'menu_slug' => 'global-components',
            'parent_slug' => 'themes.php',
            'post_id' => 'global_components',
        ]);
    }

    public function populateGlobalComponentsSelect(array $field): array
    {
        $field['choices'] = [];
        $globalFields = acf_get_fields($this->getGlobalComponentsFieldGroupKey());
        if (empty($globalFields)) {
            return $field;
        }

        foreach ($globalFields as $globalField) {
            $field['choices'][$globalField['name']] = $globalField['label'];
        }

        return $field;
    }

    private function getGlobalComponentsFieldGroupKey(): string
    {
        $fieldGroups = acf_get_field_groups();
        if (empty($fieldGroups)) {
            return '';
        }

        foreach ($fieldGroups as $fieldGroup) {
            if (empty($fieldGroup['location'])) {
                continue;
            }

            if (empty($fieldGroup['location'][0])) {
                continue;
            }

            if (empty($fieldGroup['location'][0][0])) {
                continue;
            }

            if ($fieldGroup['location'][0][0]['param'] !== 'options_page') {
                continue;
            }

            if ($fieldGroup['location'][0][0]['operator'] !== '==') {
                continue;
            }

            if ($fieldGroup['location'][0][0]['value'] !== 'global-components') {
                continue;
            }

            return $fieldGroup['key'];
        }

        return '';
    }
}
