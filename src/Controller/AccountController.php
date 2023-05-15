<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/mon-compte', name: 'app_account')]
    public function index(): Response
    {
        if ($this->getUser() === null) {
            $this->addFlash('info', 'Vous devez être connecté pour avoir accès à cette page');
            return $this->redirectToRoute('app_login');
        }

        if ($this->getUser()->isFirstConnection() === true) {
            $this->addFlash('warning', 'Vous devez changer votre mot de passe avant de pouvoir naviguer sur le site ');
            return $this->redirectToRoute('app_change_password');
        }

        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }

    #[Route('/mon-compte/changer-mon-mot-de-passe', name: 'app_change_password')]
    public function changePassword(Request $request, UserPasswordHasherInterface $hasher)
    {
        if ($this->getUser() === null) {
            $this->addFlash('info', 'Vous devez être connecté pour avoir accès à cette page');
            return $this->redirectToRoute('app_login');
        }

        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $old_password = $form->get('old_password')->getData();
            if ($hasher->isPasswordValid($user, $old_password)) {
                $new_password = $form->get('new_password')->getData();
                $password = $hasher->hashPassword($user, $new_password);
                $user->setPassword($password);
                $user->setFirstConnection(false);

                $this->entityManager->flush();
                $this->addFlash('success', 'Votre mot de passe vient d\'être modifié avec succès !');
                return $this->redirectToRoute('app_home');
            } else {
                $this->addFlash('danger', 'Votre mot de passe actuel n\'est pas le bon, veuillez réessayer avec votre bon mot de passe ');
            }
        }

        return $this->render('account/change_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
