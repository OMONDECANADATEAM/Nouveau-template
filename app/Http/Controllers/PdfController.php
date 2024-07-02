<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use Illuminate\Http\Request;
use PDF;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\StreamReader;
use Illuminate\Support\Facades\Log;

class PdfController extends Controller
{
    public function printDevis($id)
    {
        // Récupérer l'objet candidat par son identifiant
        $candidat = Candidat::findOrFail($id);

        // Vérifier que les fichiers Blade existent
        $views = [
            'Documents.Devis.1',
            'Documents.Devis.2',
            'Documents.Devis.3',
            'Documents.Devis.5',
            'Documents.Devis.4'
        ];

        foreach ($views as $view) {
            if (!view()->exists($view)) {
                Log::error("La vue $view n'existe pas!");
                abort(404, "La vue $view n'existe pas!");
            }
        }

        // Générer les pages
        try {
            $firstPagePdf = PDF::loadView('Documents.Devis.1', compact('candidat'))->output();
            $secondPagePdf = PDF::loadView('Documents.Devis.2')->output();
            $thirdPagePdf = PDF::loadView('Documents.Devis.3')->output();
            $fourthPagePdf = PDF::loadView('Documents.Devis.4')->output(); // Nouvelle vue pour la 4e page
            $lastPagePdf = PDF::loadView('Documents.Devis.5', compact('candidat'))->output();
        } catch (\Exception $e) {
            Log::error("Erreur lors de la génération des pages PDF: " . $e->getMessage());
            abort(500, "Erreur lors de la génération des pages PDF");
        }

        // Chemin vers le fichier PDF existant
        $originalPdfPath = storage_path('app/public/Devis.pdf');
        if (!file_exists($originalPdfPath)) {
            Log::error("Le fichier PDF original n'existe pas à l'emplacement: $originalPdfPath");
            abort(404, "Le fichier PDF original n'existe pas");
        }

        // Initialiser FPDI
        $pdf = new FPDI();

        // Ajouter les pages générées et du document original
        try {
            // Ajouter la première page générée
            $pdf->AddPage();
            $tplIdx = $pdf->setSourceFile(StreamReader::createByString($firstPagePdf));
            if (!$tplIdx) {
                throw new \Exception("Échec de l'importation de la première page PDF générée.");
            }
            $pdf->useTemplate($pdf->importPage(1));

            // Ajouter la deuxième page générée
            $pdf->AddPage();
            $tplIdx = $pdf->setSourceFile(StreamReader::createByString($secondPagePdf));
            if (!$tplIdx) {
                throw new \Exception("Échec de l'importation de la deuxième page PDF générée.");
            }
            $pdf->useTemplate($pdf->importPage(1));

            // Ajouter la troisième page générée
            $pdf->AddPage();
            $tplIdx = $pdf->setSourceFile(StreamReader::createByString($thirdPagePdf));
            if (!$tplIdx) {
                throw new \Exception("Échec de l'importation de la troisième page PDF générée.");
            }
            $pdf->useTemplate($pdf->importPage(1));

            // Ajouter la quatrième page générée
            $pdf->AddPage();
            $tplIdx = $pdf->setSourceFile(StreamReader::createByString($fourthPagePdf));
            if (!$tplIdx) {
                throw new \Exception("Échec de l'importation de la quatrième page PDF générée.");
            }
            $pdf->useTemplate($pdf->importPage(1));

            // Ajouter les pages restantes du document original et la dernière page générée
            $originalPdf = new FPDI();
            $pageCount = $originalPdf->setSourceFile($originalPdfPath);

            for ($pageNo = 5; $pageNo <= $pageCount; $pageNo++) {
                if ($pageNo == 5) {
                    // Ajouter la dernière page générée
                    $pdf->AddPage();
                    $tplIdx = $pdf->setSourceFile(StreamReader::createByString($lastPagePdf));
                    if (!$tplIdx) {
                        throw new \Exception("Échec de l'importation de la dernière page PDF générée.");
                    }
                    $pdf->useTemplate($pdf->importPage(1));
                } else {
                    // Ajouter les pages restantes du document original
                    $pdf->AddPage();
                    $tplIdx = $originalPdf->importPage($pageNo);
                    if (!$tplIdx) {
                        throw new \Exception("Échec de l'importation de la page $pageNo du PDF original.");
                    }
                    $pdf->useTemplate($tplIdx);
                }
            }
        } catch (\Exception $e) {
            Log::error("Erreur lors de la manipulation du PDF: " . $e->getMessage());
            abort(500, "Erreur lors de la manipulation du PDF");
        }

        // Générer le PDF final
        return response($pdf->Output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="modified_document.pdf"');
    }
}












