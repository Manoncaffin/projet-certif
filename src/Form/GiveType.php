<?php

namespace App\Form;

use App\Entity\Announce;
use App\Entity\ClassificationMaterial;
use App\Entity\Material;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GiveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            // LISTE DEROULANTE
            ->add('volume', NumberType::class, [
                'label' => 'Volume',
                'choice_label' => 'number',
                // La requête trie les options par ordre alphabétique en fonction du nom de la classification.
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                }
            ])
            ->add('reference')
            ->add('geographicalArea', TextType::class, [
                'label' => 'Localisation',
                'attr' => [
                    'placeholder' => 'Entrez le code postal',
                ]
                ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            // LISTE DEROULANTE
            ->add('classification', EntityType::class, [
                'label' => 'Classification',
                'attr' => [
                    'class' => 'btn-info btn-test     ',
                ],
                'class' => ClassificationMaterial::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                }
            ])
            // LISTE DEROULANTE
            ->add('material', EntityType::class, [
                'class' => Material::class,
                'choice_label' => 'name',
                // La requête trie les options par ordre alphabétique en fonction du nom de la classification.
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Announce::class,
        ]);
    }
}
