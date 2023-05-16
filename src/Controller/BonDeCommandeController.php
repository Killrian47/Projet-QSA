<?php

namespace App\Controller;

use App\Entity\Echantillon;
use App\Entity\Order;
use App\Form\AddEchantillonOneByOneType;
use App\Repository\EchantillonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BonDeCommandeController extends AbstractController
{
    #[Route('/bon-de-commande/{id}', name: 'app_detail_order')]
    public function detailOrder(Order $order, EchantillonRepository $echantillonRepository): Response
    {
        if ($this->getUser()->getId() !== $order->getEntreprise()->getId()) {
            foreach ($this->getUser()->getRoles() as $role) {
                if ($role === 'ROLE_ADMIN') {
                    $echantillons = $echantillonRepository->findBy(['NumberOfOrder' => $order->getId()]);

                    return $this->render('order/orderDetail.html.twig', [
                        'order' => $order,
                        'echantillons' => $echantillons,
                    ]);
                }
            }
            $this->addFlash('danger', 'Vous n\'êtes pas autorisé à aller sur cette page');
            return $this->redirectToRoute('app_home');
        }

        $echantillons = $echantillonRepository->findBy(['NumberOfOrder' => $order->getId()]);

        return $this->render('order/orderDetail.html.twig', [
            'order' => $order,
            'echantillons' => $echantillons,
        ]);
    }

    #[Route('/bon-de-commande/ajouter-un-échantillon-manquant/{id}', name: 'app_add_missing_echantillon_to_order')]
    public function addMissingEchantillon(Request $request, Order $order, EntityManagerInterface $manager): Response
    {
        if ($this->getUser()->getId() !== $order->getEntreprise()->getId()) {
            $this->addFlash('danger', 'Vous n\'êtes pas a l\'origine de ce bon de commande, vous ne pouvez pas accéder à cette page');
            return $this->redirectToRoute('app_home');
        }

        $echantillon = new Echantillon();
        $form = $this->createForm(AddEchantillonOneByOneType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $echantillon->setEntreprise($this->getUser());
            $echantillon->setNumberOfOrder($order);
            $echantillon->setProductName($form->get('productName')->getData());
            $echantillon->setNumberOfBatch($form->get('numberOfBatch')->getData());
            $echantillon->setSupplier($form->get('supplier')->getData());
            $echantillon->setTemperatureOfProduct($form->get('temperatureOfProduct')->getData());
            $echantillon->setTemperatureOfEnceinte($form->get('temperatureOfEnceinte')->getData());
            $echantillon->setDateOfManufacturing($form->get('dateOfManufacturing')->getData());
            $echantillon->setDlcOrDluo($form->get('DlcOrDluo')->getData());
            $echantillon->setDateOfSampling($form->get('dateOfSampling')->getData());
            $echantillon->setAnalyseDlc($form->get('analyseDlc')->getData());
            $echantillon->setValidationDlc($form->get('validationDlc')->getData());
            $echantillon->setConditioning($form->get('conditioning')->getData());
            $echantillon->setEtatPhysique($form->get('etatPhysique')->getData());
            $echantillon->setLieu($form->get('Lieu')->getData());
            $echantillon->setStockage($form->get('stockage')->getData());
            $echantillon->setAnalyse($form->get('analyse')->getData());
            $echantillon->setSamplingBy($form->get('samplingBy')->getData());
            $dateF = $form->get('dateOfManufacturing')->getData();
            $dateDlc = $form->get('DlcOrDluo')->getData();

            if ($dateDlc < $dateF) {
                $this->addFlash('danger', 'La date de DLC ne peut pas être plus ancienne que la date de fabrication');
                return $this->redirectToRoute('app_detail_order', [
                    'id' => $order->getId()
                ]);
            }

            $manager->persist($echantillon);
            $manager->flush();

            $this->addFlash('success', 'L\'échantillon manquant vient d\'être rajouté !');
            return $this->redirectToRoute('app_detail_order', [
                'id' => $order->getId()
            ]);
        }

        return $this->render('echantillon/addOneByOne.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
