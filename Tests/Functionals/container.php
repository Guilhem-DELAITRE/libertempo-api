<?php declare(strict_types = 1);
require dirname(__DIR__, 2) . '/vendor/autoload.php';

use Psr\Container\ContainerInterface as C;
use Slim\App;
use Slim\Container;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', dirname(__DIR__, 2));
define('TOOLS_PATH', ROOT_PATH . DS . 'Tools');
define('TESTS_FUNCTIONALS_PATH', ROOT_PATH . DS . 'Tests' . DS . 'Functionals');

$container = new Container([
    App::class => function (C $c) {
        $app = require_once TOOLS_PATH . DS . 'App.php';
        return $app;
    }
]);

return $container;
