<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT', __DIR__);

require_once ROOT . DIRECTORY_SEPARATOR . 'autoload.php';

$app = new \Components\App();
$app->run();