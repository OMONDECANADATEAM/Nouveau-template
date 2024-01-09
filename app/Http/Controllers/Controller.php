<?php

namespace App\Http\Controllers;

use DataTables;
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
        try {
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
                'date_naissance' => $request->input('date_naissance'),
                'remarque_agent' => $request->has('consultation_payee') ? $request->input('remarques') : 'Sans Objet',
    
            ]);
    
            $cvPath = null;
    
            
            if ($request->hasFile('cv') && $request->file('cv')->isValid()) {
                $cvPath = $request->file('cv')->storeAs('cv', 'cv' . $candidat->nom .$candidat->prenom . '.pdf', 'public');
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
    
                FicheConsultation::create(
                    ['id_candidat' => $candidat->id,
                        'lien_cv' => $cvPath,
                        'type_visa' => $request->input('type_visa'),
                        'reponse1' => $request->input('statut_matrimonial'),
                        'reponse2' => $request->input('passeport_valide'),
                        'reponse3' => $request->input('passeport_valide') == 'oui' ? $request->input('date_expiration_passeport') : 'Pas de Passeport valide',
                        'reponse4' => $request->input('casier_judiciaire'),
                        'reponse5' => $request->input('soucis_sante'),
                        'reponse6' => $request->input('enfants'),
                        'reponse7' => $request->input('enfants') == 'oui' ? $request->input('age_enfants') : "Pas d'enfant",
                        'reponse8' => $request->input('profession_domaine_travail'),
                        'reponse9' => $request->input('temps_travail_actuel'),
                        'reponse10' => $request->input('documents_emploi'),
                        'reponse11' => $request->input('procedure_immigration'),
                        'reponse12' => $request->input('procedure_immigration') == 'oui' ? $request->input('questions-procedure-immigration1') : 'Pas de procedure deja tentee',
                        'reponse13' => $request->input('procedure_immigration') == 'oui' ? $request->input('questions-procedure-immigration2') : 'Pas de procedure deja tentee',
                        'reponse14' => $request->input('diplome_etudes'),
                        'reponse15' => $request->input('annee_obtention_diplome'),
                        'reponse16' => $request->input('membre_famille_canada'),
                        'reponse17' => $request->input('immigrer_seul_ou_famille'),
                        'reponse18' => $request->input('langues_parlees'),
                        'reponse19' => $request->input('test_connaissances_linguistiques'),
                        'reponse20' => $request->input('niveau_scolarite_conjoint'),
                        'reponse21' => $request->input('domaine_formation_conjoint'),
                        'reponse22' => $request->input('age_conjoint'),
                        'reponse23' => $request->input('niveau_francais'),
                        'reponse24' => $request->input('niveau_anglais'),
                        'reponse25' => $request->input('age_enfants_linguistique'),
                        'reponse26' => $request->input('niveau_scolarite_enfants'),
                    ]);
            }
    
            // Redirection vers le dossier contact
            return redirect()->route('DossierContacts');
        } catch (ValidationException $e) {
            // Gérer les erreurs de validation
            // Vous pouvez rediriger en arrière avec les erreurs ou les gérer de toute autre manière
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            // Gérer les autres exceptions
            // Journalisez l'exception ou gérez-la en fonction des besoins de votre application
            return redirect()->back()->withErrors(['error' => 'Une erreur inattendue s\'est produite.'])->withInput();
        }
        //Validation du formulaire
      
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
                'profession' => ucwords(strtolower($request->input('profession'))),
                'consultation_payee' => $request->has('consultation_payee'),
                'id_utilisateur' => $idUtilisateur,
                'date_naissance' => $request->input('date_naissance'),
                'remarque_agent' => $request->has('consultation_payee') ? $request->input('remarques') : 'Sans Objet',
    ]);
        $cvPath = $candidat->ficheConsultation->lien_cv ?? null;


        
        if ($request->hasFile('cv') && $request->file('cv')->isValid()) {
            $cvPath = $request->file('cv')->storeAs('cv', 'cv_utilisateur_' . $candidat->id . '.pdf', 'public');
        }
        // Si la consultation est payée, mettez à jour ou créez une entrée et une fiche de consultation
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

            FicheConsultation::updateOrCreate(
                ['id_candidat' => $candidat->id,
                'lien_cv' => $cvPath,
                'type_visa' => $request->input('type_visa'),
                'reponse1' => $request->input('statut_matrimonial'),
                'reponse2' => $request->input('passeport_valide'),
                'reponse3' => $request->input('passeport_valide') == 'oui' ? $request->input('date_expiration_passeport') : 'Pas de Passeport valide',
                'reponse4' => $request->input('casier_judiciaire'),
                'reponse5' => $request->input('soucis_sante'),
                'reponse6' => $request->input('enfants'),
                'reponse7' => $request->input('enfants') == 'oui' ? $request->input('age_enfants') : "Pas d'enfant",
                'reponse8' => $request->input('profession_domaine_travail'),
                'reponse9' => $request->input('temps_travail_actuel'),
                'reponse10' => $request->input('documents_emploi'),
                'reponse11' => $request->input('procedure_immigration'),
                'reponse12' => $request->input('procedure_immigration') == 'oui' ? $request->input('questions-procedure-immigration1') : 'Pas de procedure deja tentee',
                'reponse13' => $request->input('procedure_immigration') == 'oui' ? $request->input('questions-procedure-immigration2') : 'Pas de procedure deja tentee',
                'reponse14' => $request->input('diplome_etudes'),
                'reponse15' => $request->input('annee_obtention_diplome'),
                'reponse16' => $request->input('membre_famille_canada'),
                'reponse17' => $request->input('immigrer_seul_ou_famille'),
                'reponse18' => $request->input('langues_parlees'),
                'reponse19' => $request->input('test_connaissances_linguistiques'),
                'reponse20' => $request->input('niveau_scolarite_conjoint'),
                'reponse21' => $request->input('domaine_formation_conjoint'),
                'reponse22' => $request->input('age_conjoint'),
                'reponse23' => $request->input('niveau_francais'),
                'reponse24' => $request->input('niveau_anglais'),
                'reponse25' => $request->input('age_enfants_linguistique'),
                'reponse26' => $request->input('niveau_scolarite_enfants'),
            ]
            );
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



    public function ajouterCandidatAConsultation(Request $request)
    {
        try {
            // Récupérer les données de la requête AJAX
            $consultationId = $request->input('consultation_id');
            $candidatId = $request->input('candidat_id');
    
            // Récupérer le candidat
            $candidat = Candidat::find($candidatId);
    
            // Vérifier si le candidat est déjà inscrit à une consultation
            if ($candidat->id_info_consultation !== null) {
                // Le candidat est déjà inscrit à une consultation
                // Vous pourriez renvoyer ici une liste des consultations disponibles ou d'autres informations
                return response()->json(['success' => false, 'message' => 'Le candidat est déjà inscrit à une consultation.']);
            }
    
            // Récupérer la consultation
            $consultation = InfoConsultation::findOrFail($consultationId);
    
            $candidatsInscrits = $consultation->candidats;
    
            // Calculer le nombre de candidats inscrits et les places disponibles
            $nombreCandidatsInscrits = count($candidatsInscrits);
            $placesDisponibles = $consultation->nombre_candidats - $nombreCandidatsInscrits;
    
            // Vérifier s'il y a des places disponibles
            if ($placesDisponibles > 0) {
                // Ajouter l'ID de la nouvelle consultation à la colonne id_info_consultation du candidat
                $candidat->id_info_consultation = $consultation->id;
                $candidat->save();
    
                return response()->json(['success' => true, 'message' => 'Candidat ajouté avec succès à la nouvelle consultation']);
            } else {
                return response()->json(['success' => false, 'message' => 'La nouvelle consultation est complète, aucune place disponible.']);
            }
        } catch (\Exception $e) {
            // Log l'erreur pour un débogage ultérieur
            \Log::error('Erreur lors de l\'ajout du candidat à la nouvelle consultation: ' . $e->getMessage());
    
            return response()->json(['success' => false, 'message' => 'Erreur lors de l\'ajout du candidat à la nouvelle consultation ' . $e->getMessage()]);
        }
    }
    

}
