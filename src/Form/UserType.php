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
            // ->add('roles', CheckboxType::class) 

            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'attr' => [
                'name' => 'password',
                'id' => 'inputPassword',
                'class' => 'form-control',
                'autocomplete' => 'current-password',
                'placeholder' => 'Votre mot de passe',
                'required' => 'true',
                ]
            ])

            ->add('identifier', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'id' => 'firstname',
                    'name' => 'firstname',
                    'placeholder' => 'Votre prénom',
                    'required' => 'true',
                ]
            ])
            
            ->add('email', EmailType::class, [
                'label' => 'Nom',
                'attr' => [
                    'id' => 'lastname',
                    'name' => 'lastname',
                    'placeholder' => 'Votre nom',
                    'required' => 'true',
                ]
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
