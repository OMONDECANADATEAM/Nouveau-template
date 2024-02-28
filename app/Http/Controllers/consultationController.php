<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\consultante;
use App\Models\InfoConsultation;

use Illuminate\Http\Request;

class consultationController extends Controller
{
    
    public function toggleConsultation($candidatId)
    {
        $candidat = Candidat::find($candidatId);
    
        if (!$candidat) {
            return response()->json(['message' => 'Candidat non trouvé'], 404);
        }
    
        $status = request('status');
    
        $candidat->update(['consultation_effectuee' => ($status === 'yes')]);
    
        $message = 'Statut de consultation mis à jour avec succès.';
    
        return redirect()->back()->with('success', $message);
    }
    
    public function listeConsultantes()
    {
        
        $consultantes = Consultante::all();

        return view('Consultation.Consultation', ['data_consultante' => $consultantes]);
    }
    
    public function getConsultationWaitingList($consultationId)
    {
        $consultationInfo = InfoConsultation::with(['candidats' => function ($query) {
            // Ajoutez une condition pour filtrer les candidats avec un statut différent de 1
            $query->where('consultation_effectuee', '!==', 1);
        }])->find($consultationId);
        
    
        return view('Consultation.waitingList', ['data_candidat' => $consultationInfo->candidats]);
    }

    public function creerConsultation(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'label' => 'required',
            'lien_zoom' => 'required',
            'lien_zoom_demarrer' => 'required',
            'date_heure' => 'required|date',
            'nombre_candidats' => 'required|integer',
            'id_consultante' => 'required|integer',
        ]);
        $consultation = InfoConsultation::create([
            'label' => $request->input('label'),
            'lien_zoom' => $request->input('lien_zoom'),
            'lien_zoom_demarrer' => $request->input('lien_zoom_demarrer'),
            'date_heure' => $request->input('date_heure'),
            'nombre_candidats' => $request->input('nombre_candidats'),
            'id_consultante' => $request->input('id_consultante')
        ]);

        // Rediriger avec un message de succès
        return redirect()->back();
    }

}
