<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Document;
use App\Models\Dossier;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Illuminate\Support\Facades\Auth;
use App\Models\Entree;
use App\Models\FicheConsultation;
use App\Models\RendezVous;
use Carbon\Carbon;
use App\Models\InfoConsultation;

class AdministratifController extends Controller
{
    //Ramene la page principale avec les données necessaire
    public function Dashboard()
    {
        $caisseMensuelData = $this->caisseMensuel();
        $devise = $this->devise();
        $nombreConsultationData = $this->nombreConsultationMensuel();
        $nombreVersementData = $this->nombreVersementMensuel();
        $consultations = $this->prochaineConsultation();


        return view('Administratif.Views.Dashboard', [
            'caisseMensuel' => $caisseMensuelData['caisseMensuel'],
            'moisEnCours' => $caisseMensuelData['moisEnCours'],
            'devise' => $devise,
            'nombreConsultationMensuel' => $nombreConsultationData['nombreConsultationMensuel'],
            'nombreVersementMensuel' => $nombreVersementData['nombreVersementMensuel'],
            'consultations' => $consultations,

        ]);
    }
    //Ramene le montant du mois pour l'utilisateur connecté
    private function caisseMensuel()
    {
        Carbon::setLocale('fr');
        $moisEnCours = Carbon::now()->monthName;

        // Calculez la somme des entrées pour le mois actuel et l'année actuelle en utilisant le modèle Entree
        $caisseMensuel = Entree::where('id_utilisateur', auth()->user()->id)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('montant');

        return ['caisseMensuel' => $caisseMensuel, 'moisEnCours' => $moisEnCours];
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
        if ($succursaleId === 3) {
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
        $consultations = InfoConsultation::latest('date_heure')->take(3)->get();

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
        $consultations = InfoConsultation::where('nombre_candidats', '>', function ($query) {
            $query->selectRaw('count(*)')
                ->from('candidat')
                ->whereColumn('info_consultation.id', 'candidat.id_info_consultation');
        })->get();

        $consultations->transform(function ($consultation) {
            $dateFormatee = Carbon::parse($consultation->date_heure)->format('l j F Y H:i');
            $consultation->dateFormatee = ucwords($dateFormatee);

            return $consultation;
        });

        return $consultations;
    }

    // public function CreerOuModifierFiche(Request $request, $idCandidat)
    // {
    //     try {
    //         // Validation du formulaire
    //         $validatedData = $this->validateForm($request);


    //         // Récupération de l'ID de l'utilisateur connecté
    //         $idUtilisateur = Auth::id();
    //         // 200$ pour le LA RDC et 100 000F pour les autres succursales
    //         $montant = auth()->user()->id_succursale == 3 ? 200 : 100000;

    //         // Récupération du candidat à modifier
    //         $candidat = Candidat::findOrFail($idCandidat);

    //         // Modification des informations du candidat
    //         $this->updateCandidat($request, $candidat, $idUtilisateur);

    //         // Mise à jour du dossier
    //         $dossierPath = $this->updateDossier($candidat);

    //         // Traitement du nouveau fichier CV s'il est présent et valide
    //         $cvPath = $this->handleCV($request, $candidat, $dossierPath);

    //         // Si la consultation est payée, mettez à jour ou créez une entrée et une fiche de consultation
    //         $this->handleConsultation($request, $candidat, $idUtilisateur, $montant, $cvPath);

    //         // Redirection vers dossier contact avec un message de succès
    //         return redirect()->back()->with('success', 'Formulaire modifié avec succès.');
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         // Gérer les erreurs de validation
    //         return redirect()->back()->withErrors($e->errors())->withInput();
    //     } catch (\Exception $e) {
    //         // Gérer les autres exceptions
    //         return redirect()->back()->withErrors(['error' => 'Une erreur inattendue s\'est produite.'])->withInput();
    //     }
    // }

    // private function validateForm(Request $request)
    // {
    //     return $request->validate([
    //         'nom' => 'required|string|max:255',
    //         'prenoms' => 'required|string|max:255',
    //         'pays' => 'required|string|max:255',
    //         'ville' => 'required|string|max:255',
    //         'numero_telephone' => 'required|string|max:20',
    //         'email' => 'required|email|max:255',
    //         'profession' => 'required|string|max:255',
    //     ]);
    // }

    // private function updateCandidat(Request $request, $candidat, $idUtilisateur)
    // {
    //     $candidat->updateOrCreate([
    //         'nom' => ucwords(strtolower($request->input('nom'))),
    //         'prenom' => ucwords(strtolower($request->input('prenoms'))),
    //         'pays' => ucwords(strtolower($request->input('pays'))),
    //         'ville' => ucwords(strtolower($request->input('ville'))),
    //         'numero_telephone' => $request->input('numero_telephone'),
    //         'email' => $request->input('email'),
    //         'profession' => ucwords(strtolower($request->input('profession'))),
    //         'consultation_payee' => $request->has('consultation_payee'),
    //         'id_utilisateur' => $idUtilisateur,
    //         'date_naissance' => $request->input('date_naissance'),
    //         'remarque_agent' => $request->has('consultation_payee') ? $request->input('remarques') : 0,
    //     ]);
    // }

    // private function updateDossier($candidat)
    // {
    //     $dossierPath = 'dossierClient/' . $candidat->nom . $candidat->prenom . $candidat->id;

    //     Dossier::updateOrCreate(
    //         [
    //             'id_candidat' => $candidat->id,
    //         ],
    //         [
    //             'url' =>  $dossierPath,
    //             'id_agent' => auth()->user()->id,
    //         ]
    //     );

    //     return $dossierPath;
    // }

    // private function handleCV(Request $request, $candidat, $dossierPath)
    // {
    //     $cvPath = $candidat->ficheConsultation->lien_cv ?? null;

    //     if ($request->hasFile('cv') && $request->file('cv')->isValid()) {
    //         $cvPath = $this->storeCV($request, $dossierPath, $candidat);
    //     }

    //     return $cvPath;
    // }

    // private function storeCV(Request $request, $dossierPath, $candidat)
    // {
    //     $fileName = 'CV' . $candidat->nom .  $candidat->prenom . '.' . $request->file('cv')->extension();
    //     $directoryPath = storage_path('app/public/' . $dossierPath);

    //     if (!file_exists($directoryPath)) {
    //         mkdir($directoryPath, 0755, true);
    //     }

    //     $request->file('cv')->storeAs($dossierPath, $fileName);

    //     return 'public/' . $dossierPath . '/' . $fileName;
    // }

    // private function handleConsultation($request, $candidat, $idUtilisateur, $montant, $cvPath)
    // {
    //     if ($candidat->consultation_payee) {
    //         $this->handlePaidConsultation($request, $candidat, $idUtilisateur, $montant, $cvPath);
    //     } else {
    //         $this->handleUnpaidConsultation($candidat);
    //     }
    // }

    // private function handlePaidConsultation($request, $candidat, $idUtilisateur, $montant, $cvPath)
    // {
    //     // Mettez à jour ou créez une entrée
    //     Entree::updateOrCreate(
    //         ['id_candidat' => $candidat->id],
    //         [
    //             'montant' => $montant,
    //             'date' => now(),
    //             'id_utilisateur' => $idUtilisateur,
    //             'id_type_paiement' => 2,
    //         ]
    //     );

    //     // Mettez à jour ou créez une fiche de consultation
    //     FicheConsultation::updateOrCreate(
    //         [
    //             'id_candidat' => $candidat->id,
    //         ],
    //         [
    //             'lien_cv' => $cvPath,
    //             'type_visa' => $request->input('type_visa'),
    //             'reponse1' => $request->input('statut_matrimonial'),
    //             'reponse2' => $request->input('passeport_valide'),
    //             'reponse3' => $request->input('passeport_valide') == 'oui' ? $request->input('date_expiration_passeport') : 'Pas de Passeport valide',
    //             'reponse4' => $request->input('casier_judiciaire'),
    //             'reponse5' => $request->input('soucis_sante'),
    //             'reponse6' => $request->input('enfants'),
    //             'reponse7' => $request->input('enfants') == 'oui' ? $request->input('age_enfants') : "Pas d'enfant",
    //             'reponse8' => $request->input('profession_domaine_travail'),
    //             'reponse9' => $request->input('temps_travail_actuel'),
    //             'reponse10' => $request->input('documents_emploi'),
    //             'reponse11' => $request->input('procedure_immigration'),
    //             'reponse12' => $request->input('procedure_immigration') == 'oui' ? $request->input('questions-procedure-immigration1') : 'Pas de procedure deja tentee',
    //             'reponse13' => $request->input('procedure_immigration') == 'oui' ? $request->input('questions-procedure-immigration2') : 'Pas de procedure deja tentee',
    //             'reponse14' => $request->input('diplome_etudes'),
    //             'reponse15' => $request->input('annee_obtention_diplome'),
    //             'reponse16' => $request->input('membre_famille_canada'),
    //             'reponse17' => $request->input('immigrer_seul_ou_famille'),
    //             'reponse18' => $request->input('langues_parlees'),
    //             'reponse19' => $request->input('test_connaissances_linguistiques'),
    //             'reponse20' => $request->input('niveau_scolarite_conjoint'),
    //             'reponse21' => $request->input('domaine_formation_conjoint'),
    //             'reponse22' => $request->input('age_conjoint'),
    //             'reponse23' => $request->input('niveau_francais'),
    //             'reponse24' => $request->input('niveau_anglais'),
    //             'reponse25' => $request->input('age_enfants_linguistique'),
    //             'reponse26' => $request->input('niveau_scolarite_enfants'),
    //         ]
    //     );
    // }

    // private function handleUnpaidConsultation($candidat)
    // {
    //     // Si la consultation n'est pas payée, vérifiez s'il existe une entrée et supprimez-la
    //     Entree::where('id_candidat', $candidat->id)->delete();

    //     // Supprimez également la fiche de consultation s'il en existe une
    //     FicheConsultation::where('id_candidat', $candidat->id)->delete();
    // }

    public function CreerOuModifierFiche(Request $request, $idCandidat)
    {
        try {
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

            // Récupération de l'ID de l'utilisateur connecté
            $idUtilisateur = Auth::id();

            // Récupération du candidat à modifier
            $candidat = Candidat::findOrFail($idCandidat);

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

            // Récupération du chemin du CV existant
            $cvPath = $candidat->ficheConsultation->lien_cv ?? null;

            // Traitement du nouveau fichier CV s'il est présent et valide
            if ($request->hasFile('cv') && $request->file('cv')->isValid()) {
                // Générez un nom de fichier unique (par exemple, en utilisant le timestamp)
                $nomFichier = 'CV' . $candidat->nom .  $candidat->prenom . '.' . $request->file('cv')->extension();

                //NOM+PRENOMS+ID
                $dossierPath = 'dossierClient/' . $candidat->nom . $candidat->prenom . $candidat->id;

                if (!file_exists(storage_path('app/public/' . $dossierPath))) {
                    mkdir(storage_path('app/public/' . $dossierPath), 0755, true);
                }

                $dossier = Dossier::updateOrCreate(
                    [
                        'id_candidat' => $candidat->id,
                    ],
                    [
                        'url' => $dossierPath,
                        'id_agent' => auth()->user()->id,
                    ]
                );

                // Enregistrez le CV dans le dossier spécifique du candidat avec un nom de fichier unique
                $request->file('cv')->storeAs('public/' . $dossierPath, $nomFichier);

                // Mettez à jour le chemin du CV dans la base de données
                $cvPath = 'public/' . $dossierPath . '/' . $nomFichier;

                // Ajoutez un document associé à ce dossier
                Document::create([
                    'id_dossier' => $dossier->id,
                    'nom' => 'CV',
                    'url' => $cvPath,
                ]);

                       }


            // Si la consultation est payée, mettez à jour ou créez une entrée et une fiche de consultation
            if ($candidat->consultation_payee) {
                $entree = Entree::updateOrCreate(
                    ['id_candidat' => $candidat->id],
                    [
                        'montant' => 50000,
                        'date' => now(),
                        'id_utilisateur' => $idUtilisateur,
                        'id_type_paiement' => 2,
                    ]
                );

                FicheConsultation::updateOrCreate(
                    [
                        'id_candidat' => $candidat->id,
                    ],
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
                    ]
                );
            } else {
                // Si la consultation n'est pas payée, vérifiez s'il existe une entrée et supprimez-la
                Entree::where('id_candidat', $candidat->id)->delete();

                // Supprimez également la fiche de consultation s'il en existe une
                FicheConsultation::where('id_candidat', $candidat->id)->delete();
            }

            // Redirection vers dossier contact avec un message de succès
            return redirect()->back()->with('success', 'Formulaire modifié avec succès.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Gérer les erreurs de validation
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Gérer les autres exceptions
            return redirect()->back()->withErrors(['error' => 'Une erreur inattendue s\'est produite.'])->withInput();
        }
    }

    public function ModifierDateConsultation(Request $request, $candidatId)
    {
        // Récupérer les données du formulaire
        $consultationId = $request->input('consultation_id');

        // Mettre à jour le champ id_info_consultation du candidat
        Candidat::where('id', $candidatId)->update(['id_info_consultation' => $consultationId]);

        // Rediriger ou retourner la réponse en fonction de vos besoins
        return redirect()->back()->with('success', 'Consultation mise à jour avec succès');
    }

    public function allClient()
    {
        // Récupérer l'id de la succursale de l'utilisateur en cours
        $idSuccursaleUtilisateur = auth()->user()->id_succursale;

        // Récupérer la liste des entrees de type 2 liées à la succursale de l'utilisateur
        $entreesType2 = Entree::where('id_type_paiement', 2)
            ->whereHas('utilisateur', function ($query) use ($idSuccursaleUtilisateur) {
                $query->where('id_succursale', $idSuccursaleUtilisateur);
            })
            ->get();

        // Récupérer les candidats liés à ces entrées
        $candidats = Candidat::whereIn('id', $entreesType2->pluck('id_candidat'))->get();

        // Créer un tableau associatif pour stocker la date de paiement correspondante à chaque candidat
        $datesPaiement = [];
        foreach ($entreesType2 as $entree) {
            $datesPaiement[$entree->id_candidat] = $entree->date;
        }

        // Trier les candidats par date de paiement (de la plus récente à la plus ancienne)
        $candidats = $candidats->sortByDesc(function ($candidat) use ($datesPaiement) {
            return $datesPaiement[$candidat->id];
        });

        // Pour chaque candidat, récupérer les documents du dossier
        foreach ($candidats as $candidat) {
            // Appeler la méthode getDossierDocuments pour récupérer les documents du dossier
            $documentsDossier = $this->getDossierDocuments($candidat->id);

            // Ajouter les documents du dossier à chaque candidat
            $candidat->documentsDossier = $documentsDossier['documents'];
        }

        return ['data_client' => $candidats, 'dates_paiement' => $datesPaiement];
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

        $entries = Entree::where('id_utilisateur', $utilisateurConnecte->id)
            ->orderBy('date', 'desc')
            ->get();

        return view('Administratif.Views.Banque', compact('entries'));
    }

    public function Consultation()
    {
        Carbon::setLocale('fr');
        $consultations = InfoConsultation::all();

        foreach ($consultations as $consultation) {
            $formattedDate = Carbon::parse($consultation->date_heure)->translatedFormat('l j F Y');
            $consultation->date_heure_formatee = ucwords($formattedDate);
        }

        return view('Administratif.Views.Consultation', compact('consultations'));
    }
}