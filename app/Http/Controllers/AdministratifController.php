<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Depense;
use App\Models\Procedure;
use App\Models\StatutProcedure;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Dossier;
use Illuminate\Support\Facades\Auth;
use App\Models\Entree;
use App\Models\FicheConsultation;
use App\Models\RendezVous;
use Carbon\Carbon;
use App\Models\InfoConsultation;
use App\Notifications\DateConsultationNotification;
use App\Notifications\ProcedureCreatedNotifications;
use App\Notifications\StatutNotifications;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;




class AdministratifController extends Controller
{
    function utilisateurHasPoste($postes)
    {
        $utilisateurConnecte = auth()->user();
        return in_array($utilisateurConnecte->id_poste_occupe, $postes);
    }
    //Ramene la page principale avec les données necessaire
    public function Dashboard()
    {
        $hasPoste = $this->utilisateurHasPoste([3, 5]);

        $entreeMensuelData = $this->entreeMensuel();
        $devise = $this->devise();
        $nombreConsultationData = $this->nombreConsultationMensuel();
        $nombreVersementData = $this->nombreVersementMensuel();
        $consultations = $this->prochaineConsultation();
        $caisseMensuel = $this->caisseMensuel();


        return view('Administratif.Views.Dashboard', [
            'entreeMensuel' => $entreeMensuelData['entreeMensuel'],
            'moisEnCours' => $entreeMensuelData['moisEnCours'],
            'devise' => $devise,
            'nombreConsultationMensuel' => $nombreConsultationData['nombreConsultationMensuel'],
            'nombreVersementMensuel' => $nombreVersementData['nombreVersementMensuel'],
            'consultations' => $consultations,
            'caisse' => $caisseMensuel['caisseMensuel'],
            'hasPoste' => $hasPoste,

        ]);
    }
    //Ramene le montant du mois pour l'utilisateur connecté
    private function entreeMensuel()
    {
        Carbon::setLocale('fr');
        $moisEnCours = Carbon::now()->monthName;

        // Calculez la somme des entrées pour le mois actuel et l'année actuelle en utilisant le modèle Entree
        $entreeMensuel = Entree::where('id_utilisateur', auth()->user()->id)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('montant');

        return ['entreeMensuel' => $entreeMensuel, 'moisEnCours' => $moisEnCours];
    }

    //Ramene le montant du mois pour l'utilisateur connecté
    private function caisseMensuel()
    {
        Carbon::setLocale('fr');
        $moisEnCours = Carbon::now()->monthName;

        // Calculez la somme des entrées pour le mois actuel et l'année actuelle en utilisant le modèle Entree
        $entreeMensuel = Entree::where('id_utilisateur', auth()->user()->id)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('montant');

        // Calculez la somme des dépenses pour le mois actuel et l'année actuelle en utilisant le modèle Depense
        $depenseMensuel = Depense::where('id_utilisateur', auth()->user()->id)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('montant');

        // Calculez la différence entre les entrées et les dépenses
        $difference = $entreeMensuel - $depenseMensuel;

        return ['caisseMensuel' => $difference];
    }

    //Ramene le nombre de consultations pour l'utilisateur connecté
    private function nombreConsultationMensuel()
    {
        // Calculez le nombre de consultations pour le mois actuel et l'année actuelle en utilisant le modèle Entree
        $nbrConsultation = Entree::where('id_utilisateur', auth()->user()->id)
            ->where('id_type_paiement', 2)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->count();

        return ['nombreConsultationMensuel' => $nbrConsultation];
    }
    //Ramene le nombre de versements pour l'utilisateur connecté
    private function nombreVersementMensuel()
    {
        // Calculez le nombre de consultations pour le mois actuel et l'année actuelle en utilisant le modèle Entree
        $nbrVersement = Entree::where('id_utilisateur', auth()->user()->id)
            ->where('id_type_paiement', 1)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->count();

        return ['nombreVersementMensuel' => $nbrVersement];
    }
    //Ramene la devise en fonction de la succursalle
    public function devise()
    {
        // Obtenez l'ID de la succursale de l'utilisateur connecté
        $succursaleId = auth()->user()->id_succursale;

        // Vérifiez si l'ID de la succursale est égal à 3
        if ($succursaleId === 4) {
            // Si oui, renvoyez le symbole de la devise $
            return '$';
        } else {
            // Sinon, renvoyez le symbole de la devise FCFA (vous pouvez ajuster selon votre besoin)
            return 'FCFA';
        }
    }
    //Ramene les 3 prochaines consultations
    public function prochaineConsultation()
    {
        Carbon::setLocale('fr');
        $consultations = InfoConsultation::where('date_heure', '>=', Carbon::today())
            ->orderBy('date_heure')
            ->take(4)
            ->get();

        $consultations->transform(function ($consultation) {
            $dateFormatee = Carbon::parse($consultation->date_heure)->translatedFormat('l j F Y H:i');
            $consultation->dateFormatee = ucwords($dateFormatee);

            return $consultation;
        });

        return $consultations;
    }

