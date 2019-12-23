<?php

//used for doctrine commands console
//php vendor/bin/doctrine list
//php vendor/bin/doctrine orm:schema-tool:create - create tables
//php vendor/bin/doctrine orm:schema-tool:update - sync tables with entities

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use App\Infrastructure\Config\Config;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use App\Infrastructure\Container\ContainerProvider;


require __DIR__ . '/vendor/autoload.php';

//------CONTAINER MODULE
// START Create Container using PHP-DI
$containerProvider = new ContainerProvider();
$container = $containerProvider->getContainer();
//set config to be loaded with dotenv, or other
$container->set('Config', function (Dotenv $env) {
    return new Config($env);
});
// END Create Container using PHP-DI


//------PERSISTENCE MODULE
//START create entity manager
//dependency inject config
$container->set('Doctrine\ORM\EntityManager', function (Config $env) {
    $path = array(
        "src/Domain"
    );

    // Create a simple "default" Doctrine ORM configuration for Annotations
    $isDevMode = true;
    $proxyDir = null;
    $cache = null;
    $useSimpleAnnotationReader = false;


    $config = Setup::createAnnotationMetadataConfiguration($path, $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);


    // database configuration parameters
    $conn = array(
        'driver'    => 'pdo_mysql',
        'host'      => $env->get('DB_HOST', 'default'),
        'port'      => $env->get('DB_PORT', 'default'),
        'dbname'    => $env->get('DB_NAME', 'default'),
        'user'      => $env->get('DB_USER', 'default'),
        'password'  => $env->get('DB_PASS', 'default'),
        'charset'   => 'UTF8',
        'server_version' => '5.7',

    );
    //return entity manager
    return EntityManager::create($conn, $config);
});

// obtaining the entity manager
$entityManager = $container->get('Doctrine\ORM\EntityManager');

//var_dump(print_r($entityManager,1));die();

return ConsoleRunner::createHelperSet($entityManager);

//STOP create entity manager

// obtaining the entity manager
//return $container->get('Doctrine\ORM\EntityManager');
