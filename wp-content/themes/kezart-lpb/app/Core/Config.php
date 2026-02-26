<?php

declare(strict_types=1);

namespace RS\Theme\App\Core;

class Config extends Singleton
{
    protected function __construct(private string $configDirPath = '')
    {
        parent::__construct();
        $this->configDirPath = get_template_directory().'/config';
    }

    public function get(string $key): array
    {
        $configFile = $this->configDirPath.'/'.$key.'.php';
        if (! file_exists($configFile)) {
            return [];
        }

        return include $configFile;
    }

    public function getPublicPath(string $path): string
    {
        $publicPath = get_template_directory().'/public/';

        return ! empty($path) ? $publicPath.$path : $publicPath;
    }

    public function asset(string $path, ?bool $secure = null): string
    {
        return ! empty($path) ? get_theme_file_uri("public/$path") : $path;
    }
}
