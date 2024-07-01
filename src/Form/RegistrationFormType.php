<?php

namespace App\Form;

use App\Entity\SectorActivity;
use App\Entity\User;
use App\Validator\Avatar;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('professional', ChoiceType::class, [
                'choices' => [
                    'Je suis un·e particulier' => 'particulier',
                    'Je suis un·e professionnel·le' => 'professional',
                ],
                'required' => true,
                'expanded' => true,
                'mapped' => true,
            ]) 

            ->add('sectorActivity', EntityType::class, [
                'class' => SectorActivity::class,
                'choice_label' => 'activity',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.activity', 'ASC');
                },
                'required' => true,
                'attr' => [
                    'id' => 'activity-select',
                ],
            ])

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

            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Votre adresse email',
                    'id' => 'email',
                    'name' => 'email',
                    'required' => 'true',
                ]
                ])

                ->add('identifier', TextType::class, [
                    'label' => 'Identifiant',
                    'attr' => [
                        'placeholder' => 'Choisir un identifiant',
                        'id' => 'identifier',
                        'name' => 'identifier',
                        'required' => 'true',
                    ]
                    ])

                ->add('avatar', FileType::class, [
                    'required' => false,
                    'mapped' => false,
                    'label' => 'Photo de profil',
                    'constraints' => [
                        new File([
                            'maxSize' => '1000K',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png',
                                'image/webP',
                            ],
                            'mimeTypesMessage' => 'Veuillez télécharger une image valide (JPEG, PNG, WEBP).',
                        ])
                    ]
                ])

                ->add('agreeTerms', RadioType::class, [
                    'label' => 'J\'accepte les termes et conditions',
                    'mapped' => false,
                    'attr' => [
                        'class'=> 'custom-checkbox',
                    ],
                    'required' => true,
                    'constraints' => [
                        new IsTrue([
                            'message' => 'Vous devez accepter les conditions.',
                        ]),
                    ],
                ])

                ->add('submit', SubmitType::class, [
                    'label' => 'Valider les informations',
                    'attr' => [
                        'class' => 'custom-submit',
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
                                'max' => 12,
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

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
