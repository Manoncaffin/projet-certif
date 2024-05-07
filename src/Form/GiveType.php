<?php

namespace App\Form;

use App\Entity\Announce;
use App\Entity\ClassificationMaterial;
use App\Entity\File;
use App\Entity\Material;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class GiveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('value', TextType::class, [
                // 'label' => 'Valeur',
                'required' => false,
                'mapped' => false,
            ])

            ->add('number', NumberType::class, [
                'label' => 'Quantité',
                'required' => true,
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
            ])

            ->add('material', EntityType::class, [
                'class' => Material::class,
                'label' => 'Matériau',
                'choice_label' => 'material',
                'attr' => [
                    'id' => 'material',
                    'placeholder' => '--',
                ],
                'required' => true,
            ])

            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => true,
            ])

            ->add('photo', FileType::class,  [
                'label' => 'Joindre une photo',
                'mapped' => false,
                'required' => true,
                // 'constraints' => [
                //     new File([
                //         'maxSize' => '1024k',
                //         'mimeTypesMessage' => 'Merci de télécharger une photo',
                //     ])
                // ],
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
