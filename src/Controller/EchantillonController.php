<?php

namespace App\Controller;

use App\Entity\Echantillon;
use App\Form\AddEchantillonOneByOneType;
use App\Repository\EchantillonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EchantillonController extends AbstractController
{
    #[Route('echantillon/{id}/modifier', name: 'app_echantillons_edit',)]
    public function editEchantillon(Request $request, Echantillon $echantillon, EchantillonRepository $echantillonRepository): Response
    {
        if ($this->getUser()->isFirstConnection() === true) {
            $this->addFlash('warning', 'Vous devez changer votre mot de passe avant de pouvoir naviguer sur le site ');
            return $this->redirectToRoute('app_change_password');
        }

        $form = $this->createForm(AddEchantillonOneByOneType::class, $echantillon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dateF = $form->get('dateOfManufacturing')->getData();
            $dateDlc = $form->get('DlcOrDluo')->getData();
            $dateAnalyse = $form->get('dateAnalyse')->getData();

            if ($dateDlc < $dateF) {
                $this->addFlash('danger', 'La date de DLC ne peut pas être plus ancienne que la date de fabrication');
                return $this->redirectToRoute('app_echantillons_edit', [
                    'id' => $echantillon->getId()
                ]);
            }

            if ($dateAnalyse < $dateF) {
                $this->addFlash('danger', 'La date d\'analyse ne peut pas être plus ancienne que la date de fabrication');
                return $this->redirectToRoute('app_echantillons_edit', [
                    'id' => $echantillon->getId()
                ]);
            }

            if ($form->get('analyseDlc')->getData() === true) {
                if ($dateF === null || $dateDlc === null) {
                    $this->addFlash('danger', 'Vous devez saisir la date de fabrication ainsi que la DLC ou DLUO !');
                    return $this->redirectToRoute('app_echantillons_edit', [
                        'id' => $echantillon->getId(),
                    ]);
                }
            }

            if ($form->get('validationDlc')->getData() === true) {
                if ($form->get('dateOfBreak')->getData() === null || $form->get('tempOfBreak')->getData() === null) {
                    $this->addFlash('danger', 'Vous devez saisir une température de rupture et une date de rupture !');
                    return $this->redirectToRoute('app_echantillons_edit', [
                        'id' => $echantillon->getId(),
                    ]);
                } else {
                    $echantillon->setDateOfBreak($form->get('dateOfBreak')->getData());
                    $echantillon->setTempOfBreak($form->get('tempOfBreak')->getData());
                }
            }

            $echantillonRepository->save($echantillon, true);
            $this->addFlash('success', 'Votre échantillon vient d\'être modifier !');

            return $this->redirectToRoute('app_detail_echantillon', [
                'id' => $echantillon->getId()
            ]);
        }

        return $this->render('echantillon/addOneByOne.html.twig', [
            'echantillon' => $echantillon,
            'form' => $form->createView(),
        ]);
    }

    #[Route('echantillon/{id}', name: 'app_detail_echantillon',)]
    public function showEchantillon(Echantillon $echantillon): Response
    {
        if ($this->getUser()->isFirstConnection() === true) {
            $this->addFlash('warning', 'Vous devez changer votre mot de passe avant de pouvoir naviguer sur le site ');
            return $this->redirectToRoute('app_change_password');
        }

        if ($this->getUser()->getId() !== $echantillon->getEntreprise()->getId()) {
            if (in_array('ROLE_ADMIN', $this->getUser()->getRoles(), true)) {
                return $this->render('echantillon/show.html.twig', [
                    'echantillon' => $echantillon,
                ]);
            }
            $this->addFlash('warning', 'Vous n\'êtes pas autorisé à accéder à cette page');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('echantillon/show.html.twig', [
            'echantillon' => $echantillon,
        ]);
    }
}
