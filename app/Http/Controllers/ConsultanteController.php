<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidat;
use App\Models\consultante;
use App\Models\InfoConsultation;
use Illuminate\Support\Facades\Auth;

class ConsultanteController extends Controller
{
    public function Dashboard()
    {
       

        return view('Consultante.Views.Dashboard');
    }

    public function getListCandidatByConsultation($id)
    {
        // Récupérer la consultation par son ID
        $info_consultation = InfoConsultation::find($id);

        // Récupérer la liste des consultations liées (exemple : consultations du même patient)
        $consultationsList = Candidat::where('id_info_consultation', $info_consultation->id)
            ->get();

        return view('Consultante.listcandidats', compact('info_consultation', 'consultationsList'));
    }

    public function getCandidatByConsultation($id, $id_candidat)
    {
        // Récupérer la consultation par son ID
        $info_consultation = InfoConsultation::find($id);
        $consultation = Candidat::find($id_candidat);

        // Récupérer la liste des consultations liées (exemple : consultations du même patient)
        
            return view('Consultante.candidat', compact('info_consultation', 'consultation'));
       
    }

    public function getCandidatFiche($id_candidat)
    {

        $consultation = Candidat::find($id_candidat);

        // Récupérer la liste des consultations liées (exemple : consultations du même patient)
        
            return view('Consultante.candidat', compact('consultation'));
       
    }


    public function DossierClient()
{  
    $userId = Auth::id();
    $consultantId = consultante::where('id_utilisateur', $userId)->value('id');


    // Récupérer la liste des candidats avec des procédures associées pour le consultant connecté
    $candidats = Candidat::whereHas('proceduresDemandees', function ($query) use ($consultantId) {
        $query->where('consultante_id', $consultantId);
    })->get();

    return view('Consultante.Views.DossierClient', compact('candidats'));
}





    
}
