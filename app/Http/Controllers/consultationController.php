<?php

namespace App\Http\Controllers;

use App\Models\Candidat;

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
    
    
    
    
}
