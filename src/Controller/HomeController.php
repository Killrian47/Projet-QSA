<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(OrderRepository $orderRepository): Response
    {
        if ($this->getUser() === null) {
            return $this->redirectToRoute('app_login');
        }

        $user = $this->getUser();
        $orders = [];
        $ordersByUser = $orderRepository->findBy(['entreprise' => $user], ['createdAt' => 'DESC']);

        foreach ($ordersByUser as $order) {
            if (!empty($order->getEchantillons()->toArray())) {
                $orders[] = $order;
            }
        }


        return $this->render('home/index.html.twig', [
            'orders' => $orders
        ]);
    }
}
