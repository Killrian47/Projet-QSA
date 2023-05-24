<?php

namespace App\Controller;

use App\Entity\Entreprise;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class EntrepriseController extends AbstractController
{
    #[Route('/entreprise/{id}', name: 'app_detail_entreprise')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(
        Entreprise $entreprise,
        EntityManagerInterface $manager,
        PaginatorInterface $paginator,
        Request $request,
        int $id
    ): Response
    {

        $query = $manager->createQuery('SELECT o FROM App\Entity\Order o WHERE o.entreprise = ' . $id . ' ORDER BY o.createdAt DESC');
        $pagination = $paginator->paginate($query, $request->query->getInt('page', 1), 5);


        return $this->render('entreprise/index.html.twig', [
            'entreprise' => $entreprise,
            'pagination' => $pagination,
        ]);
    }
}
