<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class ModelDownloaderController extends AbstractController
{
    #[Route('download/fichier-xlsx-model', name: 'app_download_xlsx_model')]
    public function downloadXlsx(): BinaryFileResponse
    {
        // Chemin vers le fichier XLSX à télécharger
        $path = $this->getParameter('kernel.project_dir') . '/public/file_to_download/QSA_model.xlsx';

        // Créer une réponse de fichier binaire
        $response = new BinaryFileResponse($path);

        // Ajouter un en-tête de réponse pour définir le type MIME du fichier
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');

        // Forcer le téléchargement plutôt que l'affichage dans le navigateur
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'QSA_model.xlsx'
        );

        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }

    #[Route('download/fichier-csv-model', name: 'app_download_csv_model')]
    public function downloadCsv(): BinaryFileResponse
    {
        // Chemin vers le fichier CSV à télécharger
        $path = $this->getParameter('kernel.project_dir') . '/public/file_to_download/QSA_model.xlsx';

        // Créer une réponse de fichier binaire
        $response = new BinaryFileResponse($path);

        // Ajouter un en-tête de réponse pour définir le type MIME du fichier
        $response->headers->set('Content-Type', 'text/csv');

        // Forcer le téléchargement plutôt que l'affichage dans le navigateur
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'QSA_model.csv'
        );

        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }
}

