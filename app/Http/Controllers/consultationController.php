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
       // Récupérer la consultation par son ID
       $info_consultation = InfoConsultation::find($consultationId);

   
        
    
        return view('Consultation.waitingList', ['data_candidat' =>  $info_consultation->candidats]);
    }

    public function creerConsultation(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'lien_zoom' => 'required',
            'lien_zoom_demarrer' => 'required',
            'date_heure' => 'required|date',
            'nombre_candidats' => 'required|integer',
            'id_consultante' => 'required|integer',
        ]);
        $consultation = InfoConsultation::create([
            'label' => 'CONS-' . date('Ymd', strtotime($request->input('date_heure'))) . '-' . $request->input('id_consultante'),
            'lien_zoom' => $request->input('lien_zoom'),
            'lien_zoom_demarrer' => $request->input('lien_zoom_demarrer'),
            'date_heure' => $request->input('date_heure'),
            'nombre_candidats' => $request->input('nombre_candidats'),
            'id_consultante' => $request->input('id_consultante')
        ]);
        // Rediriger avec un message de succès
        return redirect()->back();
    }


    public function ModifierConsultation(Request $request, $id)
    {
        // Valider les données du formulaire
        $request->validate([
            'lien_zoom' => 'required',
            'lien_zoom_demarrer' => 'required',
            'date_heure' => 'required|date',
            'nombre_candidats' => 'required|integer',
            'id_consultante' => 'required|integer',
        ]);
    
        try {
            // Récupérer la consultation à modifier
            $consultation = InfoConsultation::findOrFail($id);
    
            // Mettre à jour les champs de la consultation avec les données du formulaire
            $consultation->update([
                'lien_zoom' => $request->input('lien_zoom'),
                'lien_zoom_demarrer' => $request->input('lien_zoom_demarrer'),
                'date_heure' => $request->input('date_heure'),
                'nombre_candidats' => $request->input('nombre_candidats'),
                'id_consultante' => $request->input('id_consultante')
            ]);
    
            // Retourner une réponse JSON avec un code 200 pour succès
            return response()->json(['success' => true, 'message' => 'Consultation mise à jour avec succès']);
    
        } catch (\Exception $e) {
            // Retourner une réponse JSON avec un message d'erreur en cas d'exception
            return response()->json(['error' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
