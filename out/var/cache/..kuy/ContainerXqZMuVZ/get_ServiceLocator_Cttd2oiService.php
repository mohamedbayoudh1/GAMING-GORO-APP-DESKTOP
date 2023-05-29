<?php

namespace ContainerXqZMuVZ;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_Cttd2oiService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.Cttd2oi' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.Cttd2oi'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'doctrine' => ['services', 'doctrine', 'getDoctrineService', false],
            'postRepository' => ['privates', 'App\\Repository\\ProduitRepository', 'getProduitRepositoryService', true],
        ], [
            'doctrine' => '?',
            'postRepository' => 'App\\Repository\\ProduitRepository',
        ]);
    }
}
