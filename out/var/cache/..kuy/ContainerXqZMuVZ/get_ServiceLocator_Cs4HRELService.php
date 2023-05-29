<?php

namespace ContainerXqZMuVZ;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_Cs4HRELService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.cs4HREL' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.cs4HREL'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'coursRepository' => ['privates', 'App\\Repository\\CoursRepository', 'getCoursRepositoryService', true],
            'doctrine' => ['services', 'doctrine', 'getDoctrineService', false],
        ], [
            'coursRepository' => 'App\\Repository\\CoursRepository',
            'doctrine' => '?',
        ]);
    }
}