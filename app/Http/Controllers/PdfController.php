<?php
namespace App\Http\Controllers;

use App\Models\Candidat;
use Illuminate\Http\Request;
use PDF;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\StreamReader;

class PdfController extends Controller
{
    public function printDevis($id)
    {
        // Récupérer l'objet candidat par son identifiant
        $candidat = Candidat::findOrFail($id);

        // Générer la première page
        $firstPagePdf = PDF::loadView('Documents.PremierePageDevis', compact('candidat'))->output();

        // Générer la dernière page
        $lastPagePdf = PDF::loadView('Documents.DernierePageDevis', compact('candidat'))->output();

        // Chemin vers le fichier PDF existant
        $originalPdfPath = storage_path('app/public/Devis.pdf');

        // Initialiser FPDI
        $pdf = new FPDI();

        // Ajouter la première page générée
        $pageCount = $pdf->setSourceFile(StreamReader::createByString($firstPagePdf));
        $pdf->AddPage();
        $tplIdx = $pdf->importPage(1);
        $pdf->useTemplate($tplIdx);

        // Ajouter les pages du document original en sautant la première et la dernière page
        $pageCount = $pdf->setSourceFile($originalPdfPath);
        for ($pageNo = 2; $pageNo < $pageCount; $pageNo++) {
            $pdf->AddPage();
            $tplIdx = $pdf->importPage($pageNo);
            $pdf->useTemplate($tplIdx);
        }

        // Ajouter la dernière page générée
        $pageCount = $pdf->setSourceFile(StreamReader::createByString($lastPagePdf));
        $pdf->AddPage();
        $tplIdx = $pdf->importPage(1);
        $pdf->useTemplate($tplIdx);

        // Générer le PDF final
        return response($pdf->Output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="modified_document.pdf"');
    }
}




