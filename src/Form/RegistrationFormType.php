<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Veuillez saisir l\'adresse mail de votre entreprise :',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez saisir une adresse mail'
                    ])
                ],
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('name', TextType::class, [
                'label' => 'Le nom de votre entreprise :',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir le nom de votre entreprise'
                    ])
                ],
                'required' => false,
                'attr' => [
                    'class' => 'qsa-input-form rounded'
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'required' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mot de passe doivent être identiques',
                'first_name' => 'first',
                'second_name' => 'second',
                'first_options' => [

                    'label' => 'Veuillez saisir un mot de passe :',
                    'attr' => [
                        'class' => 'd-flex form-control'
                    ],

                ],
                'second_options' => [
                    'label' => 'Veuillez resaisir votre mot de passe :',
                    'label_attr' => [
                        'class' => 'mt-1',
                    ],
                    'attr' => [
                        'class' => 'form-control',
                    ],
                ],
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez saisir un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit faire au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
