<?php

namespace App\Controller;

use App\Repository\EntrepriseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntrepriseStartByLettersController extends AbstractController
{
    #[Route('/admin/entreprise/ABC', name: 'app_entreprise_start_by_ABC')]
    public function entrepriseStartByABC(EntrepriseRepository $entrepriseRepository): Response
    {

        $entreprisesStartedByA = $entrepriseRepository->entrepriseStartedByA();
        $entreprisesStartedByB = $entrepriseRepository->entrepriseStartedByB();
        $entreprisesStartedByC = $entrepriseRepository->entrepriseStartedByC();

        return $this->render('admin/entreprise_start_by_letters/ABC/index.html.twig', [
            'entreprisesA' => $entreprisesStartedByA,
            'entreprisesB' => $entreprisesStartedByB,
            'entreprisesC' => $entreprisesStartedByC
        ]);
    }

    #[Route('/admin/entreprise/DEF', name: 'app_entreprise_start_by_DEF')]
    public function entrepriseStartByDEF(EntrepriseRepository $entrepriseRepository): Response
    {

        $entreprisesStartedByD = $entrepriseRepository->entrepriseStartedByD();
        $entreprisesStartedByE = $entrepriseRepository->entrepriseStartedByE();
        $entreprisesStartedByF = $entrepriseRepository->entrepriseStartedByF();

        return $this->render('admin/entreprise_start_by_letters/DEF/index.html.twig', [
            'entreprisesD' => $entreprisesStartedByD,
            'entreprisesE' => $entreprisesStartedByE,
            'entreprisesF' => $entreprisesStartedByF
        ]);
    }

    #[Route('/admin/entreprise/GHIJ', name: 'app_entreprise_start_by_GHIJ')]
    public function entrepriseStartByGHIJ(EntrepriseRepository $entrepriseRepository): Response
    {

        $entreprisesStartedByG = $entrepriseRepository->entrepriseStartedByG();
        $entreprisesStartedByH = $entrepriseRepository->entrepriseStartedByH();
        $entreprisesStartedByI = $entrepriseRepository->entrepriseStartedByI();
        $entreprisesStartedByJ = $entrepriseRepository->entrepriseStartedByJ();

        return $this->render('admin/entreprise_start_by_letters/GHIJ/index.html.twig', [
            'entreprisesG' => $entreprisesStartedByG,
            'entreprisesH' => $entreprisesStartedByH,
            'entreprisesI' => $entreprisesStartedByI,
            'entreprisesJ' => $entreprisesStartedByJ,
        ]);
    }

    #[Route('/admin/entreprise/KLM', name: 'app_entreprise_start_by_KLM')]
    public function entrepriseStartByKLM(EntrepriseRepository $entrepriseRepository): Response
    {

        $entreprisesStartedByK = $entrepriseRepository->entrepriseStartedByK();
        $entreprisesStartedByL = $entrepriseRepository->entrepriseStartedByL();
        $entreprisesStartedByM = $entrepriseRepository->entrepriseStartedByM();

        return $this->render('admin/entreprise_start_by_letters/KLM/index.html.twig', [
            'entreprisesK' => $entreprisesStartedByK,
            'entreprisesL' => $entreprisesStartedByL,
            'entreprisesM' => $entreprisesStartedByM
        ]);
    }

    #[Route('/admin/entreprise/NOPQ', name: 'app_entreprise_start_by_NOPQ')]
    public function entrepriseStartByNOPQ(EntrepriseRepository $entrepriseRepository): Response
    {

        $entreprisesStartedByN = $entrepriseRepository->entrepriseStartedByN();
        $entreprisesStartedByO = $entrepriseRepository->entrepriseStartedByO();
        $entreprisesStartedByP = $entrepriseRepository->entrepriseStartedByP();
        $entreprisesStartedByQ = $entrepriseRepository->entrepriseStartedByQ();

        return $this->render('admin/entreprise_start_by_letters/NOPQ/index.html.twig', [
            'entreprisesN' => $entreprisesStartedByN,
            'entreprisesO' => $entreprisesStartedByO,
            'entreprisesP' => $entreprisesStartedByP,
            'entreprisesQ' => $entreprisesStartedByQ,
        ]);
    }

    #[Route('/admin/entreprise/RSTU', name: 'app_entreprise_start_by_RSTU')]
    public function entrepriseStartByRSTU(EntrepriseRepository $entrepriseRepository): Response
    {

        $entreprisesStartedByR = $entrepriseRepository->entrepriseStartedByR();
        $entreprisesStartedByS = $entrepriseRepository->entrepriseStartedByS();
        $entreprisesStartedByT = $entrepriseRepository->entrepriseStartedByT();
        $entreprisesStartedByU = $entrepriseRepository->entrepriseStartedByU();

        return $this->render('admin/entreprise_start_by_letters/RSTU/index.html.twig', [
            'entreprisesR' => $entreprisesStartedByR,
            'entreprisesS' => $entreprisesStartedByS,
            'entreprisesT' => $entreprisesStartedByT,
            'entreprisesU' => $entreprisesStartedByU,
        ]);
    }

    #[Route('/admin/entreprise/VWXYZ', name: 'app_entreprise_start_by_VWXYZ')]
    public function entrepriseStartByVWXYZ(EntrepriseRepository $entrepriseRepository): Response
    {

        $entreprisesStartedByV = $entrepriseRepository->entrepriseStartedByV();
        $entreprisesStartedByW = $entrepriseRepository->entrepriseStartedByW();
        $entreprisesStartedByX = $entrepriseRepository->entrepriseStartedByX();
        $entreprisesStartedByY = $entrepriseRepository->entrepriseStartedByY();
        $entreprisesStartedByZ = $entrepriseRepository->entrepriseStartedByZ();

        return $this->render('admin/entreprise_start_by_letters/VWXYZ/index.html.twig', [
            'entreprisesV' => $entreprisesStartedByV,
            'entreprisesW' => $entreprisesStartedByW,
            'entreprisesX' => $entreprisesStartedByX,
            'entreprisesY' => $entreprisesStartedByY,
            'entreprisesZ' => $entreprisesStartedByZ,
        ]);
    }
}
