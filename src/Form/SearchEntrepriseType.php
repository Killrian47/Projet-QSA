<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;

class SearchEntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('search', SearchType::class, [
                'required' => false,
                'label' => 'Rechercher une entreprise par son nom :',
                'attr' => [
                    'class' => 'qsa-input-form rounded'
                ]
            ])
            ->add('date1', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'qsa-input-form rounded',
                ],
                'label' => 'première date'
            ])
            ->add('date2', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'qsa-input-form rounded',
                ],
                'label' => 'deuxième date',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
