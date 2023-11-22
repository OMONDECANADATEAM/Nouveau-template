<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Entree;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public $timestamps = false;


    public function soumettreFormulaire(Request $request)
    {
        //Validation du formulaire
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'pays' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'numero_telephone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'profession' => 'required|string|max:255',
        ]);
    
        // Récupération l'ID de l'utilisateur connecté
        $idUtilisateur = Auth::id();
    
        // Création du candidat
        $candidat = Candidat::create([
            'nom' => ucwords(strtolower($request->input('nom'))),
            'prenom' => ucwords(strtolower($request->input('prenoms'))),
            'pays' => ucwords(strtolower($request->input('pays'))),
            'ville' => ucwords(strtolower($request->input('ville'))),
            'numero_telephone' => $request->input('numero_telephone'),
            'email' => $request->input('email'),
            'profession' => ucwords(strtolower($request->input('profession'))),
            'consultation_payee' => $request->has('consultation_payee'),
            'id_utilisateur' => $idUtilisateur,
        ]);
    
        // Si la consultation est payée, créez une entrée
        if ($candidat->consultation_payee) {
            Entree::create([
                'id_candidat' => $candidat->id,
                'montant' => 50000,
                'date' => Carbon::now(),
                'id_utilisateur' => $idUtilisateur,
                'id_type_paiement' => 2,
            ]);
        }
        
        //redirection vers dossier contact
        return redirect()->route('DossierContacts');
    }



    public function modifierFormulaire(Request $request, $idCandidat)
{
    // Validation du formulaire
    $request->validate([
        'nom' => 'required|string|max:255',
        'prenoms' => 'required|string|max:255',
        'pays' => 'required|string|max:255',
        'ville' => 'required|string|max:255',
        'numero_telephone' => 'required|string|max:20',
        'email' => 'required|email|max:255',
        'profession' => 'required|string|max:255',
    ]);

    // Récupération l'ID de l'utilisateur connecté
    $idUtilisateur = Auth::id();

    // Récupération du candidat à modifier
    $candidat = Candidat::find($idCandidat);


    // Modification des informations du candidat
    $candidat->update([
        'nom' => ucwords(strtolower($request->input('nom'))),
        'prenom' => ucwords(strtolower($request->input('prenoms'))),
        'pays' => ucwords(strtolower($request->input('pays'))),
        'ville' => ucwords(strtolower($request->input('ville'))),
        'numero_telephone' => $request->input('numero_telephone'),
        'email' => $request->input('email'),
        'consultation_payee' => $request->has('consultation_payee'),
        'profession' => ucwords(strtolower($request->input('profession'))),
    ]);

    // Si la consultation est payée, mettez à jour ou créez une entrée
    if ($candidat->consultation_payee) {
        $entree = Entree::updateOrCreate(
            ['id_candidat' => $candidat->id],
            [
                'montant' => 50000,
                'date' => Carbon::now(),
                'id_utilisateur' => $idUtilisateur,
                'id_type_paiement' => 2,
            ]
        );
    } else {
        // Si la consultation n'est pas payée, vérifiez s'il existe une entrée et supprimez-la
        Entree::where('id_candidat', $candidat->id)->delete();
    }

    // Redirection vers dossier contact
    return redirect()->route('DossierContacts')->with('success', 'Les informations du candidat ont été modifiées avec succès.');
}
}
