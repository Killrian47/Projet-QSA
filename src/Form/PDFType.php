<?php

namespace App\Form;

use App\Entity\Entreprise;
use App\Entity\Pdf;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class PDFType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file', FileType::class, [
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'application/pdf'
                        ],
                        'mimeTypesMessage' => 'Merci d\'envoyer un fichier en .pdf s\'il vous plaît',
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez sélectionner un fichier '
                    ])
                ],
                'label' => 'Le fichier pdf a envoyé vers le client :'
            ])
            ->add('entreprise', EntityType::class, [
                'class' => Entreprise::class,
                'autocomplete' => true,
                'placeholder' => 'Chercher l\'entreprise à qui lier le pdf ',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner une entreprise'
                    ])
                ],
                'label' => 'L\'entreprise à qui envoyé le pdf :',
                'label_attr' => [
                    'class' => 'mt-2'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn qsa-btn mt-3'
                ],
                'label' => 'Envoyer'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PDF::class,
        ]);
    }
}
