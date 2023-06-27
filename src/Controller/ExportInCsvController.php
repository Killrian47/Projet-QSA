<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\EchantillonRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ExportInCsvController extends AbstractController
{
    #[Route('/exporter-bon-de-commande-en-CSV/{id}', name: 'app_export_in_csv')]
    #[IsGranted('ROLE_ADMIN')]
    public function exportOrderInCSV(Order $order, EchantillonRepository $echantillonRepository, EntityManagerInterface $manager
    ): Response
    {
        $order->setIsExported(true);
        $manager->persist($order);
        $manager->flush();

        $data = $echantillonRepository->findBy(['NumberOfOrder' => $order->getId()]);

        $calc = new Spreadsheet();
        $sheet = $calc->getActiveSheet();

        $sheet->setTitle('Échantillons');
        $sheet->setCellValue('A1', 'Date de prélèvement');
        $sheet->setCellValue('B1', 'Nom du produit');
        $sheet->setCellValue('C1', 'Numéro de lot');
        $sheet->setCellValue('D1', 'État physique');
        $sheet->setCellValue('E1', 'Conditionnement');
        $sheet->setCellValue('F1', 'Température du produit');
        $sheet->setCellValue('G1', 'Température de l\'enceinte');
        $sheet->setCellValue('H1', 'Date de d\'analyse');
        $sheet->setCellValue('I1', 'DLC / DLUO');
        $sheet->setCellValue('J1', 'Date de fabrication');
        $sheet->setCellValue('K1', 'Analyse à DLC ?');
        $sheet->setCellValue('L1', 'Validation de DLC ?');
        $sheet->setCellValue('N1', 'Température de rupture');
        $sheet->setCellValue('O1', 'Date de rupture');
        $sheet->setCellValue('P1', 'Fournisseur');

        $row = 2;
        $entreprise = '';
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item->getDateOfSampling());
            $sheet->setCellValue('B' . $row, $item->getProductName());
            $sheet->setCellValue('C' . $row, $item->getNumberOfBatch());
            $sheet->setCellValue('D' . $row, $item->getEtatPhysique()->getName());
            $sheet->setCellValue('E' . $row, $item->getConditioning()->getName());
            $sheet->setCellValue('F' . $row, $item->getTemperatureOfProduct());
            $sheet->setCellValue('G' . $row, $item->getTemperatureOfEnceinte());
            $sheet->setCellValue('H' . $row, $item->getDateOfSampling());
            $sheet->setCellValue('I' . $row, $item->getDlcOrDluo());
            $sheet->setCellValue('J' . $row, $item->getDateOfManufacturing());
            if ($item->isAnalyseDlc() === TRUE) {
                $sheet->setCellValue('K' . $row, 'Oui');
            } else {
                $sheet->setCellValue('K' . $row, 'Non');
            }
            if ($item->isValidationDlc() === TRUE) {
                $sheet->setCellValue('L' . $row, 'Oui');
            } else {
                $sheet->setCellValue('L' . $row, 'Non');
            }
            $sheet->setCellValue('N' . $row, $item->getTempOfBreak());
            $sheet->setCellValue('O' . $row, $item->getDateOfBreak());
            $sheet->setCellValue('P' . $row, $item->getSupplier());
            $entreprise = $item->getEntreprise()->getName();
            $row++;
        }

        $date = new DateTime();
        $todayDate = $date->format('d-m-Y');
        // Générer le fichier Excel
        $writer = new CSV($calc);
        $fileName = $todayDate . '_' . $entreprise . '.csv';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($tempFile);

        $this->addFlash('success', 'Les données ont bien été exportées');

        // Retourner le fichier Excel en réponse HTTP
        return $this->file($tempFile, $fileName);
    }
}
