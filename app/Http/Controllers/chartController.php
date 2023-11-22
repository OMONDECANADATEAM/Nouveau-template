<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Entree;
use Carbon\Carbon;

class chartController extends Controller
{
   

    public function getChartData()
    {
        // Obtenez la date de début et de fin de la semaine actuelle
        $debutSemaine = Carbon::now()->startOfWeek();
        $finSemaine = Carbon::now()->endOfWeek();
    
        // Récupérez les données de la base de données pour la semaine actuelle
        $data = Candidat::whereBetween('date_enregistrement', [$debutSemaine, $finSemaine])
                        ->selectRaw('DATE_FORMAT(date_enregistrement, "%W") as jour_semaine, COUNT(*) as nombre_visites')
                        ->groupBy('jour_semaine')
                        ->get();
    
        // Retournez les données au format JSON
        return response()->json($data);
    }


public function getChartMonthData()
{
    // Récupérez les données de la base de données pour l'année actuelle
    $currentYear = Carbon::now()->year;
    $data = Entree::whereYear('date', $currentYear)
        ->where('id_type_paiement', 2) // Assurez-vous que le type de paiement correspond à celui que vous utilisez
        ->get();

    // Formatez les données pour le graphique
    $formattedData = $this->formatChartData($data);

    // Retournez les données au format JSON
    return response()->json($formattedData);
}

private function formatChartData($data)
{
    // Initialisez un tableau pour stocker les données formatées
    $formattedData = [];

    // Groupement des données par mois
    $groupedData = $data->groupBy(function ($entry) {
        return Carbon::parse($entry->date)->format('M');
    });

    // Bouclez à travers les données groupées et formatez-les
    foreach ($groupedData as $month => $entries) {
        $formattedData[] = [
            'month' => $month,
            'count' => count($entries),
        ];
    }

    // Retournez les données formatées
    return $formattedData;
}


    
}


