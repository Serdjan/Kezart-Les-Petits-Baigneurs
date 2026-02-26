<?php

declare(strict_types=1);

namespace RS\Theme\App\Core;

class PageTemplates
{
    public function __construct()
    {
        add_filter('theme_page_templates', [$this, 'updatePageTemplates']);
    }

    public function updatePageTemplates(array $templates): array
    {
        $files = $this->getFiles();
        if (empty($files)) {
            return $templates;
        }

        foreach ($files as $filePath) {
            if (! preg_match(
                '|Template Name:(.*)$|mi',
                file_get_contents(get_stylesheet_directory().'/'.$filePath),
                $header
            )) {
                continue;
            }

            $templates[$filePath] = $header[1];
        }

        return $templates;
    }

    private function getFiles(): array
    {
        $path = trailingslashit(get_stylesheet_directory().'/resources/views/layouts');
        $results = scandir($path);
        $files = [];

        foreach ($results as $result) {
            if ($result[0] === '.') {
                continue;
            }

            if (is_dir("$path/$result")) {
                continue;
            }

            if (! preg_match('~\.(php)$~', $result)) {
                continue;
            }

            $files[] = "resources/views/layouts/$result";
        }

        return $files;
    }
}
