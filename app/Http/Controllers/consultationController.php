<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidat;

class consultationController extends Controller
{
    public function toggleConsultation($candidatId)
    {
        try {
            $candidat = Candidat::find($candidatId);
            $status = request('status');
    
            $candidat->update(['consultation_effectuee' => ($status === 'yes')]);
    
            return response()->json(['success' => true, 'message' => 'Statut de consultation mis à jour avec succès.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erreur lors de la mise à jour du statut de consultation.']);
        }
    }

}
