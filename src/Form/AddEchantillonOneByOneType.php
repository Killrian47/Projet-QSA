<?php

namespace App\Form;

use App\Entity\Analyse;
use App\Entity\Conditionnement;
use App\Entity\Echantillon;
use App\Entity\Entreprise;
use App\Entity\EtatPhysique;
use App\Entity\Lieu;
use App\Entity\Stockage;
use App\Repository\AnalyseRepository;
use App\Repository\EntrepriseRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
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
use Symfony\Component\Validator\Constraints\NotBlank;

class AddEchantillonOneByOneType extends AbstractType
{
    public function __construct(
        private Security $security,
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser();

        $builder
            ->add('productName', TextType::class, [
                'attr' => [
                    'class' => 'qsa-input-form-needed rounded'
                ],
                'label' => 'Nom du produit :',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez saisir le nom du produit',
                    ])
                ]
            ])
            ->add('numberOfBatch', TextType::class, [
                'attr' => [
                    'class' => 'qsa-input-form rounded'
                ],
                'label' => 'Numéro de lot :',
                'required' => false

            ])
            ->add('supplier', TextType::class, [
                'attr' => [
                    'class' => 'qsa-input-form rounded'
                ],
                'label' => 'Fournisseur / Fabricant du produit :',
                'required' => false

            ])
            ->add('temperatureOfProduct', IntegerType::class, [
                'attr' => [
                    'class' => 'qsa-input-form rounded'
                ],
                'label' => 'Température du produit :',
                'required' => false

            ])
            ->add('temperatureOfEnceinte', IntegerType::class, [
                'attr' => [
                    'class' => 'qsa-input-form rounded'
                ],
                'label' => 'Température de l\'enceinte :',
                'required' => false

            ])
            ->add('dateOfManufacturing', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'qsa-input-form rounded',
                ],
                'label' => 'Date Abat. / Fabrication :',
                'required' => false

            ])
            ->add('dateAnalyse', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'qsa-input-form-needed rounded',
                ],
                'label' => 'Date d\'analyse :',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez saisir un date d\'analyse'
                    ])
                ]

            ])
            ->add('DlcOrDluo', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'qsa-input-form rounded',
                ],
                'label' => 'DLC / DLUO :',
                'required' => false

            ])
            ->add('dateOfSampling', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'qsa-input-form-needed rounded',
                ],
                'label' => 'Prélevé le ? à ?',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez saisir une date de prélèvement'
                    ])
                ]

            ])
            ->add('analyseDlc', CheckboxType::class, [
                'label' => 'Analyse à DLC ?',
                'label_attr' => [
                    'class' => 'me-2'
                ],
                'required' => false
            ])
            ->add('validationDlc', CheckboxType::class, [
                'label' => 'Validation de DLC (Par LOT)',
                'label_attr' => [
                    'class' => 'me-2 validation-dlc-check-box',
                ],
                'required' => false,
                'attr' => [
                    'id' => 'check_box'
                ],
            ])
            ->add('conditioning', EntityType::class, [
                'class' => Conditionnement::class,
                'attr' => [
                    'class' => 'qsa-input-form-needed rounded',
                ],
                'placeholder' => '-- Sélectionner le conditionnement --',
                'required' => false,
                'label' => 'Conditionnement :',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez sélectionné le conditionnement'
                    ])
                ]

            ])
            ->add('etatPhysique', EntityType::class, [
                'class' => EtatPhysique::class,
                'attr' => [
                    'class' => 'qsa-input-form-needed rounded',
                ],
                'placeholder' => '-- Sélectionner l\'état physique du produit --',
                'required' => false,
                'label' => 'État physique :',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez sélectionné l\'état physique'
                    ])
                ]

            ])
            ->add('analyse', EntityType::class, [
                'class' => Analyse::class,
                'attr' => [
                    'class' => 'qsa-input-form rounded',
                ],
                'placeholder' => '-- Sélectionner l\'analyse à faire sur le produit --',
                'required' => false,
                'query_builder' => function (AnalyseRepository $repo) use ($user) {
                    return $repo->createQueryBuilder('a')
                        ->where('a.entreprise = :userId')
                        ->setParameter('userId', $user->getId());
                }

            ])
            ->add('samplingBy', EntityType::class, [
                'class' => Entreprise::class,
                'attr' => [
                    'class' => 'qsa-input-form rounded',
                ],
                'placeholder' => '-- Prélevé par --',
                'label' => 'Prélevé par :',
                'query_builder' => function (EntrepriseRepository $er) use ($user) {
                    return $er->createQueryBuilder('e')
                        ->where('e.name LIKE :qsa')
                        ->orWhere('e.id = :userId')
                        ->setParameters([
                            'qsa' => 'QSA',
                            'userId' => $user->getId(),
                        ]);
                },
                'required' => false
            ])
            ->add('tempOfBreak', IntegerType::class, [
                'attr' => [
                    'class' => 'qsa-input-form rounded ',
                ],
                'label' => 'Température de rupture :',
                'required' => false,
            ])
            ->add('dateOfBreak', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'qsa-input-form rounded',
                ],
                'label' => 'Date de rupture :',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Echantillon::class,
        ]);
    }
}
