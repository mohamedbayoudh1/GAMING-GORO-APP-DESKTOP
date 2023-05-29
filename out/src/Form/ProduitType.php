<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Produit;
use phpDocumentor\Reflection\Types\False_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prix', IntegerType::class, [
                'label' => 'Positive prix',
                'constraints' => [
                    new GreaterThanOrEqual([
                        'value' => 0,
                        'message' => 'The number should be greater than or equal to zero.',
                    ]),
                ],
            ])
            ->add('description')
            ->add('imagep',FileType::class, [
                'label' => 'image du cours',

                'mapped' => false, //maneha maandi attribut esmo photo fl entity mte3na
                'required' => false,
                'attr'=>[
                    'placeholder' => 'Select a file',
                    'style' => 'color:white;height:65px;background-color:#22152c;width:100%;border: none;margin:0px 0px 10px;padding:24px 33px'

                ]
            ])
            ->add('idCategorie',EntityType::class,[  //foreign key
                'class' => Categorie::class,
                'choice_label'=>'nom',
                'multiple'=>False,
                'expanded'=>False,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
