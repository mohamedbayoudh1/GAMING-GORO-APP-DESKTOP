<?php

namespace ContainerRyTsKrc;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_DMI2x0bService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.dMI2x0b' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.dMI2x0b'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'App\\Controller\\CoachingController::acceptCourse' => ['privates', '.service_locator.GQZbvNR', 'get_ServiceLocator_GQZbvNRService', true],
            'App\\Controller\\CoachingController::acceptSeanceCoaching' => ['privates', '.service_locator.GQZbvNR', 'get_ServiceLocator_GQZbvNRService', true],
            'App\\Controller\\CoachingController::addC' => ['privates', '.service_locator.aUsFPsv', 'get_ServiceLocator_AUsFPsvService', true],
            'App\\Controller\\CoachingController::addCAPI' => ['privates', '.service_locator.ITEpf_L', 'get_ServiceLocator_ITEpfLService', true],
            'App\\Controller\\CoachingController::addToFavoriCourse' => ['privates', '.service_locator.GQZbvNR', 'get_ServiceLocator_GQZbvNRService', true],
            'App\\Controller\\CoachingController::adeclinetSeanceCoaching' => ['privates', '.service_locator.GQZbvNR', 'get_ServiceLocator_GQZbvNRService', true],
            'App\\Controller\\CoachingController::adminallCourses' => ['privates', '.service_locator.GQZbvNR', 'get_ServiceLocator_GQZbvNRService', true],
            'App\\Controller\\CoachingController::allCourses' => ['privates', '.service_locator.cs4HREL', 'get_ServiceLocator_Cs4HRELService', true],
            'App\\Controller\\CoachingController::allCoursesAPI' => ['privates', '.service_locator.MfUEUIy', 'get_ServiceLocator_MfUEUIyService', true],
            'App\\Controller\\CoachingController::buyCourse' => ['privates', '.service_locator.GQZbvNR', 'get_ServiceLocator_GQZbvNRService', true],
            'App\\Controller\\CoachingController::generateInvoice' => ['privates', '.service_locator.GQZbvNR', 'get_ServiceLocator_GQZbvNRService', true],
            'App\\Controller\\CoachingController::getSummoner' => ['privates', '.service_locator.9fYGdkS', 'get_ServiceLocator_9fYGdkSService', true],
            'App\\Controller\\CoachingController::getSummonerApi' => ['privates', '.service_locator.Muk8Pof', 'get_ServiceLocator_Muk8PofService', true],
            'App\\Controller\\CoachingController::listPlanningForCoach' => ['privates', '.service_locator.QgARBCI', 'get_ServiceLocator_QgARBCIService', true],
            'App\\Controller\\CoachingController::oneCourse' => ['privates', '.service_locator.GQZbvNR', 'get_ServiceLocator_GQZbvNRService', true],
            'App\\Controller\\CoachingController::planifierOnlineCoaching' => ['privates', '.service_locator.EgXhgtI', 'get_ServiceLocator_EgXhgtIService', true],
            'App\\Controller\\CoachingController::refusertCourse' => ['privates', '.service_locator.GQZbvNR', 'get_ServiceLocator_GQZbvNRService', true],
            'App\\Controller\\CoachingController::removeFromFavoriCourse' => ['privates', '.service_locator.GQZbvNR', 'get_ServiceLocator_GQZbvNRService', true],
            'App\\Controller\\CoachingController::showCoachCourses' => ['privates', '.service_locator.FhMYf0G', 'get_ServiceLocator_FhMYf0GService', true],
            'App\\Controller\\CoachingController::supp' => ['privates', '.service_locator.ml23cMz', 'get_ServiceLocator_Ml23cMzService', true],
            'App\\Controller\\CoachingController::suppAPI' => ['privates', '.service_locator.4aQ8J_H', 'get_ServiceLocator_4aQ8JHService', true],
            'App\\Controller\\CoachingController::updateC' => ['privates', '.service_locator.05oTWCK', 'get_ServiceLocator_05oTWCKService', true],
            'App\\Controller\\CoachingController::updateCAPI' => ['privates', '.service_locator.05oTWCK', 'get_ServiceLocator_05oTWCKService', true],
            'App\\Controller\\CommentaireNewsController::news' => ['privates', '.service_locator.aFK_N6f', 'get_ServiceLocator_AFKN6fService', true],
            'App\\Controller\\GroupController::add' => ['privates', '.service_locator.GQZbvNR', 'get_ServiceLocator_GQZbvNRService', true],
            'App\\Controller\\GroupController::oneCourse' => ['privates', '.service_locator.2rwXGj7', 'get_ServiceLocator_2rwXGj7Service', true],
            'App\\Controller\\ProductController::Panier' => ['privates', '.service_locator.ONtZwya', 'get_ServiceLocator_ONtZwyaService', true],
            'App\\Controller\\ProductController::add' => ['privates', '.service_locator.GQZbvNR', 'get_ServiceLocator_GQZbvNRService', true],
            'App\\Controller\\ProductController::addp' => ['privates', '.service_locator.GQZbvNR', 'get_ServiceLocator_GQZbvNRService', true],
            'App\\Controller\\ProductController::index' => ['privates', '.service_locator.GQZbvNR', 'get_ServiceLocator_GQZbvNRService', true],
            'App\\Controller\\ProductController::oneProduct' => ['privates', '.service_locator.ONtZwya', 'get_ServiceLocator_ONtZwyaService', true],
            'App\\Kernel::loadRoutes' => ['privates', '.service_locator.xUrKPVU', 'get_ServiceLocator_XUrKPVUService', true],
            'App\\Kernel::registerContainerConfiguration' => ['privates', '.service_locator.xUrKPVU', 'get_ServiceLocator_XUrKPVUService', true],
            'kernel::loadRoutes' => ['privates', '.service_locator.xUrKPVU', 'get_ServiceLocator_XUrKPVUService', true],
            'kernel::registerContainerConfiguration' => ['privates', '.service_locator.xUrKPVU', 'get_ServiceLocator_XUrKPVUService', true],
            'App\\Controller\\CoachingController:acceptCourse' => ['privates', '.service_locator.GQZbvNR', 'get_ServiceLocator_GQZbvNRService', true],
            'App\\Controller\\CoachingController:acceptSeanceCoaching' => ['privates', '.service_locator.GQZbvNR', 'get_ServiceLocator_GQZbvNRService', true],
            'App\\Controller\\CoachingController:addC' => ['privates', '.service_locator.aUsFPsv', 'get_ServiceLocator_AUsFPsvService', true],
            'App\\Controller\\CoachingController:addCAPI' => ['privates', '.service_locator.ITEpf_L', 'get_ServiceLocator_ITEpfLService', true],
            'App\\Controller\\CoachingController:addToFavoriCourse' => ['privates', '.service_locator.GQZbvNR', 'get_ServiceLocator_GQZbvNRService', true],
            'App\\Controller\\CoachingController:adeclinetSeanceCoaching' => ['privates', '.service_locator.GQZbvNR', 'get_ServiceLocator_GQZbvNRService', true],
            'App\\Controller\\CoachingController:adminallCourses' => ['privates', '.service_locator.GQZbvNR', 'get_ServiceLocator_GQZbvNRService', true],
            'App\\Controller\\CoachingController:allCourses' => ['privates', '.service_locator.cs4HREL', 'get_ServiceLocator_Cs4HRELService', true],
            'App\\Controller\\CoachingController:allCoursesAPI' => ['privates', '.service_locator.MfUEUIy', 'get_ServiceLocator_MfUEUIyService', true],
            'App\\Controller\\CoachingController:buyCourse' => ['privates', '.service_locator.GQZbvNR', 'get_ServiceLocator_GQZbvNRService', true],
            'App\\Controller\\CoachingController:generateInvoice' => ['privates', '.service_locator.GQZbvNR', 'get_ServiceLocator_GQZbvNRService', true],
            'App\\Controller\\CoachingController:getSummoner' => ['privates', '.service_locator.9fYGdkS', 'get_ServiceLocator_9fYGdkSService', true],
            'App\\Controller\\CoachingController:getSummonerApi' => ['privates', '.service_locator.Muk8Pof', 'get_ServiceLocator_Muk8PofService', true],
            'App\\Controller\\CoachingController:listPlanningForCoach' => ['privates', '.service_locator.QgARBCI', 'get_ServiceLocator_QgARBCIService', true],
            'App\\Controller\\CoachingController:oneCourse' => ['privates', '.service_locator.GQZbvNR', 'get_ServiceLocator_GQZbvNRService', true],
            'App\\Controller\\CoachingController:planifierOnlineCoaching' => ['privates', '.service_locator.EgXhgtI', 'get_ServiceLocator_EgXhgtIService', true],
            'App\\Controller\\CoachingController:refusertCourse' => ['privates', '.service_locator.GQZbvNR', 'get_ServiceLocator_GQZbvNRService', true],
            'App\\Controller\\CoachingController:removeFromFavoriCourse' => ['privates', '.service_locator.GQZbvNR', 'get_ServiceLocator_GQZbvNRService', true],
            'App\\Controller\\CoachingController:showCoachCourses' => ['privates', '.service_locator.FhMYf0G', 'get_ServiceLocator_FhMYf0GService', true],
            'App\\Controller\\CoachingController:supp' => ['privates', '.service_locator.ml23cMz', 'get_ServiceLocator_Ml23cMzService', true],
            'App\\Controller\\CoachingController:suppAPI' => ['privates', '.service_locator.4aQ8J_H', 'get_ServiceLocator_4aQ8JHService', true],
            'App\\Controller\\CoachingController:updateC' => ['privates', '.service_locator.05oTWCK', 'get_ServiceLocator_05oTWCKService', true],
            'App\\Controller\\CoachingController:updateCAPI' => ['privates', '.service_locator.05oTWCK', 'get_ServiceLocator_05oTWCKService', true],
            'App\\Controller\\CommentaireNewsController:news' => ['privates', '.service_locator.aFK_N6f', 'get_ServiceLocator_AFKN6fService', true],
            'App\\Controller\\GroupController:add' => ['privates', '.service_locator.GQZbvNR', 'get_ServiceLocator_GQZbvNRService', true],
            'App\\Controller\\GroupController:oneCourse' => ['privates', '.service_locator.2rwXGj7', 'get_ServiceLocator_2rwXGj7Service', true],
            'App\\Controller\\ProductController:Panier' => ['privates', '.service_locator.ONtZwya', 'get_ServiceLocator_ONtZwyaService', true],
            'App\\Controller\\ProductController:add' => ['privates', '.service_locator.GQZbvNR', 'get_ServiceLocator_GQZbvNRService', true],
            'App\\Controller\\ProductController:addp' => ['privates', '.service_locator.GQZbvNR', 'get_ServiceLocator_GQZbvNRService', true],
            'App\\Controller\\ProductController:index' => ['privates', '.service_locator.GQZbvNR', 'get_ServiceLocator_GQZbvNRService', true],
            'App\\Controller\\ProductController:oneProduct' => ['privates', '.service_locator.ONtZwya', 'get_ServiceLocator_ONtZwyaService', true],
            'kernel:loadRoutes' => ['privates', '.service_locator.xUrKPVU', 'get_ServiceLocator_XUrKPVUService', true],
            'kernel:registerContainerConfiguration' => ['privates', '.service_locator.xUrKPVU', 'get_ServiceLocator_XUrKPVUService', true],
        ], [
            'App\\Controller\\CoachingController::acceptCourse' => '?',
            'App\\Controller\\CoachingController::acceptSeanceCoaching' => '?',
            'App\\Controller\\CoachingController::addC' => '?',
            'App\\Controller\\CoachingController::addCAPI' => '?',
            'App\\Controller\\CoachingController::addToFavoriCourse' => '?',
            'App\\Controller\\CoachingController::adeclinetSeanceCoaching' => '?',
            'App\\Controller\\CoachingController::adminallCourses' => '?',
            'App\\Controller\\CoachingController::allCourses' => '?',
            'App\\Controller\\CoachingController::allCoursesAPI' => '?',
            'App\\Controller\\CoachingController::buyCourse' => '?',
            'App\\Controller\\CoachingController::generateInvoice' => '?',
            'App\\Controller\\CoachingController::getSummoner' => '?',
            'App\\Controller\\CoachingController::getSummonerApi' => '?',
            'App\\Controller\\CoachingController::listPlanningForCoach' => '?',
            'App\\Controller\\CoachingController::oneCourse' => '?',
            'App\\Controller\\CoachingController::planifierOnlineCoaching' => '?',
            'App\\Controller\\CoachingController::refusertCourse' => '?',
            'App\\Controller\\CoachingController::removeFromFavoriCourse' => '?',
            'App\\Controller\\CoachingController::showCoachCourses' => '?',
            'App\\Controller\\CoachingController::supp' => '?',
            'App\\Controller\\CoachingController::suppAPI' => '?',
            'App\\Controller\\CoachingController::updateC' => '?',
            'App\\Controller\\CoachingController::updateCAPI' => '?',
            'App\\Controller\\CommentaireNewsController::news' => '?',
            'App\\Controller\\GroupController::add' => '?',
            'App\\Controller\\GroupController::oneCourse' => '?',
            'App\\Controller\\ProductController::Panier' => '?',
            'App\\Controller\\ProductController::add' => '?',
            'App\\Controller\\ProductController::addp' => '?',
            'App\\Controller\\ProductController::index' => '?',
            'App\\Controller\\ProductController::oneProduct' => '?',
            'App\\Kernel::loadRoutes' => '?',
            'App\\Kernel::registerContainerConfiguration' => '?',
            'kernel::loadRoutes' => '?',
            'kernel::registerContainerConfiguration' => '?',
            'App\\Controller\\CoachingController:acceptCourse' => '?',
            'App\\Controller\\CoachingController:acceptSeanceCoaching' => '?',
            'App\\Controller\\CoachingController:addC' => '?',
            'App\\Controller\\CoachingController:addCAPI' => '?',
            'App\\Controller\\CoachingController:addToFavoriCourse' => '?',
            'App\\Controller\\CoachingController:adeclinetSeanceCoaching' => '?',
            'App\\Controller\\CoachingController:adminallCourses' => '?',
            'App\\Controller\\CoachingController:allCourses' => '?',
            'App\\Controller\\CoachingController:allCoursesAPI' => '?',
            'App\\Controller\\CoachingController:buyCourse' => '?',
            'App\\Controller\\CoachingController:generateInvoice' => '?',
            'App\\Controller\\CoachingController:getSummoner' => '?',
            'App\\Controller\\CoachingController:getSummonerApi' => '?',
            'App\\Controller\\CoachingController:listPlanningForCoach' => '?',
            'App\\Controller\\CoachingController:oneCourse' => '?',
            'App\\Controller\\CoachingController:planifierOnlineCoaching' => '?',
            'App\\Controller\\CoachingController:refusertCourse' => '?',
            'App\\Controller\\CoachingController:removeFromFavoriCourse' => '?',
            'App\\Controller\\CoachingController:showCoachCourses' => '?',
            'App\\Controller\\CoachingController:supp' => '?',
            'App\\Controller\\CoachingController:suppAPI' => '?',
            'App\\Controller\\CoachingController:updateC' => '?',
            'App\\Controller\\CoachingController:updateCAPI' => '?',
            'App\\Controller\\CommentaireNewsController:news' => '?',
            'App\\Controller\\GroupController:add' => '?',
            'App\\Controller\\GroupController:oneCourse' => '?',
            'App\\Controller\\ProductController:Panier' => '?',
            'App\\Controller\\ProductController:add' => '?',
            'App\\Controller\\ProductController:addp' => '?',
            'App\\Controller\\ProductController:index' => '?',
            'App\\Controller\\ProductController:oneProduct' => '?',
            'kernel:loadRoutes' => '?',
            'kernel:registerContainerConfiguration' => '?',
        ]);
    }
}