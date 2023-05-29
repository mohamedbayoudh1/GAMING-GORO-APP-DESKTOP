<?php

namespace ContainerXqZMuVZ;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_BhnUoHDService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.BhnUoHD' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.BhnUoHD'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'gamerrepo' => ['privates', 'App\\Repository\\GamerRepository', 'getGamerRepositoryService', true],
        ], [
            'gamerrepo' => 'App\\Repository\\GamerRepository',
        ]);
    }
}
