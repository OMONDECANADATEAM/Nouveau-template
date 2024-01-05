<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entree;
use App\Notifications\VersementNotification;
use App\Models\User;

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
            $agent = auth()->user()->name . ' ' . auth()->user()->last_name;
            $montant = $request->input('montant');
            

            // Envoyez la notification avec le montant
            $user = User::find(2); // Vous pouvez obtenir l'utilisateur à notifier ici
            $user->notify(new VersementNotification($montant, $agent));
    
            return redirect()->back()->with('success', 'Entrée enregistrée avec succès.');
    
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    
}
