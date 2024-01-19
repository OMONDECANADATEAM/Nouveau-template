<?php

namespace App\Http\Controllers;

use App\Models\Candidat; 
use App\Models\User;
use Illuminate\Http\Request;

class DossierController extends Controller
{
    public function ajouterFichiersCandidat(Request $request, $candidatId)
    {
        // Récupérez le candidat en fonction de l'ID
        $candidat = Candidat::find($candidatId);

        // Vérifiez si le candidat existe
        if (!$candidat) {
            return response()->json(['message' => 'Candidat non trouvé'], 404);
        }

        // Construisez le chemin du dossier
        $dossierPath = 'dossierClient/' . substr($candidat->nom, 0, 2) . substr($candidat->prenom, 0, 1) . $candidat->id;

        // Vérifiez si le dossier existe, sinon, créez-le
        if (!file_exists(storage_path('app/public/' . $dossierPath))) {
            mkdir(storage_path('app/public/' . $dossierPath), 0755, true);
        } 

        // Logique pour gérer l'ajout de fichiers
        // Accédez aux fichiers téléchargés via $request->file('fichiers')

        // Exemple : enregistrez les fichiers dans le dossier du candidat
        foreach ($request->file('fichiers') as $file) {
            $file->move(storage_path('app/public/' . $dossierPath), $file->getClientOriginalName());
        }

        // Vous pouvez retourner une réponse JSON ou rediriger vers une autre page
        return response()->json(['message' => 'Fichiers ajoutés avec succès']);
    }

    public function ajouterFichiersAgent(Request $request, $userId)
    {
        // Récupérez le candidat en fonction de l'ID
        $user = User::find($userId);

        // Vérifiez si le candidat existe
        if (!$user) {
            return response()->json(['message' => 'Candidat non trouvé'], 404);
        }

        // Construisez le chemin du dossier
        $dossierPath = 'dossierAgent/' . substr($user->name, 0, 2) . substr($user->last_name, 0, 1) . $user->id;

        // Vérifiez si le dossier existe, sinon, créez-le
        if (!file_exists(storage_path('app/public/' . $dossierPath))) {
            mkdir(storage_path('app/public/' . $dossierPath), 0755, true);
        } 

        // Logique pour gérer l'ajout de fichiers
        // Accédez aux fichiers téléchargés via $request->file('fichiers')

        // Exemple : enregistrez les fichiers dans le dossier du candidat
        foreach ($request->file('fichiers') as $file) {
            $file->move(storage_path('app/public/' . $dossierPath), $file->getClientOriginalName());
        }

        // Vous pouvez retourner une réponse JSON ou rediriger vers une autre page
        return response()->json(['message' => 'Fichiers ajoutés avec succès']);
    }
}
