<?php

namespace ContainerRyTsKrc;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_9fYGdkSService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.9fYGdkS' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.9fYGdkS'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'httpClient' => ['privates', 'psr18.http_client', 'getPsr18_HttpClientService', true],
            'requestFactory' => ['privates', 'nyholm.psr7.psr17_factory', 'getNyholm_Psr7_Psr17FactoryService', true],
        ], [
            'httpClient' => '?',
            'requestFactory' => '?',
        ]);
    }
}
