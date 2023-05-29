<?php

namespace ContainerXqZMuVZ;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_EgXhgtIService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.EgXhgtI' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.EgXhgtI'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'csRep' => ['privates', 'App\\Repository\\CoachSkillsRepository', 'getCoachSkillsRepositoryService', true],
            'doctrine' => ['services', 'doctrine', 'getDoctrineService', false],
        ], [
            'csRep' => 'App\\Repository\\CoachSkillsRepository',
            'doctrine' => '?',
        ]);
    }
}
