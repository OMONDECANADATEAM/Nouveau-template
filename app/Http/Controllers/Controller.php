<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function soumettreFormulaire(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'pays' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'numero_telephone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'profession' => 'required|string|max:255',
            'date_naissance' => 'required|date',
        ]);

        // Récupérez l'ID de l'utilisateur connecté
        $idUtilisateur = Auth::id();

        // Appel à la fonction pour sauvegarder les données
        Candidat::create([
            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenoms'),
            'pays' => $request->input('pays'),
            'ville' => $request->input('ville'),
            'numero_telephone' => $request->input('numero_telephone'),
            'email' => $request->input('email'),
            'profession' => $request->input('profession'),
            'date_naissance' => $request->input('date_naissance'),
            'consultation_payee' => $request->has('consultation_payee'),
            'id_utilisateur' => $idUtilisateur,
        ]);
    }

    public function selectAllCandidat()
{
    // Obtenir les données des candidats
    $candidats = Candidat::all();

    // Passer les données à la vue principale
    return view('DossierContacts', ['candidat' => $candidats]);
}
}
