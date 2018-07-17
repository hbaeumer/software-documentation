<?php
/**
 * Created by PhpStorm.
 * User: heiner
 * Date: 29.05.18
 * Time: 14:13
 */

include __DIR__.'/../vendor/autoload.php';

$containerBuilder = new DI\ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__.'/../config/dependencies.php');
$containerBuilder->useAnnotations(true);
$containerBuilder->ignorePhpDocErrors(false);


$container = $containerBuilder->build();


$app = $container->get(\Hbaeumer\SoftDoc\Console\Bootstrap::class);


$app->initialize()->run();