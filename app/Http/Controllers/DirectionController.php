<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\consultante;
use App\Models\Depense;
use App\Models\Entree;
use App\Models\Succursale;
use App\Models\TypePaiement;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DirectionController extends Controller
{
   
    
    public function Dashboard()
{
    setlocale(LC_TIME, 'fr_FR.utf8');
    $donneesSuccursales = $this->allSuccursalle();
    $donneesCandidat = $this->getAllCandidatsData();
    // Passez les données à la vue
    return view('Direction.Views.Dashboard', [
        'donneesSuccursales' => $donneesSuccursales ,
        'donneesCandidat' => $donneesCandidat
    ]);
}


public function getAllCandidatsData()
{
    $candidatsPagines = Candidat::has('entrees')
        ->join('entree', 'candidat.id', '=', 'entree.id_candidat')
        ->join('type_paiement', 'entree.id_type_paiement', '=', 'type_paiement.id')
        ->join('users', 'candidat.id_utilisateur', '=', 'users.id')
        ->join('succursale', 'users.id_succursale', '=', 'succursale.id')
        ->select(
            'candidat.id',
            'candidat.nom',
            'candidat.prenom',
            'type_paiement.label as type_paiement',
            DB::raw('CONCAT(users.name, " ", users.last_name, " / ", succursale.label) as agent_succursale'),
            'entree.montant as montant_dernier_paiement',
            'entree.date as date_dernier_paiement'
        )
        ->orderBy('entree.date', 'desc')
        ->paginate(9, ['*'], 'page_candidat');// Spécifiez ici votre propre route

    return $candidatsPagines;
}


    private function allSuccursalle()
    {
        // Obtenez le mois actuel
        $moisActuel = now()->format('m');
        
        // Obtenez la liste des succursales
        $succursales = Succursale::all();
    
        $donneesSuccursales = [];
    
        // Itérez sur chaque succursale
        foreach ($succursales as $succursale) {
            // Obtenez le total du mois en cours pour la succursale actuelle (entrées)
            $totalEntrant = Entree::whereMonth('date', $moisActuel)
                ->whereHas('utilisateur', function ($query) use ($succursale) {
                    $query->where('id_succursale', $succursale->id);
                })
                ->sum('montant');
    
            // Obtenez le total du mois en cours pour les dépenses de la succursale actuelle
            $totalDepenses = Depense::whereMonth('date', $moisActuel)
                ->whereHas('utilisateur', function ($query) use ($succursale) {
                    $query->where('id_succursale', $succursale->id);
                })
                ->sum('montant');
    
            // Stockez les totaux dans le tableau associatif
            $donneesSuccursales[$succursale->label] = [
                'totalEntrant' => $totalEntrant,
                'totalDepenses' => $totalDepenses,
                // Ajoutez d'autres données si nécessaire
            ];
        }
    
        // Retournez le tableau associatif
        return $donneesSuccursales;
    }

    
    
        
    public function Banque()
{
    setlocale(LC_TIME, 'fr_FR.utf8');
    $donneesCandidat = $this->getAllCandidatsData();
    // Passez les données à la vue
    return view('Direction.Views.Banque', [
        'donneesCandidat' => $donneesCandidat
    ]);
}

public function ChartData()
{
    // Utilisateur connecté
    $utilisateurConnecte = Auth::user();

    // Année actuelle
    $anneeActuelle = Carbon::now()->year;

    // Récupérez les données de la base de données pour l'année actuelle
    $data = Entree::whereYear('date', $anneeActuelle)
        ->join('users', 'entree.id_utilisateur', '=', 'users.id')
        ->join('succursale', 'users.id_succursale', '=', 'succursale.id')
        ->select('entree.*', 'succursale.label as succursale')
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

    // Groupement des données par succursale et par mois
    $groupedData = $data->groupBy(['succursale', function ($entry) {
        return Carbon::parse($entry->date)->format('M');
    }]);

    // Bouclez à travers les données groupées et formatez-les
    foreach ($groupedData as $succursale => $dataByMonth) {
        foreach ($dataByMonth as $month => $entries) {
            // Calculez la somme des montants pour le mois actuel
            $totalMontant = $entries->sum('montant');

            $formattedData[] = [
                'succursale' => $succursale,
                'month' => $month,
                'totalMontant' => $totalMontant,
            ];
        }
    }

    // Retournez les données formatées
    return $formattedData;
}


public function Consultation(){

    $consultantes = consultante::all();

    return view('Direction.Views.Consultation', ['data_consultante' => $consultantes]);
}

  
}
