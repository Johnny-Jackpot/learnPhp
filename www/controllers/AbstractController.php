<?php

namespace Controllers;

use \Models\Db;

abstract class AbstractController implements ControllerInterface
{
    /**
     * store \models\Db instance
     * @var Db
     */
    protected $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    /**
     * Replace '/' with DIRECTORY_SEPARATOR
     * @param string $path  Path to file
     * @return string
     */
    protected function preparePathToFile(string $path): string
    {
        return str_replace('/', DIRECTORY_SEPARATOR, $path);
    }

    /**
     *
     * @return bool
     */
    protected function isXHR(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }
}