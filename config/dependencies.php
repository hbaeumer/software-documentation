<?php
/**
 * Created by PhpStorm.
 * User: heiner
 * Date: 29.05.18
 * Time: 22:38
 */

use function DI\factory;
use function DI\create;


return [

    Twig_LoaderInterface::class => factory(function () {
        return new Twig_Loader_Filesystem(__DIR__.'/../template/default');
    }),
    \Twig\Environment::class => factory('dddks'),
];