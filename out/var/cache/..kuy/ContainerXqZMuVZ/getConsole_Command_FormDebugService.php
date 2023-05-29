<?php

namespace ContainerXqZMuVZ;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getConsole_Command_FormDebugService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'console.command.form_debug' shared service.
     *
     * @return \Symfony\Component\Form\Command\DebugCommand
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'symfony'.\DIRECTORY_SEPARATOR.'console'.\DIRECTORY_SEPARATOR.'Command'.\DIRECTORY_SEPARATOR.'Command.php';
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'symfony'.\DIRECTORY_SEPARATOR.'form'.\DIRECTORY_SEPARATOR.'Command'.\DIRECTORY_SEPARATOR.'DebugCommand.php';

        $container->privates['console.command.form_debug'] = $instance = new \Symfony\Component\Form\Command\DebugCommand(($container->privates['form.registry'] ?? $container->load('getForm_RegistryService')), [0 => 'Symfony\\Component\\Form\\Extension\\Core\\Type', 1 => 'App\\Form', 2 => 'Symfony\\Bridge\\Doctrine\\Form\\Type'], [0 => 'App\\Form\\AddCourseType', 1 => 'App\\Form\\CategorieType', 2 => 'App\\Form\\ClassementType', 3 => 'App\\Form\\CoachPlanningType', 4 => 'App\\Form\\CoachType', 5 => 'App\\Form\\CommentaireNewsType', 6 => 'App\\Form\\GamerType', 7 => 'App\\Form\\GroupeType', 8 => 'App\\Form\\JeuxType', 9 => 'App\\Form\\JeuxType2', 10 => 'App\\Form\\LoginType', 11 => 'App\\Form\\NewsType', 12 => 'App\\Form\\NewsType2', 13 => 'App\\Form\\PostType', 14 => 'App\\Form\\ProduitType', 15 => 'App\\Form\\RechargeType', 16 => 'App\\Form\\ReviewJeuxType', 17 => 'App\\Form\\SearchCourseType', 18 => 'App\\Form\\Team2Type', 19 => 'App\\Form\\Team3Type', 20 => 'App\\Form\\TeamType', 21 => 'App\\Form\\Tournoi2Type', 22 => 'App\\Form\\TournoiType', 23 => 'App\\Form\\UpdateCourseType', 24 => 'App\\Form\\UserOnlineCoachingType', 25 => 'Symfony\\Component\\Form\\Extension\\Core\\Type\\FormType', 26 => 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType', 27 => 'Symfony\\Component\\Form\\Extension\\Core\\Type\\FileType', 28 => 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ColorType', 29 => 'Symfony\\Bridge\\Doctrine\\Form\\Type\\EntityType'], [0 => 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TransformationFailureExtension', 1 => 'Symfony\\Component\\Form\\Extension\\HttpFoundation\\Type\\FormTypeHttpFoundationExtension', 2 => 'Symfony\\Component\\Form\\Extension\\Validator\\Type\\FormTypeValidatorExtension', 3 => 'Symfony\\Component\\Form\\Extension\\Validator\\Type\\RepeatedTypeValidatorExtension', 4 => 'Symfony\\Component\\Form\\Extension\\Validator\\Type\\SubmitTypeValidatorExtension', 5 => 'Symfony\\Component\\Form\\Extension\\Validator\\Type\\UploadValidatorExtension', 6 => 'Symfony\\Component\\Form\\Extension\\Csrf\\Type\\FormTypeCsrfExtension', 7 => 'Symfony\\Component\\Form\\Extension\\DataCollector\\Type\\DataCollectorTypeExtension'], [0 => 'Symfony\\Component\\Form\\Extension\\Validator\\ValidatorTypeGuesser', 1 => 'Symfony\\Bridge\\Doctrine\\Form\\DoctrineOrmTypeGuesser'], ($container->privates['debug.file_link_formatter'] ?? $container->getDebug_FileLinkFormatterService()));

        $instance->setName('debug:form');
        $instance->setDescription('Display form type information');

        return $instance;
    }
}
