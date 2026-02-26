<?php

declare(strict_types=1);

namespace RS\Theme\App\Core\Providers;

use Illuminate\Support\Collection;
use RS\Theme\App\Core\Config;
use RS\Theme\App\Core\Interfaces\Service;

class SupportServiceProvider implements Service
{
    public function register(): void
    {
        add_action('after_setup_theme', function (): void {
            $support = Config::instance()->get('support');
            if (empty($support)) {
                return;
            }

            if (! empty($support['add'])) {
                Collection::make($support['add'])
                    ->map(fn ($params, $feature) => is_array($params) ? [$feature, $params] : [$params])
                    ->each(fn ($params) => add_theme_support(...$params));
            }
            if (! empty($support['remove'])) {
                Collection::make($support['remove'])
                    ->map(fn ($entry) => is_string($entry) ? [$entry] : $entry)
                    ->each(fn ($params) => remove_theme_support(...$params));
            }
        });
    }
}
