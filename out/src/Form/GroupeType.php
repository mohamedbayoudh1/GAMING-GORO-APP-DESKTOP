<?php

namespace App\Form;

use App\Entity\Groupe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
class GroupeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom_groupe', TextType::class)
            ->add('img',FileType::class, [
                'label' => 'image du groupe',

                'mapped' => false,
                'required' => false,
                'attr'=>[
                    'placeholder' => 'Select a file',
                    'style' => 'color:white;height:65px;background-color:#22152c;width:100%;border: none;margin:0px 0px 10px;padding:24px 33px'

                ]
            ])

            ->add('description', TextType::class)
        ->add('nbr_max');
    }

    // ...


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Groupe::class,
        ]);
    }
}
