<?php

namespace App\Controller;

use App\Entity\Pdf;
use App\Form\PDFType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class PDFController extends AbstractController
{
    #[Route('/ajouter-un-pdf', name: 'app_add_pdf')]
    public function index(Request $request, SluggerInterface $slugger, EntityManagerInterface $manager, MailerInterface $mailer): Response
    {
        $form = $this->createForm(PDFType::class);
        $form->handleRequest($request);

        date_default_timezone_set('Europe/Paris');
        $date1 = new \DateTimeImmutable();

        if ($form->isSubmitted() && $form->isValid()) {
            $pdf = new Pdf();
            $fileName = $form->get('file')->getData();

            if ($fileName) {

                $originaleFileName = pathinfo($fileName->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFileName = $slugger->slug($originaleFileName);
                $newFileName = $safeFileName . '_' . uniqid() . '.' . $fileName->guessExtension();
                $pdf->setSlug($newFileName);

                try {
                    $fileName->move(
                        $this->getParameter('pdf_dir'),
                        $newFileName
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $pdf->setFile($newFileName);


            }
            $pdf->setEntreprise($form->get('entreprise')->getData());
            $pdf->setCreatedAt($date1);
            $pdf->setIsChecked(false);

            $mail = (new Email())
                ->from($this->getUser()->getEmail())
                ->to($form->get('entreprise')->getData()->getEmail())
                ->subject('Un nouveau fichier est disponible dans votre espace client')
                ->html("<h1>Nouveau PDF d'audit disponible sur votre compte </h1>");

            $mailer->send($mail);

            $manager->persist($pdf);
            $manager->flush();

            $this->addFlash('success', 'Le pdf vient d\'être envoyé à l\'entreprise');

            return $this->redirectToRoute('app_home');
        }
        return $this->render('pdf/add_pdf.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/pdf/{slug}', name: 'app_pdf')]
    public function afficherPdf(string $slug, PDF $PDF, EntityManagerInterface $manager): Response
    {
        $pathFile = $this->getParameter('pdf_dir').'/'. $PDF->getFile();

        // Vérifie si le fichier existe
        if (!file_exists($pathFile)) {
            throw $this->createNotFoundException('Le fichier PDF demandé n\'existe pas.');
        }

        // Créer la réponse du fichier
        $response = new BinaryFileResponse($pathFile);
        $response->headers->set('Content-Type', 'application/pdf');

        // Ajouter un header pour forcer le téléchargement
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $slug
        );
        $response->headers->set('Content-Disposition', $disposition);

        $PDF->setIsChecked(true);
        $manager->persist($PDF);
        $manager->flush();

        return $response;
    }
}
