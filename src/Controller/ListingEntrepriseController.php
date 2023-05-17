<?php

namespace App\Controller;

use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;

class ListingEntrepriseController extends AbstractController
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    #[Route('/admin', name: 'app_entreprise')]
    public function index(PaginatorInterface $paginator, Request $request, EntrepriseRepository $entrepriseRepository,): Response
    {
        $entreprises = $entrepriseRepository->findBY([], ['name' => 'ASC']);
        $query = $this->manager->createQuery('SELECT e FROM App\Entity\Entreprise e ORDER BY e.name ASC');
        $pagination = $paginator->paginate($query,$request->query->getInt('page', 1), 2);


        return $this->render('listing_entreprise/index.html.twig', [
            'entreprises' => $entreprises,
            'pagination' => $pagination
        ]);
    }
}
