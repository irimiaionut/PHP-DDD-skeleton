#!/usr/bin/env php
<?php
// application.php

// this will run the console command
// php console.php list

require __DIR__ . '/../vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use App\Infrastructure\Config\Config;
use Symfony\Component\Console\Application;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use App\Infrastructure\Container\ContainerProvider;
use App\Infrastructure\Commands\GenerateTokenCommand;


//------CONTAINER MODULE
// START Create Container using PHP-DI
$containerProvider = new ContainerProvider();
$container = $containerProvider->getContainer();
$container->set('Config', function (Dotenv $env) {
    return new Config($env);
});
// END Create Container using PHP-DI



//------PERSISTENCE MODULE
//START create entity manager
//dependency inject config
$container->set('Doctrine\ORM\EntityManager', function (Config $env) {
    // Create a simple "default" Doctrine ORM configuration for Annotations
    $isDevMode = true;
    $proxyDir = null;
    $cache = null;
    $useSimpleAnnotationReader = false;
    $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);
    // or if you prefer yaml or XML
    //$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
    //$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

    // database configuration parameters
    $conn = array(
        'driver'    => 'pdo_mysql',
        'host'      => $env->get('DB_HOST', 'default'),
        'port'      => $env->get('DB_PORT', 'default'),
        'dbname'    => $env->get('DB_NAME', 'default'),
        'user'      => $env->get('DB_USER', 'default'),
        'password'  => $env->get('DB_PASS', 'default'),
        'charset'   => 'UTF8',
        'server_version' => '8.0',

    );
    //return entity manager
    return EntityManager::create($conn, $config);
});

// obtaining the entity manager
$entityManager = $container->get('Doctrine\ORM\EntityManager');

//STOP create entity manager


$application = new Application();

// ... register commands
$application->add($container->get(GenerateTokenCommand::class));


$application->run();