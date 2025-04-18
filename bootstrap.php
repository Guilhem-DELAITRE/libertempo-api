<?php
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$paths = [__DIR__."/"];
$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

// database configuration parameters
$dbParams = [
    'driver'   => 'pdo_mysql',
    'host'     => 'mysql',
    'user'     => 'root',
    'password' => 'root',
    'dbname'   => 'db_conges',
];

// obtaining the entity manager
$entityManager = EntityManager::create($dbParams, $config);
