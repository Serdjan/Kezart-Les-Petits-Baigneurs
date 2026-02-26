<?php

declare(strict_types=1);

namespace RS\Theme\App\Core;

use Dotenv\Dotenv;
use Exception;
use RS\Theme\App\Core\Providers\ACF\ThemeSettingsProvider;
use RS\Theme\App\Core\Providers\AssetsServiceProvider;
use RS\Theme\App\Core\Providers\BlocksServiceProvider;
use RS\Theme\App\Core\Providers\CoreServiceProvider;
use RS\Theme\App\Core\Providers\ACF\GlobalComponentsProvider;
use RS\Theme\App\Core\Providers\HooksServiceProvider;
use RS\Theme\App\Core\Providers\FontsServiceProvider;
use RS\Theme\App\Core\Providers\ImagesServiceProvider;
use RS\Theme\App\Core\Providers\MenusServiceProvider;
use RS\Theme\App\Core\Providers\RESTServiceProvider;
use RS\Theme\App\Core\Providers\SidebarsServiceProvider;
use RS\Theme\App\Core\Providers\SupportServiceProvider;

use const RS\Theme\RS_THEME_DIR;

final class Bootstrap
{
    protected static ?Bootstrap $instance = null;

    protected function __construct()
    {
        $this->loadEnv();

        $services = [
            CoreServiceProvider::class,
            SupportServiceProvider::class,
            MenusServiceProvider::class,
            AssetsServiceProvider::class,
            FontsServiceProvider::class,
            ImagesServiceProvider::class,
            SidebarsServiceProvider::class,
            HooksServiceProvider::class,
            BlocksServiceProvider::class,
            RESTServiceProvider::class,
        ];

        if (class_exists('ACF')) {
            $services[] = GlobalComponentsProvider::class;
            $services[] = ThemeSettingsProvider::class;
        }

        $this->registerServices($services);
    }

    public static function instance(): ?Bootstrap
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function loadEnv(): void
    {
        $env = Dotenv::createImmutable(RS_THEME_DIR);
        $env->safeLoad();
    }

    public function registerServices(array $services): Bootstrap
    {
        if (empty($services)) {
            return $this;
        }

        array_walk($services, function ($class) {
            (new $class())->register();
        });

        return $this;
    }

    /**
     * @throws Exception
     */
    public function __clone()
    {
        throw new Exception('Cloning is not permitted.');
    }

    /**
     * @throws Exception
     */
    public function __wakeup()
    {
        throw new Exception('Unserializing instances of this class is is not permitted.');
    }
}
