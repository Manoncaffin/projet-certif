<?php

namespace App\Form;

use App\Entity\Announce;
use App\Entity\ClassificationMaterial;
use App\Entity\Material;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('volume')
            ->add('reference')
            ->add('geographicalArea')
            ->add('description')
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('classification', EntityType::class, [
                'class' => ClassificationMaterial::class,
                'choice_label' => 'id',
            ])
            ->add('material', EntityType::class, [
                'class' => Material::class,
                'choice_label' => 'id',
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
