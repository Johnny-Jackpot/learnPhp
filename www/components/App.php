<?php

namespace Components;

class App
{
    private static $config;

    public function run()
    {
        $router = new Router();
        $router->handleRequest();
    }

    /**
     * @return Config
     */
    public static function getConfig(): Config
    {
        if (null === self::$config) {
            self::$config = new Config();
        }
        return self::$config;
    }
}
