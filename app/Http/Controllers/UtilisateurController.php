<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\consultante;

class UtilisateurController extends Controller
{
    public function formulaireCreation()
    {
        return view('createUser');
    }

    // Assurez-vous d'importer le modèle d'utilisateur


    public function creer(Request $request)
    {
        // Validez les données du formulaire
        $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'mot_de_passe' => 'required|string|min:6',
            'poste_occupe' => 'required|exists:poste_occupe,id',
            'id_role_utilisateur' => 'required|exists:role_utilisateur,id',
            'id_succursale' => 'required|exists:succursale,id',
            'photo_profil' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Traitement de la photo de profil
        if ($request->hasFile('photo_profil')) {
            // Enregistrez le fichier sur le serveur
            $path = $request->file('photo_profil')->storeAs('photo', 'photo' . $request->input('non') . $request->input('prenom') . '.png', 'public');
        }

        // Créez l'utilisateur avec le lien de la photo de profil
        $utilisateur = User::create([
            'last_name' => $request->input('prenom'),
            'name' => $request->input('nom'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('mot_de_passe')),
            'id_poste_occupe' => $request->input('poste_occupe'),
            'id_role_utilisateur' => $request->input('id_role_utilisateur'),
            'id_succursale' => $request->input('id_succursale'),
            'lien_photo' => $path, // Utilisez le chemin du fichier s'il existe, sinon null
        ]);

        if ($request->input('id_role_utilisateur') === 0) {
            consultante::create([
                'nom' => $utilisateur->name,
                'prenoms' => $utilisateur->last_name,
                'id_utilisateur' => $utilisateur->id,
            ]);
        }

        return $utilisateur
            ? redirect()->back()
            : redirect()->back()->with('error', 'Une erreur s\'est produite lors de la création de l\'utilisateur.');
    }

    
    public function modifier(Request $request, $id)
    {
        // Obtenez l'utilisateur à modifier
        $utilisateur = User::find($id);
    
        // Si l'utilisateur n'existe pas, retournez une réponse JSON avec un message d'erreur
        if (!$utilisateur) {
            return response()->json(['error' => 'Utilisateur non trouvé.'], 404);
        }
    
        // Si l'utilisateur existe, validez les données du formulaire
        $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'mot_de_passe' => 'nullable|string|min:6', // Rendre le mot de passe facultatif
            'poste_occupe' => 'required|exists:poste_occupe,id',
            'id_role_utilisateur' => 'required|exists:role_utilisateur,id',
            'id_succursale' => 'required|exists:succursale,id',
            'photo_profil' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        // Traitement de la photo de profil
        if ($request->hasFile('photo_profil')) {
            // Enregistrez le fichier sur le serveur
            $path = $request->file('photo_profil')->storeAs('photo', 'photo' . $utilisateur->nom . $utilisateur->prenoms . '.png', 'public');
            // Mettez à jour le lien de la photo de profil dans la base de données
            $utilisateur->update(['lien_photo' => $path]);
        }
    
        // Mettez à jour les autres champs de l'utilisateur
        $utilisateur->update([
            'last_name' => $request->input('prenom'),
            'name' => $request->input('nom'),
            'email' => $request->input('email'),
            'id_poste_occupe' => $request->input('poste_occupe'),
            'id_role_utilisateur' => $request->input('id_role_utilisateur'),
            'id_succursale' => $request->input('id_succursale'),
        ]);
    
        // Mettez à jour le mot de passe s'il est fourni
        if ($request->filled('mot_de_passe')) {
            $utilisateur->update(['password' => bcrypt($request->input('mot_de_passe'))]);
        }
    
        // Retournez une réponse JSON avec un message de succès
        return response()->json(['success' => 'Utilisateur modifié avec succès.'], 200);
    }
    
    

}
