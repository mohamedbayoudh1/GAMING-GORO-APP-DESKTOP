<?php

namespace ContainerXqZMuVZ;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_Ml23cMzService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.ml23cMz' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.ml23cMz'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'doctrine' => ['services', 'doctrine', 'getDoctrineService', false],
            'filesystem' => ['services', '.container.private.filesystem', 'get_Container_Private_FilesystemService', true],
        ], [
            'doctrine' => '?',
            'filesystem' => '?',
        ]);
    }
}