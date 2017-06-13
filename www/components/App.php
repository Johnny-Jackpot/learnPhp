<?php

namespace Components;

use Models\Db;

class App
{
    private static $config;

    public function run()
    {
        $config->setConfig();
        Db::setDbParams($config->getDbParams());

        $router = new Router();
        $router->setRoutes($config->getRoutes());
        $router->handleRequest();
    }

    public static function getConfig()
    {
        if (null === self::$config) {
            self::$config = new Config();
        }
        return self::$config;
    }
}
