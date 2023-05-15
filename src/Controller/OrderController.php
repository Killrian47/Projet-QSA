<?php

namespace App\Controller;

use App\Entity\Echantillon;
use App\Entity\Order;
use App\Form\AddEchantillonOneByOneType;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use function Sodium\add;

class OrderController extends AbstractController
{
    #[Route('/ajouter-des-échantillons-un-par-un', name: 'app_order')]
    public function index(EntityManagerInterface $manager): Response
    {
        if ($this->getUser() === null) {
            $this->addFlash('info', 'Vous devez être connecté pour avoir accès à cette page');
            return $this->redirectToRoute('app_login');
        }

        if ($this->getUser()->isFirstConnection() === true) {
            $this->addFlash('warning', 'Vous devez changer votre mot de passe avant de pouvoir naviguer sur le site');
            return $this->redirectToRoute('app_change_password');
        }

        date_default_timezone_set('Europe/Paris');
        $order = new Order();
        $order->setEntreprise($this->getUser());
        $order->setCreatedAt(new \DateTimeImmutable('now'));
        $order->setIsExported(false);

        $manager->persist($order);
        $manager->flush();

        return $this->redirectToRoute('app_add_echantillon_to_order', [
            'id' => $order->getId()
        ]);
    }

    #[Route('/ajouter-des-échantillons-un-par-un/{id}', name: 'app_add_echantillon_to_order')]
    public function addEchantillonsOneByOne(Request $request, Order $order, EntityManagerInterface $manager)
    {
        $echantillon = new Echantillon();
        $form = $this->createForm(AddEchantillonOneByOneType::class);
        $form->handleRequest($request);

        return $this->render('echantillon/addOneByOne.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/bon-de-commande/supprimer-ceux-qui-sont-vides', name: 'app_delete_empty_order')]
    #[IsGranted('ROLE_ADMIN')]
    public function deleteEmptyOrder(OrderRepository $orderRepository, EntityManagerInterface $manager): Response
    {
        if ($this->getUser() === null) {
            $this->addFlash('info', 'Vous devez être connecté pour avoir accès à cette page');
            return $this->redirectToRoute('app_login');
        }

        if ($this->getUser()->isFirstConnection() === true) {
            $this->addFlash('warning', 'Vous devez changer votre mot de passe avant de pouvoir naviguer sur le site ');
            return $this->redirectToRoute('app_change_password');
        }

        $orders = $orderRepository->findAll();
        foreach ($orders as $order) {
            if (empty($order->getEchantillons()->toArray())) {
                $manager->remove($order);
            }
        }
        $manager->flush();

        $this->addFlash('info', 'Tous les bons de commandes sans échantillons viennent d\'être supprimés !');
        return $this->redirectToRoute('app_home');
    }
}
