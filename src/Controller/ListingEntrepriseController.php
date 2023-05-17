<?php

namespace App\Controller;

use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ListingEntrepriseController extends AbstractController
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    #[Route('/admin/liste-des-entreprises', name: 'app_entreprise')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(PaginatorInterface $paginator, Request $request,): Response
    {
        $query = $this->manager->createQuery('SELECT e FROM App\Entity\Entreprise e ORDER BY e.name ASC')->getResult();
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            30
        );

        return $this->render('listing_entreprise/index.html.twig', [
            'pagination' => $pagination
        ]);
    }
}
