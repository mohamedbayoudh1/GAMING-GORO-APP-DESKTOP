<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nompost', null, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 5])
                ],
            ])
            ->add('contenu', null, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 10])
                ],
            ])
            ->add('imgp',FileType::class, [
                'label' => 'image du cours',

                'mapped' => false, //maneha maandi attribut esmo photo fl entity mte3na
                'required' => false,
                'attr'=>[
                    'placeholder' => 'Select a file',
                    'style' => 'color:white;height:65px;background-color:#22152c;width:100%;border: none;margin:0px 0px 10px;padding:24px 33px'

                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
