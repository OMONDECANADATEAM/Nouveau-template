<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Candidat;
use Illuminate\Support\Facades\Auth;
use App\Models\Entree;

class CommercialController extends Controller
{
  

    public function Dashboard()
    {
        $appels = $this->appelCount();
    $visite = $this->visiteCount();
    $consultations = $this->consultationPayeeCount();

    // Fusionner les trois tableaux en un seul
    $data = array_merge($appels, $visite, $consultations);

    return view('Commercial.Views.Dashboard', $data);
    }
    private function appelCount()
    {
        Carbon::setLocale('fr');
        $jourActuel = Carbon::now()->translatedFormat('d F Y');
        $moisActuel = Carbon::now()->monthName;
    
        // Récupère l'utilisateur connecté
        $utilisateurConnecte = auth()->user();
    
        // Calcule le nombre de candidats de l'utilisateur dans le jour actuel
        $totalAppelDeCeJour = Candidat::whereDay('date_enregistrement', Carbon::now()->day)
            ->whereMonth('date_enregistrement', Carbon::now()->month)
            ->whereYear('date_enregistrement', Carbon::now()->year)
            ->whereHas('utilisateur', function ($query) use ($utilisateurConnecte) {
                $query->where('id', $utilisateurConnecte->id);
            })
            ->count();
    
        return compact('totalAppelDeCeJour', 'jourActuel', 'moisActuel');
    }
    
    private function visiteCount()
{
    // Récupère l'utilisateur connecté
    $utilisateurConnecte = auth()->user();

    // Calcule le nombre de candidats de l'utilisateur avec une date de rendez-vous non vide pour le mois et l'année actuels
    $totalVisiteMois = Candidat::where('id_utilisateur', $utilisateurConnecte->id)
        ->whereNotNull('date_rdv')
        ->whereMonth('date_rdv', Carbon::now()->month)
        ->whereYear('date_rdv', Carbon::now()->year)
        ->count();

    return compact('totalVisiteMois');
}


    
    
    private function consultationPayeeCount()
    {
        // Récupère l'utilisateur connecté
        $utilisateurConnecte = auth()->user();
    
        // Obtenez le mois et l'année actuels
        $moisActuel = Carbon::now()->month;
        $anneeActuelle = Carbon::now()->year;
    
        // Calcule le nombre de consultations payées de l'utilisateur pour le mois et l'année actuels
        $totalConsultationsDeCeMois = \App\Models\Candidat::where('consultation_payee', true)
            ->whereMonth('date_enregistrement', $moisActuel)
            ->whereYear('date_enregistrement', $anneeActuelle)
            ->where('id_utilisateur', $utilisateurConnecte->id)
            ->count();
    
        return compact('totalConsultationsDeCeMois');
    }


    public function appelChartData()
    {
        // Obtenez l'utilisateur connecté
        $utilisateurConnecte = Auth::user();
    
        // Obtenez la date de début et de fin de la semaine actuelle
        $debutSemaine = Carbon::now()->locale('fr')->startOfWeek();
        $finSemaine = Carbon::now()->locale('fr')->endOfWeek();
    
        // Récupérez les données de la base de données pour la semaine actuelle
        $data = Candidat::whereBetween('date_enregistrement', [$debutSemaine, $finSemaine])
            ->whereHas('utilisateur', function ($query) use ($utilisateurConnecte) {
                // Filtrer par l'id de succursale de l'utilisateur connecté
                $query->where('id_succursale', $utilisateurConnecte->id_succursale);
            })
            ->selectRaw('DATE_FORMAT(date_enregistrement, "%W") as jour_semaine, COUNT(*) as nombre_visites')
            ->groupBy('jour_semaine')
            ->get();
    
        // Convertir les noms des jours en français
        $jours = ['Monday' => 'Lundi', 'Tuesday' => 'Mardi', 'Wednesday' => 'Mercredi', 'Thursday' => 'Jeudi', 'Friday' => 'Vendredi', 'Saturday' => 'Samedi', 'Sunday' => 'Dimanche'];
        $data->transform(function ($item, $key) use ($jours) {
            $item->jour_semaine = $jours[$item->jour_semaine];
            return $item;
        });
    
        // Retournez les données au format JSON
        return response()->json($data);
    }


    public function consultationChartData()
    {
        // Obtenez l'utilisateur connecté
        $utilisateurConnecte = Auth::user();
    
        // Obtenez l'année actuelle
        $currentYear = Carbon::now()->year;
    
        // Récupérez les données de la base de données pour l'année actuelle
        $data = Entree::whereYear('date', $currentYear)
            ->where('id_type_paiement', 2) // Assurez-vous que le type de paiement correspond à celui que vous utilisez
            ->whereHas('utilisateur', function ($query) use ($utilisateurConnecte) {
                // Filtrer par l'id de succursale de l'utilisateur connecté
                $query->where('id_succursale', $utilisateurConnecte->id_succursale);
            })
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
