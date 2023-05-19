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
}