    //Ramene la somme des entrées par mois pendant l'année en cours
    public function EntreeChartData()
    {
        // Utilisateur connecté
        $utilisateurConnecte = Auth::user();

        // Année actuelle
        $anneeActuelle = Carbon::now()->year;

        // Récupérez les données de la base de données pour l'année actuelle
        $data = Entree::whereYear('date', $anneeActuelle)
            ->where('id_utilisateur', $utilisateurConnecte->id)
            ->get();

        // Formatez les données pour le graphique
        $formattedData = $this->formatChartData($data);

        // Retournez les données au format JSON
        return response()->json($formattedData);
    }

    private function formatChartData($data)
    {
        // Initialisez un tableau pour stocker les données formatées
        $formattedData = [];

        // Groupement des données par mois
        $groupedData = $data->groupBy(function ($entry) {
            return Carbon::parse($entry->date)->format('M');
        });

        // Bouclez à travers les données groupées et formatez-les
        foreach ($groupedData as $month => $entries) {
            // Calculez la somme des montants pour le mois actuel
            $totalMontant = $entries->sum('montant');

            $formattedData[] = [
                'month' => $month,
                'totalMontant' => $totalMontant,
            ];
        }

        // Retournez les données formatées
        return $formattedData;
    }

    public function Clients()
    {
        Carbon::setLocale('fr');
        $clients = $this->allClients();

        $consultations = $this->consultationsDisponible();



        return view('Administratif.Views.Clients', ['clients' => $clients, 'consultationsDisponible' => $consultations]);
    }
    public function allClients()
    {
        Carbon::setLocale('fr');

        // Obtenir l'utilisateur connecté
        $idSuccursaleUtilisateur = auth()->user()->id_succursale;

        // Obtenez les candidats avec les rendez-vous et la consultation payée pour le commercial de la même succursale
        $clientsIds = RendezVous::where('consultation_payee', 1)
            ->whereHas('commercial', function ($query) use ($idSuccursaleUtilisateur) {
                $query->where('id_succursale', $idSuccursaleUtilisateur);
            })
            ->orderBy('date_rdv', 'desc')
            ->pluck('candidat_id'); // Supposons que la clé étrangère soit id_candidat

        $clients = Candidat::whereIn('id', $clientsIds)
            ->orderBy('date_enregistrement', 'desc')
            ->get();

        // Convertir la date et l'heure pour chaque candidat
        $clients->transform(function ($client) {
            if ($client->infoConsultation) {
                $dateFormatee = Carbon::parse($client->infoConsultation->date_heure)->translatedFormat('l j F Y H:i');
                $client->dateFormatee = ucwords($dateFormatee);
            } else {
                $client->dateFormatee = 'N / A'; // Ou toute autre valeur par défaut que vous souhaitez afficher pour les valeurs nulles
            }
            return $client;
        });



        return $clients;
    }

    public function consultationsDisponible()
    {
        Carbon::setLocale('fr');

        // Récupérer l'heure actuelle
        $now = Carbon::yesterday();

        // Sélectionner les consultations disponibles où le nombre de candidats est inférieur au nombre maximum prévu
        $consultations = InfoConsultation::where('nombre_candidats', '>', function ($query) {
            $query->selectRaw('count(*)')
                ->from('candidat')
                ->whereColumn('info_consultation.id', 'candidat.id_info_consultation');
        })
            ->where('date_heure', '>', $now) // Ajouter la condition pour ne pas sélectionner les dates passées
            ->get();

        // Formater les dates des consultations
        $consultations->transform(function ($consultation) {
            $dateFormatee = Carbon::parse($consultation->date_heure)->translatedFormat('l j F Y H:i');
            $consultation->dateFormatee = ucwords($dateFormatee);

            return $consultation;
        });

        return $consultations;
    }


