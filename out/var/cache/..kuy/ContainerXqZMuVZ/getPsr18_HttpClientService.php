<?php

namespace ContainerXqZMuVZ;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getPsr18_HttpClientService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'psr18.http_client' shared service.
     *
     * @return \Symfony\Component\HttpClient\Psr18Client
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'psr'.\DIRECTORY_SEPARATOR.'http-client'.\DIRECTORY_SEPARATOR.'src'.\DIRECTORY_SEPARATOR.'ClientInterface.php';
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'psr'.\DIRECTORY_SEPARATOR.'http-factory'.\DIRECTORY_SEPARATOR.'src'.\DIRECTORY_SEPARATOR.'RequestFactoryInterface.php';
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'psr'.\DIRECTORY_SEPARATOR.'http-factory'.\DIRECTORY_SEPARATOR.'src'.\DIRECTORY_SEPARATOR.'StreamFactoryInterface.php';
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'psr'.\DIRECTORY_SEPARATOR.'http-factory'.\DIRECTORY_SEPARATOR.'src'.\DIRECTORY_SEPARATOR.'UriFactoryInterface.php';
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'symfony'.\DIRECTORY_SEPARATOR.'http-client'.\DIRECTORY_SEPARATOR.'Psr18Client.php';

        return $container->privates['psr18.http_client'] = new \Symfony\Component\HttpClient\Psr18Client(($container->privates['.debug.http_client'] ?? $container->get_Debug_HttpClientService()), NULL, NULL);
    }
}
