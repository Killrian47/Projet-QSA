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
            $this->addFlash('info', 'Vous devez être connecté pour avoir accès à cette page');
            return $this->redirectToRoute('app_login');
        }

        if ($this->getUser()->isFirstConnection() === true) {
            $this->addFlash('warning', 'Vous devez changer votre mot de passe avant de pouvoir naviguer sur le site ');
            return $this->redirectToRoute('app_change_password');
        }

        $user = $this->getUser();
        $orders = [];
        $ordersByUser = $orderRepository->findBy(['entreprise' => $user], ['createdAt' => 'DESC']);

        $viewForAdmin = $orderRepository->findAll();

        foreach ($ordersByUser as $order) {
            if (!empty($order->getEchantillons()->toArray())) {
                $orders[] = $order;
            }
        }

        $adminView = $orderRepository->findBy([], ['createdAt' => 'ASC']);

        return $this->render('home/index.html.twig', [
            'orders' => $orders,
            'ordersAdmin' => $adminView,
        ]);
    }
}
