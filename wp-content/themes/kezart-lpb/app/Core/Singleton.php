<?php

declare(strict_types=1);

namespace RS\Theme\App\Core;

use Exception;

class Singleton
{
    private static array $instances = [];

    protected function __construct()
    {
    }

    public static function instance()
    {
        $subclass = static::class;
        if (! isset(self::$instances[$subclass])) {
            self::$instances[$subclass] = new static();
        }

        return self::$instances[$subclass];
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
