<?php

declare(strict_types=1);

namespace RS\Theme\App\Core\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use RS\Theme\App\Actions;
use RS\Theme\App\Core\Config;
use RS\Theme\App\Core\Interfaces\Service;
use RS\Theme\App\Filters;

class HooksServiceProvider implements Service
{
    public function register(): void
    {
        $filters = Config::instance()->get('filters');
        $actions = Config::instance()->get('actions');
        if (empty($filters) && empty($actions)) {
            return;
        }

        if (!empty($filters)) {
            $filtersClass = new Filters();
            Collection::make($filters)->each(function ($params, $hookName) use ($filtersClass) {
                $values = $this->generateHookValues($hookName, $params);
                add_filter(
                    $values['hook-name'],
                    [$filtersClass, $values['callback']],
                    ...$values['params']
                );
            });
        }

        if (!empty($actions)) {
            $actionsClass = new Actions();
            Collection::make($actions)->each(function ($params, $hookName) use ($actionsClass) {
                if ($this->isMultiArray($params)) {
                    Collection::make($params)->each(function ($cParams) use ($actionsClass, $hookName) {
                        $values = $this->generateHookValues($hookName, $cParams);
                        add_action(
                            $values['hook-name'],
                            [$actionsClass, $values['callback']],
                            ...$values['params']
                        );
                    });
                } else {
                    $values = $this->generateHookValues($hookName, $params);
                    add_action(
                        $values['hook-name'],
                        [$actionsClass, $values['callback']],
                        ...$values['params']
                    );
                }
            });
        }
    }

    private function isMultiArray(string|array $value): bool
    {
        if (is_string($value)) {
            return false;
        }

        foreach ($value as $w) {
            if (is_array($w)) {
                return true;
            }
        }

        return false;
    }

    private function generateHookValues(string|int $key, string|array $value): array
    {
        $hookName = $key;
        $params = $value;

        if (is_int($hookName)) {
            $hookName = $params;
            $hookNameToUse = Str::camel($hookName);
            $params = [10, 1];
        }

        if (!is_int($hookName)) {
            $hookNameToUse = is_string($params[array_key_first($params)]) ? $params[array_key_first(
                $params
            )] : Str::camel($hookName);

            if (is_string($params[array_key_first($params)])) {
                $paramsCollection = Collection::make($params)->slice(1)->all();
                $params = match (count($params) - 1) {
                    2 => $paramsCollection,
                    1 => array_merge($paramsCollection, [1]),
                    default => [10, 1],
                };
            } else {
                $params = match (count($params)) {
                    2 => $params,
                    1 => array_merge($params, [1]),
                    default => [10, 1],
                };
            }
        }

        return [
            'hook-name' => $hookName,
            'callback' => $hookNameToUse,
            'params' => $params,
        ];
    }
}
