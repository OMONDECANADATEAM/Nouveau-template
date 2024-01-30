<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\consultante;
use App\Models\InfoConsultation;

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
        $consultationInfo = InfoConsultation::with('candidats')->where('id', $consultationId)->first();
        return view('Consultation.waitingList', ['data_candidat' => $consultationInfo->candidats]);
    }
    
    
    
    
}
