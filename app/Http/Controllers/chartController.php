<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
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
    
}


