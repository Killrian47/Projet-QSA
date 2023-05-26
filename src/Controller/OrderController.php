<?php

namespace App\Controller;

use App\Entity\Echantillon;
use App\Entity\Order;
use App\Form\AddEchantillonOneByOneType;
use App\Form\ExcelType;
use App\Repository\ConditionnementRepository;
use App\Repository\EtatPhysiqueRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

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
    public function addEchantillonsOneByOne(Request $request, Order $order, EntityManagerInterface $manager): Response
    {
        if ($this->getUser()->getId() !== $order->getEntreprise()->getId()) {
            $this->addFlash('danger', 'Vous n\'êtes pas a l\'origine de ce bon de commande, vous ne pouvez pas accéder à cette page');
            return $this->redirectToRoute('app_home');
        }

        $echantillon = new Echantillon();
        $form = $this->createForm(AddEchantillonOneByOneType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $echantillon->setEntreprise($this->getUser());
            $echantillon->setNumberOfOrder($order);
            $echantillon->setProductName($form->get('productName')->getData());
            $echantillon->setNumberOfBatch($form->get('numberOfBatch')->getData());
            $echantillon->setSupplier($form->get('supplier')->getData());
            $echantillon->setTemperatureOfProduct($form->get('temperatureOfProduct')->getData());
            $echantillon->setTemperatureOfEnceinte($form->get('temperatureOfEnceinte')->getData());
            $echantillon->setDateOfManufacturing($form->get('dateOfManufacturing')->getData());
            $echantillon->setDlcOrDluo($form->get('DlcOrDluo')->getData());
            $echantillon->setDateOfSampling($form->get('dateOfSampling')->getData());
            $echantillon->setDateAnalyse($form->getData()['dateAnalyse']);
            $echantillon->setAnalyseDlc($form->get('analyseDlc')->getData());
            $echantillon->setValidationDlc($form->get('validationDlc')->getData());
            $echantillon->setConditioning($form->get('conditioning')->getData());
            $echantillon->setEtatPhysique($form->get('etatPhysique')->getData());
            $echantillon->setLieu($form->get('Lieu')->getData());
            $echantillon->setStockage($form->get('stockage')->getData());
            $echantillon->setAnalyse($form->get('analyse')->getData());
            $echantillon->setSamplingBy($form->get('samplingBy')->getData());
            $dateF = $form->get('dateOfManufacturing')->getData();
            $dateDlc = $form->get('DlcOrDluo')->getData();
            $dateAnalyse = $form->get('dateAnalyse')->getData();

            if ($dateDlc < $dateF) {
                $this->addFlash('danger', 'La date de DLC ne peut pas être plus ancienne que la date de fabrication');
                return $this->redirectToRoute('app_add_echantillon_to_order', [
                    'id' => $order->getId()
                ]);
            }

            if ($dateAnalyse < $dateF) {
                $this->addFlash('danger', 'La date d\'analyse ne peut pas être plus ancienne que la date de fabrication');
                return $this->redirectToRoute('app_detail_order', [
                    'id' => $order->getId()
                ]);
            }

            $manager->persist($echantillon);
            $manager->flush();

            $this->addFlash('success', 'L\'échantillon vient d\'être enregistré !');
            return $this->redirectToRoute('app_add_echantillon_to_order', [
                'id' => $order->getId()
            ]);
        }

        return $this->render('echantillon/addOneByOne.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/ajouter-plusieurs-échantillons', name: 'app_add_many_echantillon')]
    public function addEchantillonByExcel(EntityManagerInterface $manager): Response
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

        return $this->redirectToRoute('app_add_echantillon_with_excel', [
            'id' => $order->getId()
        ]);
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    #[Route('/ajouter-plusieurs-échantillons/{id}', name: 'app_add_echantillon_with_excel')]
    public function addEchantillonToOrderByExcel(
        Request $request,
        Order $order,
        EntityManagerInterface $manager,
        EtatPhysiqueRepository $etatPhysiqueRepository,
        ConditionnementRepository $conditionnementRepository,
    ): Response
    {
        $form = $this->createForm(ExcelType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('csv_file')->getData();
            if (!$file) {
                throw new FileException("Le fichier n'a pas été téléchargé");
            }

            // Définir le chemin de stockage du fichier
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = $this->getParameter('kernel.project_dir') . '/public/uploads/' . $fileName;

            // Déplacer le fichier vers le répertoire de stockage
            $file->move($this->getParameter('kernel.project_dir') . '/public/uploads', $fileName);

            // Importer les données depuis le fichier Excel
            $reader = IOFactory::createReaderForFile($filePath);
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            array_shift($rows);

            foreach ($rows as $row) {
                $echantillon = new Echantillon(); // Remplacez VotreEntite par le nom de votre entité
                $echantillon->setEntreprise($this->getUser());
                $echantillon->setNumberOfOrder($order);
                $dateSampling = new \DateTime($row[0]);
                $echantillon->setDateOfSampling($dateSampling);
                $echantillon->setProductName($row[1]);
                $echantillon->setNumberOfBatch($row[2]);
                $etatPhysique = $etatPhysiqueRepository->findOneBy(['name' => $row[3]]);
                $echantillon->setEtatPhysique($etatPhysique);
                $conditionnement = $conditionnementRepository->findOneBy(['name' => $row[4]]);
                $echantillon->setConditioning($conditionnement);
                $echantillon->setTemperatureOfProduct($row[5]);
                $echantillon->setTemperatureOfEnceinte($row[6]);
                $dateAnalyse = new \DateTime($row[7]);
                $echantillon->setDateAnalyse($dateAnalyse);
                $dlcDluo = new \DateTime($row[8]);
                $echantillon->setDlcOrDluo($dlcDluo);
                $dateManufacturing = new \DateTime($row[9]);
                $echantillon->setDateOfManufacturing($dateManufacturing);
                $analyseDLC = ucfirst(strtolower($row[10]));
                if ($analyseDLC == 'Oui') {
                    $echantillon->setAnalyseDlc(true);
                } else {
                    $echantillon->setAnalyseDlc(false);
                }
                $validationDLC = ucfirst(strtolower($row[11]));
                if ($validationDLC == 'Oui') {
                    $echantillon->setValidationDlc(true);
                    $echantillon->setTempOfBreak($row[13]);
                    $dateOfBreak = new \DateTime($row[14]);
                    $echantillon->setDateOfBreak($dateOfBreak);
                } else {
                    $echantillon->setValidationDlc(false);
                }
                $echantillon->setSupplier($row[15]);
                $manager->persist($echantillon);
            }
            $manager->flush();

            $this->addFlash('success', 'Vos échantillons viennent d\'être envoyés, vérifier les s\'il vous plaît !');

            return $this->redirectToRoute('app_detail_order', [
                'id' => $order->getId(),
            ]);
        }
        return $this->render('echantillon/addManyByExcel.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/supprimer-ceux-qui-sont-vides', name: 'app_delete_empty_order')]
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
