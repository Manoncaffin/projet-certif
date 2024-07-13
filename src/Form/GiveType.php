<?php

namespace App\Form;

use App\Entity\Announce;
use App\Entity\ClassificationMaterial;
use App\Entity\File;
use App\Entity\Material;
use App\Entity\User;
use App\Entity\Volume;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
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
            ->add('type', HiddenType::class, [
                'data' => 'donner',
                'attr' => [
                    'class' => 'hidden-input',
                ]
            ])

            ->add('volume', EntityType::class, [
                'class' => Volume::class,
                'label' => 'Valeur',
                'required' => true,
                'placeholder' => '--',
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'value-select',
                    'id' => 'value-select',
                ],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('v')
                        ->orderBy('v.name', 'ASC');
                },
            ])

            ->add('number', ChoiceType::class, [
                'label' => 'Quantité',
                'required' => true,
                'choices' => array_combine(range(1, 10), range(1, 10)),
                'placeholder' => '--',
                'attr' => [
                    'class' => 'quantity-select',
                    'id' => 'giveForm_number',
                ],
            ])

            ->add('geographicalArea', TextType::class, [
                'label' => 'Localisation',
                'attr' => [
                    'placeholder' => 'Entrez le code postal',
                    'id' => 'give_geographicalArea',
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

            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'id' => 'message',
                    'placeholder' => 'Entrez la description',
                ],
                'required' => true,
            ])

            ->add('photo', FileType::class,  [
                'label' => 'Joindre une photo',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\File([
                        'maxSize' => '2000k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Merci de télécharger une image valide (JPEG/PNG)',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Announce::class,
            'allow_extra_fields' => true,
        ]);
    }
}
