<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Depense;

class DepenseController extends Controller
{
    public function ajoutDepense(Request $request)
    {
        // Validez les données du formulaire
        $request->validate([
            'montant' => 'required|numeric',
            'date' => 'required|date',
            'raison' => 'required|string',
        ]);
    
        // Récupérez l'ID de l'utilisateur
        $utilisateurId = auth()->user()->id;
    
        // Créez une nouvelle dépense avec l'ID de l'utilisateur
        Depense::create([
            'montant' => $request->input('montant'),
            'date' => $request->input('date'),
            'raison' => $request->input('raison'),
            'id_utilisateur' => $utilisateurId,
            // Ajoutez d'autres champs selon vos besoins
        ]);
    
        return redirect()->route('Banque'); // Redirigez après la création (ajustez la route selon votre besoin)
    }
    
}
