<?php

namespace App\Form;

use App\Entity\SectorActivity;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('roles', CheckboxType::class) 
            ->add('password', PasswordType::class)
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            // LISTE DEROULANTE
            ->add('sectorActivity', EntityType::class, [
                'class' => SectorActivity::class,
                'choice_label' => 'name',
            ])
        ;
    }

    // C’est ici que l’on y indique à quelle entité est rattachée ce formulaire.
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
