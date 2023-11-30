<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entree;
use App\Models\Candidat; // Assurez-vous d'importer le modèle Entree

class EntreeController extends Controller
{
    public function ajoutEntree(Request $request)
    {
        try {
            // Validez les données du formulaire
            $request->validate([
                'montant' => 'required|numeric',
                'date' => 'required|date',
                'candidat' => 'required|exists:candidat,id', // Assurez-vous que le candidat existe
                'type' => 'required',
            ]);
    
            // Récupérez l'ID du candidat à partir du champ 'candidat'
            $candidatId = $request->input('candidat');
    
            // Récupérez l'ID de l'utilisateur (ajoutez cette ligne si vous avez un champ 'id_utilisateur' dans votre formulaire)
            $utilisateurId = auth()->user()->id; // Assurez-vous que votre utilisateur est authentifié
    
            // Créez une nouvelle entrée
            Entree::create([
                'montant' => $request->input('montant'),
                'date' => $request->input('date'),
                'id_utilisateur' => $utilisateurId,
                'id_candidat' => $candidatId,
                'id_type_paiement' => $request->input('type') // Assurez-vous que les IDs correspondent à votre logique
                // Ajoutez d'autres champs selon vos besoins
            ]);
    
            return redirect()->route('Banque')->with('success', 'Entrée enregistrée avec succès.');
    
        } catch (\Exception $e) {
            return redirect()->route('Banque')->with('error', $e->getMessage());
        }
    }
    
}
