<?php

namespace App\Form;

use App\Entity\Announce;
use App\Entity\ClassificationMaterial;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', HiddenType::class, [
                'data' => 'chercher',
                'attr' => [
                    'class' => 'hidden-input',
                ] 
            ])    

            ->add('geographicalArea', TextType::class, [
                'label' => 'Localisation',
                'attr' => [
                    'placeholder' => 'Entrez le code postal',
                    'id' => 'search_geographicalArea',
                ],
                'required' => true,
            ])

            ->add('classification', EntityType::class, [
                'class' => ClassificationMaterial::class,
                'choice_label' => 'name',
                'placeholder' => '--',
                'attr' =>
                [
                    'onchange' => 'toggleMaterialSelect()',
                    'id' => 'classification',
                ],
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Announce::class,
            'allow_extra_fields' => true,
        ]);
    }
}
