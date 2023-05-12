<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EchantillonController extends AbstractController
{
    #[Route('/echantillon', name: 'app_echantillon')]
    public function index(): Response
    {
        return $this->render('echantillon/index.html.twig', [
            'controller_name' => 'EchantillonController',
        ]);
    }
}
