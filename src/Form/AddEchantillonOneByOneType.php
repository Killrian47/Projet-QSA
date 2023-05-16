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

class AddEchantillonOneByOneType extends AbstractType
{
    public function __construct(
        private Security $security,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser();

        $builder
            ->add('productName', TextType::class, [
                'attr' => [
                    'class' => 'qsa-input-form rounded'
                ],
                'label' => 'Nom du produit :',
                'required' => false

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
                    'class' => 'qsa-input-form rounded',
                ],
                'label' => 'Date d\'analyse :',
                'required' => false

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
                    'class' => 'qsa-input-form rounded',
                ],
                'label' => 'Prélevé le ? à ?',
                'required' => false

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
                    'class' => 'me-2'
                ],
                'required' => false
            ])
            ->add('conditioning', EntityType::class, [
                'class' => Conditionnement::class,
                'attr' => [
                    'class' => 'qsa-input-form rounded',
                ],
                'placeholder' => '-- Sélectionner le conditionnement --',
                'required' => false

            ])
            ->add('etatPhysique', EntityType::class, [
                'class' => EtatPhysique::class,
                'attr' => [
                    'class' => 'qsa-input-form rounded',
                ],
                'placeholder' => '-- Sélectionner l\'état physique du produit --',
                'required' => false

            ])
            ->add('Lieu', EntityType::class, [
                'class' => Lieu::class,
                'attr' => [
                    'class' => 'qsa-input-form rounded',
                ],
                'placeholder' => '-- Sélectionner le lieu --',
                'required' => false

            ])
            ->add('stockage', EntityType::class, [
                'class' => Stockage::class,
                'attr' => [
                    'class' => 'qsa-input-form rounded',
                ],
                'placeholder' => '-- Sélectionner le stockage --',
                'required' => false

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
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn qsa-btn mt-3'
                ],
                'label' => 'Ajouter l\'échantillon au bon de commande'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Echantillon::class,
        ]);
    }
}
