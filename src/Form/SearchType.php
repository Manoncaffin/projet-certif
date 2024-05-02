<?php

namespace App\Form;

use App\Entity\Announce;
use App\Entity\ClassificationMaterial;
use App\Entity\Material;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('geographicalArea', TextType::class, [
            'label' => 'Localisation',
            'attr' => [
                'placeholder' => 'Entrez le code postal',
            ]
            ])

            ->add('classification', EntityType::class, [
                'class' => ClassificationMaterial::class,
                'choice_label' => 'name',
                'placeholder' => '--',
                'attr' => 
                [
                    'onchange' => 'toggleMaterialSelect()',
                    'id' => 'material-geo-select',
            ],
                'required' => true,
            ])

            // ->add('material', EntityType::class, [
            //     'class' => Material::class,
            //     'label' => 'Matériau',
            //     'choice_label' => 'material',
            //     'placeholder' => '--',
            //     'attr' => [
            //     'id' => 'material-geo-select',
            //     'required' => true,
            //     ],
            //     'query_builder' => function (EntityRepository $er) {
            //         return $er->createQueryBuilder('c')
            //             ->orderBy('c.material', 'ASC');
            //     }
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Announce::class,
        ]);
    }
}
