<?php

namespace App\Form;

use App\Entity\SectorActivity;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('roles', CheckboxType::class) 

            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'id' => 'firstname',
                    'name' => 'firstname',
                    'placeholder' => 'Votre prénom',
                    'required' => 'true',
                ]
            ])

            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'id' => 'lastname',
                    'name' => 'lastname',
                    'placeholder' => 'Votre nom',
                    'required' => 'true',
                ]
            ])

            // ->add('password', PasswordType::class, [
            //     'label' => 'Mot de passe',
            //     'attr' => [
            //     'name' => 'password',
            //     'id' => 'inputPassword',
            //     'class' => 'form-control',
            //     'autocomplete' => 'current-password',
            //     'placeholder' => 'Votre mot de passe',
            //     ]
            // ])

            ->add('identifier', TextType::class, [
                'label' => 'Identifiant',
                'attr' => [
                    'id' => 'identifier',
                    'name' => 'identifier',
                    'placeholder' => 'Votre identifiant',
                    'class' => 'form-control',
                    'autocomplete' => 'identifier',
                ]
            ])
            
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'id' => 'email',
                    'name' => 'email',
                    'placeholder' => 'Votre adresse email',
                    'class' => 'form-control', 
                    'autocomplete' => 'email',
                ]
            ])

            ->add('professional', ChoiceType::class, [
                'choices' => [
                    'Je suis un·e particulier' => 'particulier',
                    'Je suis un·e professionnel·le' => 'professional',
                ],
                'required' => true,
                'expanded' => true,
                'mapped' => false,
                'empty_data' => 'particulier'
            ]) 

            ->add('sectorActivity', EntityType::class, [
                'class' => SectorActivity::class,
                'choice_label' => 'activity',
                // 'query_builder' => function (EntityRepository $er) {
                //     return $er->createQueryBuilder('c')
                //     ->orderBy('c.activity', 'ASC');
                // },
                // 'required' => true,
                'attr' => [
                    'id' => 'activity-select',
                ],
            ])

            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'required' => 'true',
                        'placeholder' => 'Votre mot de passe',
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez entrer un mot de passe',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                            'max' => 4096,
                        ]),
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmation',
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'required' => 'true',
                        'placeholder' => 'Confirmez votre mot de passe',
                    ],
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas',
                'mapped' => false,
            ]);  
    

        
    }

    // C’est ici que l’on y indique à quelle entité est rattachée ce formulaire.
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
