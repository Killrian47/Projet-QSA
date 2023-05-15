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
        $sheet->setCellValue('A1', 'Numéro de lot');
        $sheet->setCellValue('B1', 'Nom du produit');
        $sheet->setCellValue('C1', 'Fournisseur');
        $sheet->setCellValue('D1', 'Température du produit');
        $sheet->setCellValue('E1', 'Température de l\'enceinte');
        $sheet->setCellValue('F1', 'Date de fabrication');
        $sheet->setCellValue('G1', 'DLC / DLUO');
        $sheet->setCellValue('H1', 'Date de prélèvement');
        $sheet->setCellValue('I1', 'Analyse à DLC ?');
        $sheet->setCellValue('J1', 'Validation de DLC ?');
        $sheet->setCellValue('K1', 'Conditionnement');
        $sheet->setCellValue('L1', 'État physique');
        $sheet->setCellValue('M1', 'Lieu');
        $sheet->setCellValue('N1', 'Stockage');
        $sheet->setCellValue('O1', 'Analyse');
        $sheet->setCellValue('P1', 'Prélevé par ?');

        $row = 2;
        $entreprise = '';
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item->getNumberOfBatch());
            $sheet->setCellValue('B' . $row, $item->getProductName());
            $sheet->setCellValue('C' . $row, $item->getSupplier());
            $sheet->setCellValue('D' . $row, $item->getTemperatureOfProduct());
            $sheet->setCellValue('E' . $row, $item->getTemperatureOfEnceinte());
            $sheet->setCellValue('F' . $row, $item->getDateOfManufacturing());
            $sheet->setCellValue('G' . $row, $item->getDlcOrDluo());
            $sheet->setCellValue('H' . $row, $item->getDateOfSampling());
            if ($item->isAnalyseDlc() === TRUE) {
                $sheet->setCellValue('I' . $row, 'Oui');
            } else {
                $sheet->setCellValue('I' . $row, 'Non');
            }
            if ($item->isValidationDlc() === TRUE) {
                $sheet->setCellValue('J' . $row, 'Oui');
            } else {
                $sheet->setCellValue('J' . $row, 'Non');
            }
            $sheet->setCellValue('K' . $row, $item->getConditioning()->getName());
            $sheet->setCellValue('L' . $row, $item->getEtatPhysique()->getName());
            $sheet->setCellValue('M' . $row, $item->getLieu()->getName());
            $sheet->setCellValue('N' . $row, $item->getStockage()->getName());
            $sheet->setCellValue('O' . $row, $item->getAnalyse()->getName());
            $sheet->setCellValue('P' . $row, $item->getSamplingBy()->getName());
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
