<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => 'Votre adresse mail :',
                'attr' => [
                    'class' => 'qsa-input-form rounded qsa-input-form-disabled'
                ]
            ])
            ->add('name', TextType::class, [
                'disabled' => true,
                'label' => 'Le nom de votre entreprise :',
                'attr' => [
                    'class' => 'qsa-input-form rounded qsa-input-form-disabled'
                ]
            ])
            ->add('old_password', PasswordType::class, [
                'mapped' => false,
                'label' => 'Veuillez saisir votre mot de passe actuel :',
                'attr' => [
                    'class' => 'qsa-input-form rounded'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir votre mot de passe actuel'
                    ])
                ],
                'required' => false
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mot de passe doivent être identiques !',
                'first_name' => 'first',
                'second_name' => 'second',
                'first_options' => [
                    'label' => 'Veuillez saisir votre nouveau mot de passe :',
                    'attr' => [
                        'class' => 'qsa-input-form rounded'
                    ],
                ],
                'second_options' => [
                    'label' => 'Veuillez saisir à nouveau le mot de passe :',
                    'attr' => [
                        'class' => 'qsa-input-form rounded'
                    ],
                ],
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new_password',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir votre nouveau mot de passe !'
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit faire au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ])
                ],
                'required' => false
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn qsa-btn mt-3 '
                ],
                'label' => 'Confirmer les modifications'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
