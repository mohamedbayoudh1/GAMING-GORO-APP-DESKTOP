<?php

namespace ContainerRyTsKrc;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getNyholm_Psr7_Psr17FactoryService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'nyholm.psr7.psr17_factory' shared service.
     *
     * @return \Nyholm\Psr7\Factory\Psr17Factory
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'psr'.\DIRECTORY_SEPARATOR.'http-factory'.\DIRECTORY_SEPARATOR.'src'.\DIRECTORY_SEPARATOR.'RequestFactoryInterface.php';
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'psr'.\DIRECTORY_SEPARATOR.'http-factory'.\DIRECTORY_SEPARATOR.'src'.\DIRECTORY_SEPARATOR.'ResponseFactoryInterface.php';
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'psr'.\DIRECTORY_SEPARATOR.'http-factory'.\DIRECTORY_SEPARATOR.'src'.\DIRECTORY_SEPARATOR.'ServerRequestFactoryInterface.php';
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'psr'.\DIRECTORY_SEPARATOR.'http-factory'.\DIRECTORY_SEPARATOR.'src'.\DIRECTORY_SEPARATOR.'StreamFactoryInterface.php';
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'psr'.\DIRECTORY_SEPARATOR.'http-factory'.\DIRECTORY_SEPARATOR.'src'.\DIRECTORY_SEPARATOR.'UploadedFileFactoryInterface.php';
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'psr'.\DIRECTORY_SEPARATOR.'http-factory'.\DIRECTORY_SEPARATOR.'src'.\DIRECTORY_SEPARATOR.'UriFactoryInterface.php';
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'nyholm'.\DIRECTORY_SEPARATOR.'psr7'.\DIRECTORY_SEPARATOR.'src'.\DIRECTORY_SEPARATOR.'Factory'.\DIRECTORY_SEPARATOR.'Psr17Factory.php';

        return $container->privates['nyholm.psr7.psr17_factory'] = new \Nyholm\Psr7\Factory\Psr17Factory();
    }
}
