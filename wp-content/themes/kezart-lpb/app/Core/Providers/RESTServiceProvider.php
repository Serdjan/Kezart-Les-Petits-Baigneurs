<?php

declare(strict_types=1);

namespace RS\Theme\App\Core\Providers;

use RS\Theme\App\Core\Config;
use RS\Theme\App\Core\Interfaces\Service;

class RESTServiceProvider implements Service
{
    public function register(): void
    {
        $controllers = Config::instance()->get('rest');
        if (empty($controllers)) {
            return;
        }

        add_action('rest_api_init', function () use ($controllers): void {
            foreach ($controllers as $controller) {
                $controller = new $controller('/lpb/v1');
                $controller->registerRoutes();
            }
        });
    }
}
