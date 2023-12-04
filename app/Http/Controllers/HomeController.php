<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidat;
use App\Models\Entree;
use App\Models\consultante;
use App\Models\InfoConsultation;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }
    public function DossierContacts()
    {
        return view('DossierContacts');
    }
    public function DossierClients()
    {
        return view('DossierClients');
    }
    public function Banque()
    {
        return view('Banque');
    }
   
    public function Consultation()
    {
        return view('Consultation');
    }
    public function OmondeTeam()
    {
        return view('OmondeTeam');
    }

    public function adminDashboard()
    {
        return view('adminDashboard');
    }

    public function connexion()
    {
        return view('connexion');
    }

    public function allCandidat()
    {
        // Obtenir l'utilisateur connecté
        $idSuccursaleUtilisateur = auth()->user()->id_succursale;
    
            // Obtenir les données des candidats liés à la succursale de l'utilisateur
            $candidats = Candidat::whereHas('utilisateur', function ($query) use ($idSuccursaleUtilisateur) {
                $query->where('id_succursale', $idSuccursaleUtilisateur);
            })
            ->orderBy('date_enregistrement', 'desc')
            ->take(10)
            ->get();
    
            // Passer les données à la vue principale
            return view('DossierContacts', ['data_candidat' => $candidats]);
     
    }
    

 
    
    public function allClient() {
        // Récupérer l'id de la succursale de l'utilisateur en cours
        $idSuccursaleUtilisateur = auth()->user()->id_succursale;
    
        // Récupérer la liste des entrees de type 2 liées à la succursale de l'utilisateur
        $entreesType2 = Entree::where('id_type_paiement', 2)
            ->whereHas('utilisateur', function ($query) use ($idSuccursaleUtilisateur) {
                $query->where('id_succursale', $idSuccursaleUtilisateur);
            })
            ->get();
    
        // Récupérer les candidats liés à ces entrées
        $candidats = Candidat::whereIn('id', $entreesType2->pluck('id_candidat'))->get();
    
        // Créer un tableau associatif pour stocker la date de paiement correspondante à chaque candidat
        $datesPaiement = [];
        foreach ($entreesType2 as $entree) {
            $datesPaiement[$entree->id_candidat] = $entree->date;
        }
    
        // Trier les candidats par date de paiement (de la plus récente à la plus ancienne)
        $candidats = $candidats->sortByDesc(function ($candidat) use ($datesPaiement) {
            return $datesPaiement[$candidat->id];
        });
    
        return view('DossierClients', ['data_client' => $candidats, 'dates_paiement' => $datesPaiement]);
    }
    


 
    public function listeConsultantes()
    {
        
        $consultantes = Consultante::all();

        return view('Consultation', ['data_consultante' => $consultantes]);
    }


}
