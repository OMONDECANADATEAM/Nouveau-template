<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Candidat;

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
    
 

    
    
}
