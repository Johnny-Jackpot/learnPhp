<?php

namespace Components;

class Config
{
    const CONFIG_ROUTES = 'routes.php';
    const CONFIG_DBPARAMS = 'dbParams.php';

    private $dsn;
    private $dbUser;
    private $dbPassword;
    private $routes;

    public function __construct()
    {
        $this->setConfig(ROOT . DIRECTORY_SEPARATOR . 'config');
    }

    private function loopThroughFiles(array $files, &$dbParamsExists, &$routesExists)
    {
        foreach ($files as $item) {
            switch ($item) {
                case self::CONFIG_ROUTES:
                    $routesExists = true;
                    break;
                case self::CONFIG_DBPARAMS:
                    $dbParamsExists = true;
                    break;
            }
        }
    }

    private function checkConfigFileExisting($files)
    {
        $dbParamsExists = false;
        $routesExists = false;
        $this->loopThroughFiles($files, $dbParamsExists, $routesExists);

        if (!$dbParamsExists) {
            throw new \Exception('Database configuration file not exist');
        }

        if (!$routesExists) {
            throw new \Exception('Routes configuration file not exist');
        }
    }

    private function setDbParams(string $path)
    {
        $params = require($path);
        $this->dsn = "mysql:host={$params['host']}; dbname={$params['dbname']}";
        $this->dbUser = $params['user'];
        $this->dbPassword = $params['password'];
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    private function setRoutes(string $path)
    {
        $this->routes = require($path);
    }

    /**
     * @param string $path Path to config directory
     */
    public function setConfig(string $path)
    {
        $path = str_replace('/', DIRECTORY_SEPARATOR, $path);
        $files = scandir($path, SCANDIR_SORT_ASCENDING );
        $this->checkConfigFileExisting($files);
        $this->setDbParams($path . DIRECTORY_SEPARATOR . self::CONFIG_DBPARAMS);
        $this->setRoutes($path . DIRECTORY_SEPARATOR . self::CONFIG_ROUTES);
    }

    public function getDbParams(): array
    {
        return [
            'dsn' => $this->dsn,
            'user' => $this->dbUser,
            'password' => $this->dbPassword
        ];
    }
}