    public function CreerOuModifierFiche(Request $request, $idCandidat)
{
    try {
        Log::info('Début du traitement de la fiche de consultation pour le candidat: ' . $idCandidat);

        // Validation du formulaire
        $this->validateForm($request);

        // Vérification de la présence du champ cv dans la requête
        if ($request->hasFile('cv')) {
            Log::info('Le champ cv est présent dans la requête.');
        } else {
            Log::warning('Le champ cv n\'est pas présent dans la requête.');
        }

        // Récupération de l'ID de l'utilisateur connecté
        $idUtilisateur = Auth::id();

        // Récupération du candidat à modifier
        $candidat = Candidat::findOrFail($idCandidat);

        // Modification des informations du candidat
        $this->updateCandidatInfo($request, $candidat, $idUtilisateur);

        // Traitement du fichier CV si présent
        $cvPath = $this->handleCV($request, $candidat);

        // Mise à jour ou création de la fiche de consultation et des entrées
        $this->updateFicheConsultation($request, $candidat, $cvPath);

        Log::info('Fin du traitement de la fiche de consultation pour le candidat: ' . $idCandidat);

        // Redirection vers dossier contact avec un message de succès
        return redirect()->back()->with('success', 'Formulaire modifié avec succès.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Gérer les erreurs de validation
        Log::error('Erreur de validation : ' . json_encode($e->errors()));
        return redirect()->back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
        // Gérer les autres exceptions
        Log::error('Erreur inattendue : ' . $e->getMessage());
        return redirect()->back()->withErrors(['error' => 'Une erreur inattendue s\'est produite.'])->withInput();
    }
}

    

    private function validateForm(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'pays' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'numero_telephone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'profession' => 'required|string|max:255',
        ]);
    }

    private function updateCandidatInfo(Request $request, $candidat, $idUtilisateur)
    {
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
    }
    private function handleCV(Request $request, $candidat)
{
    Log::info('Début du traitement du CV pour le candidat: ' . $candidat->id);
    $cvPath = $candidat->ficheConsultation->lien_cv ?? '';

    if ($request->hasFile('cv')) {
        $file = $request->file('cv');
        if ($file->isValid()) {
            Log::info('Fichier CV valide reçu.');
            Log::info('Nom original du fichier : ' . $file->getClientOriginalName());
            Log::info('Taille du fichier : ' . $file->getSize());
            Log::info('Extension du fichier : ' . $file->getClientOriginalExtension());

            $nomFichier = 'CV' . $candidat->nom . $candidat->prenom . '.' . $file->extension();
            $dossierPath = 'dossierClient/' . str_replace(' ', '', $candidat->nom) . str_replace(' ', '', $candidat->prenom) . $candidat->id;

            if (!file_exists(storage_path('app/public/' . $dossierPath))) {
                Log::info('Création du dossier : ' . $dossierPath);
                mkdir(storage_path('app/public/' . $dossierPath), 0755, true);
            } else {
                Log::info('Dossier déjà existant : ' . $dossierPath);
            }

            $dossier = Dossier::updateOrCreate(
                ['id_candidat' => $candidat->id],
                ['url' => $dossierPath, 'id_agent' => auth()->user()->id]
            );

            Log::info('Enregistrement du fichier dans le dossier : ' . $dossierPath);
            $file->storeAs('public/' . $dossierPath, $nomFichier);
            $cvPath = $dossierPath . '/' . $nomFichier;

            Log::info('Création d\'un enregistrement pour le document.');
            Document::create([
                'id_dossier' => $dossier->id,
                'nom' => 'CV',
                'url' => $cvPath,
            ]);
        } else {
            Log::error('Le fichier CV n\'est pas valide.');
        }
    } else {
        Log::info('Aucun fichier CV téléchargé.');
    }

    Log::info('Fin du traitement du CV. Chemin CV: ' . $cvPath);
    return $cvPath;
}

    
    
    
    private function updateFicheConsultation(Request $request, $candidat, $cvPath)
    {
        $entreeExistante = Entree::where('id_candidat', $candidat->id)->where('id_type_paiement', 2)->first();

        $cvPath = $cvPath ?? '';

        if ($candidat->consultation_payee || $entreeExistante) {
            FicheConsultation::updateOrCreate(
                ['id_candidat' => $candidat->id],
                [
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
                    'reponse27' => $request->input('reponse27'),
                    'reponse28' => $request->input('reponse28'),
                    'reponse29' => $request->input('reponse29'),
                ]
            );

            if ($candidat->consultation_payee && !$entreeExistante) {
                $montant = (auth()->user()->id_succursale == 4) ? 100 : 50000;

                Entree::create([
                    'id_candidat' => $candidat->id,
                    'montant' => $montant,
                    'date' => now(),
                    'id_utilisateur' => auth()->id(),
                    'id_type_paiement' => 2,
                ]);
            }
        } else {
            Entree::where('id_candidat', $candidat->id)->delete();
            FicheConsultation::where('id_candidat', $candidat->id)->delete();
        }
    }

    public function ModifierDateConsultation(Request $request, $candidatId)
    {
        try {
            Carbon::setLocale('fr');
            // Récupérer les données du formulaire
            $consultationId = $request->input('consultation_id');
            $consultation = InfoConsultation::find($consultationId);

            $dateConsultation = Carbon::parse($consultation->date_heure)->translatedFormat('l j F ');
            $heureConsultation = Carbon::parse($consultation->date_heure)->translatedFormat('H:i');

            $candidat = Candidat::find($candidatId);

            $nom = $candidat->nom;
            $prenom = $candidat->prenom;

            $firstTime = $candidat->id_info_consultation == null;

            // Mettre à jour l'ID de consultation du candidat
            Candidat::where('id', $candidatId)->update(['id_info_consultation' => $consultationId]);

            // Envoyer une notification par e-mail
            Notification::route('mail', $candidat->email)->notify(new DateConsultationNotification($nom, $prenom, $firstTime, $dateConsultation, $heureConsultation, $consultation->lien_zoom));

            // Retourner une réponse JSON avec un message de succès
            return response()->json(['success' => true, 'message' => 'Consultation mise à jour avec succès']);
        } catch (\Exception $e) {
            // Retourner une réponse JSON avec un message d'erreur en cas d'exception
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function getDossierDocuments($clientId)
    {
        $candidat = Candidat::find($clientId);

        if (!$candidat) {
            // Gérer le cas où le candidat n'est pas trouvé
            abort(404, 'Candidat non trouvé');
        }

        $dossierPath = storage_path('app/public/dossierClient/' . substr($candidat->nom, 0, 2) . substr($candidat->prenom, 0, 1) . $candidat->id);
        $files = glob($dossierPath . '/*');

        $documents = [];

        foreach ($files as $file) {
            $documents[] = [
                'url' => asset('storage/' . str_replace(storage_path('app/public'), '', $file)),
                'name' => basename($file),
            ];
        }

        // Passer les données du candidat et les documents à la vue
        return view('Administratif.Partials.VoirDocuments', compact('candidat', 'documents'));
    }

    public function allClient()
    {
        // Récupérer l'id de la succursale de l'utilisateur en cours
        $idSuccursaleUtilisateur = auth()->user()->id_succursale;

        // Récupérer la liste des entrees de type 2 liées à la succursale de l'utilisateur
        $entreesType2 = Entree::with('utilisateur')
            ->where('id_type_paiement', 2)
            ->whereHas('utilisateur', function ($query) use ($idSuccursaleUtilisateur) {
                $query->where('id_succursale', $idSuccursaleUtilisateur);
            })
            ->get();

        // Récupérer les candidats liés à ces entrées
        $candidats = Candidat::whereIn('id', $entreesType2->pluck('id_candidat'))->get();

        // Créer un tableau associatif pour stocker la date de paiement correspondante à chaque candidat
        $datesPaiement = $entreesType2->pluck('date', 'id_candidat')->all();

        // Trier les candidats par date de paiement (de la plus récente à la plus ancienne)
        $candidats = $candidats->sortByDesc(function ($candidat) use ($datesPaiement) {
            return $datesPaiement[$candidat->id];
        });


        return ['data_client' => $candidats, 'dates_paiement' => $datesPaiement];
    }

    public function DossierClients()
    {
        // Appeler la fonction allClient pour récupérer les données
        $donneesClients = $this->allClient();

        // Utiliser la méthode view pour rendre la vue avec les données
        return view('Administratif.Views.DossierClients', $donneesClients);
    }

    public function Banque()
    {
        $utilisateurConnecte = Auth::user();
        // Vérifie si le poste de l'utilisateur est 134 ou 5
        $hasPoste = in_array($utilisateurConnecte->id_poste_occupe, [3, 5]);
        $entries = Entree::where('id_utilisateur', $utilisateurConnecte->id)
            ->orderBy('date', 'desc')
            ->get();
        $entreeMensuelData = $this->entreeMensuel();
        // Définir $moisEnCours
        $moisEnCours = $entreeMensuelData['moisEnCours'];

        $entreeMensuelSuccursale = Entree::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('montant');

        $depenseMensuelSuccursale = Depense::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('montant');

        $devise = $this->devise();


        $transactionController = new Controller();
        $transactions = $transactionController->getAllTransactions($utilisateurConnecte->id);

        // Passe la variable $hasPoste à la vue
        return view('Administratif.Views.Banque', compact('entries', 'hasPoste', 'moisEnCours', 'entreeMensuelSuccursale', 'devise', 'depenseMensuelSuccursale', 'transactions'));
    }

    public function Consultation()
    {
        Carbon::setLocale('fr');
        $consultations = InfoConsultation::orderBy('date_heure', 'desc')->get();
        foreach ($consultations as $consultation) {
            $formattedDate = Carbon::parse($consultation->date_heure)->translatedFormat('l j F Y');
            $consultation->date_heure_formatee = ucwords($formattedDate);
        }
        return view('Administratif.Views.Consultation', compact('consultations'));
    }

    public function aucunVersement()
    {
        // Récupérez l'ID de l'utilisateur actuel
        $userId = Auth::id();

        // Utilisez Eloquent pour récupérer les candidats enregistrés par l'utilisateur actuel
        $candidats = Candidat::where('id_utilisateur', $userId)
            ->whereDoesntHave('entrees', function ($query) {
                // Filtrez les candidats qui n'ont pas d'entrées de type 2 (consultation)
                $query->where('type_entree', 2);
            })
            ->get();

        return $candidats;
    }


    public function ModifierTypeVisa(Request $request, $candidatId)
    {
        try {
            // Validez l'existence du candidat
            $candidat = Candidat::find($candidatId);
            if (!$candidat) {
                Log::error("Candidat introuvable avec l'ID : $candidatId");
                return response()->json(['success' => false, 'message' => 'Candidat introuvable.'], 404);
            }

            // Récupérez les valeurs du formulaire
            $typeProcedureId = $request->input('type_procedure');
            $statutId = $request->input('statut_id');
            $consultanteId = $request->input('consultante_id');

            // Log des valeurs récupérées
            Log::info("Valeurs récupérées - typeProcedureId: $typeProcedureId, statutId: $statutId, consultanteId: $consultanteId");

            // Recherchez une procédure existante pour le candidat
            $procedure = Procedure::where('id_candidat', $candidatId)->first();
            $isNewProcedure = false;
            $isStatutChanged = false;

            // Si une procédure existe, vérifiez si le statut a changé
            if ($procedure) {
                if ($procedure->statut_id != $statutId) {
                    $isStatutChanged = true;
                    // Si le statut a changé, ne mettez à jour que le statut
                    $procedure->update(['statut_id' => $statutId]);
                } else {
                    // Si le statut n'a pas changé, mettez à jour tous les champs
                    $procedure->update([
                        'id_type_procedure' => $typeProcedureId,
                        'statut_id' => $statutId,
                        'consultante_id' => $consultanteId,
                    ]);
                }
                Log::info("Procédure mise à jour - ID procédure : " . $procedure->id);
            } else {
                // Si une procédure n'existe pas, créez une nouvelle procédure
                $procedure = new Procedure([
                    'id_candidat' => $candidatId,
                    'id_type_procedure' => $typeProcedureId,
                    'statut_id' => $statutId,
                    'consultante_id' => $consultanteId,
                    'tag_id' => 1,
                ]);
                $procedure->save();
                $isNewProcedure = true;
                Log::info("Nouvelle procédure créée - ID procédure : " . $procedure->id);
            }

            // Get the status label
            $statut = StatutProcedure::find($statutId);
            $statutLabel = $statut ? $statut->label : '';

            // Send notifications
            if ($isNewProcedure) {
                $nom = $candidat->nom;
                $prenom = $candidat->prenom;
                Notification::route('mail', $candidat->email)->notify(new ProcedureCreatedNotifications($nom, $prenom));
            } else if ($isStatutChanged) {
                Notification::route('mail', $candidat->email)->notify(new StatutNotifications($statutLabel));
            }

            return response()->json(['success' => true, 'message' => 'Procédure enregistrée avec succès.'], 200);
        } catch (\Exception $e) {
            // Gérez les erreurs, par exemple, en les enregistrant ou en les affichant à l'utilisateur
            Log::error('Erreur lors de l\'enregistrement de la procédure : ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Une erreur est survenue lors de l\'enregistrement de la procédure.'], 500);
        }
    }
}
