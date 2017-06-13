<?php

$baseDir = ROOT . DIRECTORY_SEPARATOR;

require_once str_replace('/', DIRECTORY_SEPARATOR, $baseDir. 'components/Psr4Autoload.php');

$loader = new \Components\Psr4Autoload();
$loader->register();
$loader->addNamespace('Components', $baseDir . 'components');
$loader->addNamespace('Models', $baseDir . 'models');
$loader->addNamespace('Controllers', $baseDir . 'controllers');