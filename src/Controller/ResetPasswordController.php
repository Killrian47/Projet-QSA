<?php

namespace App\Controller;

use App\Entity\ResetPassword;
use App\Repository\EntrepriseRepository;
use App\Repository\ResetPasswordRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ResetPasswordController extends AbstractController
{
    #[Route('/réinitialiser-son-mot-de-passe', name: 'app_reset_password_request')]
    public function resetPasswordRequest(
        Request                 $request,
        EntrepriseRepository    $entrepriseRepository,
        ResetPasswordRepository $resetPasswordRepository,
        EntityManagerInterface  $manager,
        MailerInterface         $mailer,
    ): Response
    {
        $emailForm = $this->createFormBuilder()
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre adresse mail !'
                    ])
                ],
                'label' => 'Votre adresse mail :',
                'attr' => [
                    'class' => 'qsa-input-form rounded'
                ],
                'required' => false
            ])
            ->getForm();

        $emailForm->handleRequest($request);

        if ($emailForm->isSubmitted() && $emailForm->isValid()) {
            $email = $emailForm->get('email')->getData();
            $user = $entrepriseRepository->findOneBy(['email' => $email]);
            if ($user) {
                $oldResetPassword = $resetPasswordRepository->findOneBy(['user' => $user]);
                if ($oldResetPassword) {
                    $manager->remove($oldResetPassword);
                    $manager->flush();
                }

                $resetPassword = new ResetPassword();
                $resetPassword->setUser($user);
                $resetPassword->setExpiredAt(new \DateTimeImmutable('+2 hours'));
                $token = substr(str_replace(['+', '/', '='], '', base64_encode(random_bytes(40))), 0, 20);
                $resetPassword->setToken($token);
                $manager->persist($resetPassword);
                $manager->flush();

                $mail = new TemplatedEmail();
                $mail->to($email)
                    ->subject('Demande de réinitialisation de mot de passe')
                    ->from('no-reply@qsa.com')
                    ->htmlTemplate('_email_templates/reset_password_request.html.twig')
                    ->context([
                        'token' => $token
                    ]);
                $mailer->send($mail);
            }
            $this->addFlash('success', 'Un mail vous a été envoyé pour réinitialiser votre mot de passe !');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('reset_password/reset_password_request.html.twig', [
            'form' => $emailForm->createView(),
        ]);
    }

    #[Route('réinitialiser-votre-mot-de-passe/{token}', name: 'app_reset_password')]
    public function resetPassword(
        string                  $token,
        ResetPasswordRepository $resetPasswordRepository,
        EntityManagerInterface  $manager,
        Request $request,
        UserPasswordHasherInterface $hasher,
    ): Response
    {
        $resetPassword = $resetPasswordRepository->findOneBy(['token' => $token]);

        if (!$resetPassword || $resetPassword->getExpiredAt() < new \DateTime('now')) {
            if ($resetPassword) {
                $manager->remove($resetPassword);
                $manager->flush();
            }
            $this->addFlash('warning', 'Votre demande a expiré, veuillez en refaire une !');
            return $this->redirectToRoute('app_login');
        }

        $passwordForm = $this->createFormBuilder()
            ->add('password', PasswordType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez saisir un mot de passe !'
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit faire au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'label' => 'Votre nouveau mot de passe :',
                'required' => false,
                'attr' => [
                    'class' => 'qsa-input-form rounded'
                ]
            ])
        ->getForm();

        $passwordForm->handleRequest($request);
        if ($passwordForm->isSubmitted() && $passwordForm->isValid()) {
            $new_password = $passwordForm->get('password')->getData();
            $user = $resetPassword->getUser();
            $user->setPassword($hasher->hashPassword($user, $new_password));
            $manager->persist($user);
            $manager->remove($resetPassword);
            $manager->flush();

            $this->addFlash('success', 'Votre de mot de passe a été modifié !');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('reset_password/reset_password.html.twig', [
            'form' => $passwordForm->createView(),
        ]);
    }
}
