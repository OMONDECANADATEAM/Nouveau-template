<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Document;
use App\Models\Dossier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    // Vérifiez si le dossier du candidat existe, sinon, créez-le
    $dossierPath = 'dossierClient/' . $candidat->nom . $candidat->prenom . $candidat->id;
    $dossier = $candidat->dossier;

    if (!$dossier) {
        // Créez un dossier pour le candidat s'il n'en a pas encore un
        $dossier = Dossier::create(['id_candidat' => $candidat->id, 'id_agent' => Auth::user()->id, 'url' => 'public/' . $dossierPath]);
    }

    // Vérifiez si le dossier existe, sinon, créez-le
    if (!file_exists(storage_path('app/public/' . $dossierPath))) {
        mkdir(storage_path('app/public/' . $dossierPath), 0755, true);
    }

    // Logique pour gérer l'ajout de fichiers
    $files = $request->file('fichiers');
    $typesDocuments = $request->input('typeDocument');

    // Boucle sur chaque fichier pour l'ajouter séparément
    foreach ($files as $key => $file) {
        // Utilisez le type de document sélectionné pour ce fichier comme base pour le nom du fichier
        $typeDocument = $typesDocuments[$key]; // Obtenir le type de document correspondant pour ce fichier
        $nomFichier = $typeDocument . '.' . $file->getClientOriginalExtension();

        // Déplacez le fichier dans le dossier du candidat avec le nom de fichier unique
        $file->move(storage_path('app/public/' . $dossierPath), $nomFichier);

        // Ajoutez le document associé à ce dossier avec le type de document correspondant
        Document::create([
            'id_dossier' => $dossier->id,
            'nom' => $nomFichier,
            'url' => 'http://localhost/Nouveau-template/storage/app/public/' . $dossierPath . '/' . $nomFichier,
        ]);
    }

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
