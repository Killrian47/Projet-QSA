<?php

namespace App\Form;

use App\Entity\Analyse;
use App\Entity\Conditionnement;
use App\Entity\Echantillon;
use App\Entity\Entreprise;
use App\Entity\EtatPhysique;
use App\Entity\Lieu;
use App\Entity\Stockage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddEchantillonOneByOneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('productName', TextType::class, [
                'attr' => [
                    'class' => 'qsa-input-form rounded'
                ],
                'label' => 'Nom du produit :'
            ])
            ->add('numberOfBatch', TextType::class, [
                'attr' => [
                    'class' => 'qsa-input-form rounded'
                ],
                'label' => 'Numéro de lot :'
            ])
            ->add('supplier', TextType::class, [
                'attr' => [
                    'class' => 'qsa-input-form rounded'
                ],
                'label' => 'Fournisseur / Fabricant du produit :'
            ])
            ->add('temperatureOfProduct', IntegerType::class, [
                'attr' => [
                    'class' => 'qsa-input-form rounded'
                ],
                'label' => 'Température du produit :'
            ])
            ->add('temperatureOfEnceinte', IntegerType::class, [
                'attr' => [
                    'class' => 'qsa-input-form rounded'
                ],
                'label' => 'Température de l\'enceinte :'
            ])
            ->add('dateOfManufacturing', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'qsa-input-form rounded',
                ],
                'label' => 'Date Abat. / Fabrication :'
            ])
            ->add('DlcOrDluo', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'qsa-input-form rounded',
                ],
                'label' => 'DLC / DLUO :'
            ])
            ->add('dateOfSampling', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'qsa-input-form rounded',
                ],
                'label' => 'Prélevé :'
            ])
            ->add('analyseDlc', CheckboxType::class, [
                'label' => 'Analyse à DLC ?'
            ])
            ->add('validationDlc', CheckboxType::class, [
                'label' => 'Validation de DLC ?'
            ])
            ->add('conditioning', EntityType::class, [
                'class' => Conditionnement::class,
                'attr' => [
                    'class' => 'qsa-input-form rounded',
                ],
                'placeholder' => '-- Sélectionner le conditionnement --',
            ])
            ->add('etatPhysique', EntityType::class, [
                'class' => EtatPhysique::class,
                'attr' => [
                    'class' => 'qsa-input-form rounded',
                ],
                'placeholder' => '-- Sélectionner l\'état physique du produit --',
            ])
            ->add('Lieu', EntityType::class, [
                'class' => Lieu::class,
                'attr' => [
                    'class' => 'qsa-input-form rounded',
                ],
                'placeholder' => '-- Sélectionner le lieu --',
            ])
            ->add('stockage', EntityType::class, [
                'class' => Stockage::class,
                'attr' => [
                    'class' => 'qsa-input-form rounded',
                ],
                'placeholder' => '-- Sélectionner le stockage --',
            ])
            ->add('analyse', EntityType::class, [
                'class' => Analyse::class,
                'attr' => [
                    'class' => 'qsa-input-form rounded',
                ],
                'placeholder' => '-- Sélectionner l\'analyse à faire sur le produit --',
            ])
            ->add('samplingBy', EntityType::class, [
                'class' => Entreprise::class,
                'attr' => [
                    'class' => 'qsa-input-form rounded',
                ],
                'placeholder' => '-- Prélevé par --',
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn qsa-btn mt-3'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Echantillon::class,
        ]);
    }
}
