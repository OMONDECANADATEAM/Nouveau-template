<?php

namespace App\Http\Controllers;

use App\Models\Candidat; 
use Illuminate\Http\Request;
use App\Models\Entree;
use App\Notifications\VersementNotification;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
                'id_type_paiement' => $request->input('type')
                // Ajoutez d'autres champs selon vos besoins
            ]);
    
         
            $candidat = Candidat::find($candidatId);

            // Si c'est un versement, mettez à jour la colonne 'versement_effectue' à vrai si ce n'est pas déjà le cas
            if ($request->input('type') == 1) {
                // Ajoutez des logs pour déboguer
              
                if (!$candidat->versement_effectuee) {
                    $candidat->update(['versement_effectuee' => 1]);
                }
            }
    
            $agent = auth()->user()->name . ' ' . auth()->user()->last_name;
    
            // Utilisez la fonction pour récupérer les utilisateurs par rôle
            $utilisateursNotifies = $this->getUsersByRole(3); // Remplacez $roleId par l'ID du rôle que vous souhaitez
    
            // Utilisez une transaction pour garantir la cohérence de la base de données lors de l'envoi des notifications
            DB::transaction(function () use ($utilisateursNotifies, $montant, $agent) {
                foreach ($utilisateursNotifies as $utilisateur) {
                    $utilisateur->notify(new VersementNotification($montant, $agent));
                }
            });
    
            return redirect()->back()->with('success', 'Entrée enregistrée avec succès.');
    
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    
    
    
    public function getUsersByRole($roleId)
    {
        // Utilisez Eloquent pour récupérer les utilisateurs ayant le rôle spécifié
        $utilisateurs = User::where('id_role_utilisateur', $roleId)->get();
    
        return $utilisateurs;
    }
    
}
