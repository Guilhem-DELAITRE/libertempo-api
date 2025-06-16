<?php
// bootstrap.php
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$paths = [__DIR__ . "/"];
$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode, $proxyDir, $cache);

// database configuration parameters
$dbParams = [
    'driver' => 'pdo_mysql',
    'host' => 'mysql',
    'user' => 'root',
    'password' => 'root',
    'dbname' => 'db_conges',
];

// obtaining the entity manager
$entityManager = EntityManager::create($dbParams, $config);
