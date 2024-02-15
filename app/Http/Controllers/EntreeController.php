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
            // Validate the form data
            $request->validate([
                'montant' => 'required|numeric',
                'datetime' => 'required|date_format:Y-m-d\TH:i',
                'candidat' => 'required|exists:candidat,id',
                // ... other validation rules
            ]);
    
            // Récupérez l'ID du candidat à partir du champ 'candidat'
            $candidatId = $request->input('candidat');
            $formattedDateTime = date('Y-m-d H:i:s', strtotime($request->input('datetime')));
    
            // Récupérez l'ID de l'utilisateur (ajoutez cette ligne si vous avez un champ 'id_utilisateur' dans votre formulaire)
            $utilisateurId = auth()->user()->id; // Assurez-vous que votre utilisateur est authentifié
    
            // Créez une nouvelle entrée
            Entree::create([
                'montant' => $request->input('montant'),
                'date' => $formattedDateTime, // Use the formatted datetime
                'id_utilisateur' => $utilisateurId,
                'id_candidat' => $candidatId,
                'id_type_paiement' => 1
            ]);
    
            $candidat = Candidat::find($candidatId);
    
            // Si c'est un versement, mettez à jour la colonne 'versement_effectue' à vrai si ce n'est pas déjà le cas
            if ($request->input('type') == 1) {
                if (!$candidat->versement_effectuee) {
                    $candidat->update(['versement_effectuee' => 1]);
                }
            }
    
            $montant = number_format($request->input('montant'), 0, '.', ' ');
            $agent = auth()->user()->name . ' ' . auth()->user()->last_name;
    
            // Utilisez la fonction pour récupérer les utilisateurs par rôle
            $utilisateursNotifies = $this->getUsersByRole(4);
    
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
