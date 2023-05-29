<?php

namespace ContainerXqZMuVZ;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_Muk8PofService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.Muk8Pof' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.Muk8Pof'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'httpClient' => ['privates', 'psr18.http_client', 'getPsr18_HttpClientService', true],
            'normalizer' => ['services', '.container.private.serializer', 'get_Container_Private_SerializerService', true],
            'requestFactory' => ['privates', '.errored..service_locator.Muk8Pof.Psr\\Http\\Message\\RequestFactoryInterface', NULL, 'Cannot autowire service ".service_locator.Muk8Pof": it references interface "Psr\\Http\\Message\\RequestFactoryInterface" but no such service exists. You should maybe alias this interface to the existing "psr18.http_client" service.'],
        ], [
            'httpClient' => '?',
            'normalizer' => '?',
            'requestFactory' => 'Psr\\Http\\Message\\RequestFactoryInterface',
        ]);
    }
}
