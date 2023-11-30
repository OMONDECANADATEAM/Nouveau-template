<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Entree;
use App\Models\InfoConsultation;
use App\Models\FicheConsultation;
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
    

        if ($request->hasFile('cv') && $request->file('cv')->isValid()) {
            $cvPath = $request->file('cv')->storeAs('cv', 'cv_utilisateur_' . $candidat->id . '.pdf', 'public');
        }    
        // Si la consultation est payée, créez une entrée et la fiche de consultation
        if ($candidat->consultation_payee) {
            $entree = Entree::create([
                'id_candidat' => $candidat->id,
                'montant' => 50000,
                'date' => Carbon::now(),
                'id_utilisateur' => $idUtilisateur,
                'id_type_paiement' => 2,
            ]);
    
            FicheConsultation::create([
                'id_candidat' => $candidat->id,
                'lien_cv' => $cvPath,
                'reponse1' => $request->input('statut_matrimonial'),
                'reponse2' => $request->has('passeport_valide') ? $request->input('date_expiration_passeport') : null,
                'reponse3' => $request->has('casier_judiciaire') ? $request->input('reponse_casier_judiciaire') : null,
                'reponse4' => $request->has('soucis_sante') ? $request->input('reponse_soucis_sante') : null,
                'reponse5' => $request->has('enfants') ? $request->input('age_enfants') : null,
                'reponse6' => $request->input('profession_domaine_travail'),
                'reponse7' => $request->input('temps_travail_actuel'),
                'reponse8' => $request->has('documents_emploi') ? 1 : 0,
                'reponse9' => $request->has('procedure_immigration') ? $request->input('questions-procedure-immigration1') : null,
                'reponse10' => $request->has('procedure_immigration') ? $request->input('questions-procedure-immigration2') : null,
                'reponse11' => $request->has('diplome_etudes') ? $request->input('annee_obtention_diplome') : null,
                'reponse12' => $request->has('membre_famille_canada') ? 1 : 0,
                'reponse13' => $request->has('immigrer_seul_ou_famille') ? 1 : 0,
                'reponse14' => $request->has('langues_parlees') ? 1 : 0,
                'reponse15' => $request->has('test_connaissances_linguistiques') ? 1 : 0,
                'reponse16' => $request->input('niveau_scolarite_conjoint'),
                'reponse17' => $request->input('domaine_formation_conjoint'),
                'reponse18' => $request->input('age_conjoint'),
                'reponse19' => $request->input('niveau_francais'),
                'reponse20' => $request->input('niveau_anglais'),
                'reponse21' => $request->input('age_enfants_linguistique'),
                'reponse22' => $request->input('niveau_scolarite_enfants'),
            ]);
        }
    
        // Redirection vers le dossier contact
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

    // Si la consultation est payée, mettez à jour ou créez une entrée et une fiche de consultation
    if ($candidat->consultation_payee) {
        $cvPath = $request->file('cv')->storeAs('cv', 'cv_utilisateur_' . $candidat->id . '.pdf', 'public');

        $entree = Entree::updateOrCreate(
            ['id_candidat' => $candidat->id],
            [
                'montant' => 50000,
                'date' => Carbon::now(),
                'id_utilisateur' => $idUtilisateur,
                'id_type_paiement' => 2,
            ]
        );

        FicheConsultation::updateOrCreate([
            'id_candidat' => $candidat->id,
            'lien_cv' => $cvPath,
            'reponse1' => $request->input('statut_matrimonial'),
            'reponse2' => $request->has('passeport_valide') ? $request->input('date_expiration_passeport') : null,
            'reponse3' => $request->has('casier_judiciaire') ? $request->input('reponse_casier_judiciaire') : null,
            'reponse4' => $request->has('soucis_sante') ? $request->input('reponse_soucis_sante') : null,
            'reponse5' => $request->has('enfants') ? $request->input('age_enfants') : null,
            'reponse6' => $request->input('profession_domaine_travail'),
            'reponse7' => $request->input('temps_travail_actuel'),
            'reponse8' => $request->has('documents_emploi') ? 1 : 0,
            'reponse9' => $request->has('procedure_immigration') ? $request->input('questions-procedure-immigration1') : null,
            'reponse10' => $request->has('procedure_immigration') ? $request->input('questions-procedure-immigration2') : null,
            'reponse11' => $request->has('diplome_etudes') ? $request->input('annee_obtention_diplome') : null,
            'reponse12' => $request->has('membre_famille_canada') ? 1 : 0,
            'reponse13' => $request->has('immigrer_seul_ou_famille') ? 1 : 0,
            'reponse14' => $request->has('langues_parlees') ? 1 : 0,
            'reponse15' => $request->has('test_connaissances_linguistiques') ? 1 : 0,
            'reponse16' => $request->input('niveau_scolarite_conjoint'),
            'reponse17' => $request->input('domaine_formation_conjoint'),
            'reponse18' => $request->input('age_conjoint'),
            'reponse19' => $request->input('niveau_francais'),
            'reponse20' => $request->input('niveau_anglais'),
            'reponse21' => $request->input('age_enfants_linguistique'),
            'reponse22' => $request->input('niveau_scolarite_enfants'),
        ]);
    } else {
        // Si la consultation n'est pas payée, vérifiez s'il existe une entrée et supprimez-la
        Entree::where('id_candidat', $candidat->id)->delete();
        
        // Supprimez également la fiche de consultation s'il en existe une
        FicheConsultation::where('id_candidat', $candidat->id)->delete();
    }

    // Redirection vers dossier contact
    return redirect()->route('DossierContacts');

    
}


public function ajoutConsultation(Request $request)
{
    // Valider les données du formulaire
    $request->validate([
        'label' => 'required',
        'lien_zoom' => 'required',
        'lien_zoom_demarrer' => 'required',
        'date_heure' => 'required|date',
        'nombre_candidats' => 'required|integer',
        'id_consultante' => 'required|integer',
    ]);
    $consultation = InfoConsultation::create([
        'label' => $request->input('label'),
        'lien_zoom' => $request->input('lien_zoom'),
        'lien_zoom_demarrer' => $request->input('lien_zoom_demarrer'),
        'date_heure' => $request->input('date_heure'),  
        'nombre_candidats' => $request->input('nombre_candidats'),
        'id_consultante' => $request->input('id_consultante')
    ]);
    
    // Rediriger avec un message de succès
    return redirect()->route('Consultation');
}

public function rechercheCandidat(Request $request)
{
    $term = $request->input('term'); // Terme de recherche

    // Effectuez la recherche dans la base de données et renvoyez les résultats au format JSON
    $candidats = Candidat::where('nom', 'LIKE', "%$term%")->orWhere('prenom', 'LIKE', "%$term%")->get();

    $formattedCandidats = [];

    foreach ($candidats as $candidat) {
        $formattedCandidats[] = [
            'id' => $candidat->id,
            'text' => $candidat->nom . ' ' . $candidat->prenom,
        ];
    }

    return response()->json($formattedCandidats);
}


}
