<?php

namespace App\Controller;

use App\Form\SearchEntrepriseType;
use App\Repository\EntrepriseRepository;
use App\Repository\OrderRepository;
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
    public function index(PaginatorInterface $paginator, Request $request, EntrepriseRepository $entrepriseRepository, OrderRepository $orderRepository): Response
    {
        $form = $this->createForm(SearchEntrepriseType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if ($form->get('search')->getData() && $form->get('date1')->getData() && $form->get('date2')->getData()) {
                $search = $form->getData()['search'];
                $date1 = $form->get('date1')->getData();
                $date2 = $form->get('date2')->getData();
                $interval = $date1->diff($date2);
                if ($interval->d == 0) {
                    $date2->modify('+23 hour 59 minutes 59 seconds');
                }
                $allOrders = [];
                $orders = [];
                $entreprises = $entrepriseRepository->findByEntrepriseName($search);
                foreach ($entreprises as $entreprise) {
                    $allOrders[] = $orderRepository->findByEntrepriseAndDate($entreprise->getId(), $date1, $date2);
                }
                foreach ($allOrders as $order) {
                    foreach ($order as $value) {
                        if (!empty($value->getEchantillons()->toArray())) {
                            $orders[] = $value;
                        }
                    }
                }
                return $this->render('admin/searchEntrepriseAndOrder.html.twig', [
                    'form' => $form->createView(),
                    'entreprises' => $entreprises,
                    'search' => $search,
                    'orders' => $orders,
                    'date1' => $date1,
                    'date2' => $date2,
                ]);
            }

            if ($form->get('search')->getData()) {
                $search = $form->get('search')->getData();
                $entreprises = $entrepriseRepository->findByEntrepriseName($search);

                return $this->render('admin/entrepriseSearchedByName.html.twig', [
                    'form' => $form->createView(),
                    'entreprises' => $entreprises,
                    'search' => $search,
                ]);
            }

            if ($form->get('date1')->getData() && $form->get('date2')->getData()) {
                $date1 = $form->get('date1')->getData();
                $date2 = $form->get('date2')->getData();
                $interval = $date1->diff($date2);
                if ($interval->d == 0) {
                    $date2->modify('+23 hour 59 minutes 59 seconds');
                }
                $allOrders = $orderRepository->findByTwoDate($date1, $date2);
                $orders = [];
                foreach ($allOrders as $order) {
                    if (!empty($order->getEchantillons()->toArray())) {
                        $orders[] = $order;
                    }
                }
                return $this->render('admin/searchOrder.html.twig', [
                    'form' => $form->createView(),
                    'orders' => $orders,
                    'date1' => $date1,
                    'date2' => $date2,
                ]);
            }
        }

        $query = $this->manager->createQuery('SELECT e FROM App\Entity\Entreprise e ORDER BY e.name ASC')->getResult();
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            30
        );

        return $this->render('admin/listing_entreprise.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView()
        ]);
    }
}
