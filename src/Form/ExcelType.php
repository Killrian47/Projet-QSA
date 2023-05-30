<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class ExcelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('csv_file', FileType::class, [
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'text/csv',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.oasis.opendocument.spreadsheet'
                        ],
                        'mimeTypesMessage' => 'Merci d\'envoyer un fichier .csv ou .xlsx',
                    ]),
                    new NotBlank([
                        'message' => 'Vous devez envoyer un fichier !'
                    ])
                ],
                'required' => false,
                'mapped' => false,
                'label' => 'Ajouter un fichier excel avec les échantillons :',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
        ->add('submit', SubmitType::class, [
            'attr' => [
                'class' => 'qsa-btn btn mt-2'
            ],
            'label' => 'Envoyer les échantillons'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
