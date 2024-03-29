<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\ModelNotFoundException; // Add this line

use Carbon\Carbon;
use App\Models\Candidat;
use Illuminate\Support\Facades\Auth;
use App\Models\RendezVous;

class CommercialController extends Controller
{


    public function Dashboard()
    {
        $appels = $this->appelCount();
        $visite = $this->visiteCount();
        $consultations = $this->consultationPayeeCount();
        $rendezVous = $this->rendezVousAujourdhui();
    
        // Fusionner les quatre tableaux en un seul
        $data = array_merge($appels, $visite, $consultations, compact('rendezVous'));
    
        return view('Commercial.Views.Dashboard', $data);
    }
    
    private function appelCount()
    {
        Carbon::setLocale('fr');
        $jourActuel = Carbon::now()->translatedFormat('d F Y');
        $moisActuel = Carbon::now()->monthName;

        // Récupère l'utilisateur connecté
        $utilisateurConnecte = auth()->user();

        // Calcule le nombre de candidats de l'utilisateur dans le jour actuel
        $totalAppelDeCeJour = Candidat::whereDay('date_enregistrement', Carbon::now()->day)
            ->whereMonth('date_enregistrement', Carbon::now()->month)
            ->whereYear('date_enregistrement', Carbon::now()->year)
            ->whereHas('utilisateur', function ($query) use ($utilisateurConnecte) {
                $query->where('id', $utilisateurConnecte->id);
            })
            ->count();

        return compact('totalAppelDeCeJour', 'jourActuel', 'moisActuel');
    }

    private function visiteCount()
    {
        // Récupère l'utilisateur connecté
        $utilisateurConnecte = auth()->user();

        // Calcule le nombre de candidats de l'utilisateur avec une date de rendez-vous non vide pour le mois et l'année actuels
        $totalVisiteAujourdhui = Candidat::where('id_utilisateur', $utilisateurConnecte->id)
        ->whereNotNull('date_rdv')
        ->whereDate('date_rdv', Carbon::now())  
        ->count();
    
        return compact('totalVisiteAujourdhui');
    }

    private function consultationPayeeCount()
    {
        // Récupère l'utilisateur connecté
        $utilisateurConnecte = auth()->user();

        // Obtenez le mois et l'année actuels
        $moisActuel = Carbon::now()->month;
        $anneeActuelle = Carbon::now()->year;

        // Calcule le nombre de consultations payées de l'utilisateur pour le mois et l'année actuels
        $totalConsultationsDeCeMois = RendezVous::where('consultation_payee', true)
            ->whereMonth('date_rdv', $moisActuel)
            ->whereYear('date_rdv', $anneeActuelle)
            ->where('commercial_id', $utilisateurConnecte->id)
            ->count();

        return compact('totalConsultationsDeCeMois');
    }

    public function rendezVousAujourdhui()
    {
        // Obtenir l'utilisateur connecté
        $idUtilisateur = auth()->user()->id;
    
        // Obtenir les candidats enregistrés par l'utilisateur connecté avec une date de rendez-vous aujourd'hui
        $candidats = Candidat::where('id_utilisateur', $idUtilisateur)
            ->whereDate('date_rdv', Carbon::today())
            ->orderBy('date_enregistrement', 'desc')
            ->get();

        return $candidats;
     
    }

    public function appelChartData()
    {
        // Obtenez l'utilisateur connecté
        $utilisateurConnecte = Auth::user();

        // Obtenez la date de début et de fin de la semaine actuelle
        $debutSemaine = Carbon::now()->locale('fr')->startOfWeek();
        $finSemaine = Carbon::now()->locale('fr')->endOfWeek();

        // Récupérez les données de la base de données pour la semaine actuelle
        $data = Candidat::whereBetween('date_enregistrement', [$debutSemaine, $finSemaine])
            ->whereHas('utilisateur', function ($query) use ($utilisateurConnecte) {
                // Filtrer par l'id de succursale de l'utilisateur connecté
                $query->where('id_succursale', $utilisateurConnecte->id_succursale);
            })
            ->selectRaw('DATE_FORMAT(date_enregistrement, "%W") as jour_semaine, COUNT(*) as nombre_visites')
            ->groupBy('jour_semaine')
            ->get();

        // Convertir les noms des jours en français
        $jours = ['Monday' => 'Lundi', 'Tuesday' => 'Mardi', 'Wednesday' => 'Mercredi', 'Thursday' => 'Jeudi', 'Friday' => 'Vendredi', 'Saturday' => 'Samedi', 'Sunday' => 'Dimanche'];
        $data->transform(function ($item, $key) use ($jours) {
            $item->jour_semaine = $jours[$item->jour_semaine];
            return $item;
        });

        // Retournez les données au format JSON
        return response()->json($data);
    }

    public function consultationChartData()
    {
        // Obtenez l'utilisateur connecté
        $utilisateurConnecte = Auth::user();
    
        // Obtenez l'année actuelle
        $currentYear = Carbon::now()->year;
    
        // Récupérez les données de la base de données pour l'année actuelle
        $data = RendezVous::whereYear('date_rdv', $currentYear)
            ->where('consultation_payee', 1) // Assurez-vous que le type de paiement correspond à celui que vous utilisez
            ->where('commercial_id', $utilisateurConnecte->id)
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
            return Carbon::parse($entry->date_rdv)->format('M'); // Utilisez la colonne correcte ici (date_rdv)
        });
    
        // Bouclez à travers les données groupées et formatez-les
        foreach ($groupedData as $month => $entries) {
            $formattedData[] = [
                'month' => $month,
                'count' => count($entries),
            ];
        }
    
        // Retournez les données formatées
        return $formattedData;
    }
    

    public function contactSuccursalle()
    {
        // Obtenir l'utilisateur connecté
        $idSuccursaleUtilisateur = auth()->user()->id_succursale;

        // Obtenir les données des candidats liés à la succursale de l'utilisateur
        $candidats = Candidat::whereHas('utilisateur', function ($query) use ($idSuccursaleUtilisateur) {
            $query->where('id_succursale', $idSuccursaleUtilisateur);
        })
            ->orderBy('date_enregistrement', 'desc')
            ->get();

        return $candidats;
    }

    public function Contacts()
    {
        $candidatsSuccursalle = $this->contactSuccursalle();

        // Pass the data to the main view
        return view('Commercial.Views.Contacts', ['data_candidat' => $candidatsSuccursalle]);
    }

    public function addProspect(Request $request, $id = null)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'pays' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'numero_telephone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'profession' => 'required|string|max:255',
            'date_rdv' => 'nullable|date',
        ]);

            $data = [
            'nom' => ucwords(strtolower($validatedData['nom'])),
            'prenom' => ucwords(strtolower($validatedData['prenoms'])),
            'pays' => ucwords(strtolower($validatedData['pays'])),
            'ville' => ucwords(strtolower($validatedData['ville'])),
            'numero_telephone' => $validatedData['numero_telephone'],
            'email' => $validatedData['email'],
            'profession' => ucwords(strtolower($validatedData['profession'])),
                'consultation_payee' => $request->has('consultation_payee'),
                'id_utilisateur' => Auth::id(),
          'date_rdv' => $request->has('date_rdv') ? $validatedData['date_rdv'] : null,
            ];

            try {
            $candidat = $id ? Candidat::findOrFail($id) : new Candidat;
            $candidat->fill($data);
            $candidat->save();
            
            if ($request->filled('date_rdv')) {
                $rendezVousData = [
                    'date_rdv' => $validatedData['date_rdv'],
                    'candidat_id' => $candidat->id,
                    'commercial_id' => Auth::id(),
                ];
        
                $rendezVous = RendezVous::firstOrNew(['candidat_id' => $candidat->id]);
                $rendezVous->fill($rendezVousData);
                $rendezVous->save();
            }

            $message = $id ? 'Prospect updated successfully.' : 'Prospect added successfully.';
            return redirect()->route('Commercial.Contacts')->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred.'])->withInput();
        }
    }

    public function allCandiatWithRendezVous()
    {
         // Obtenir l'utilisateur connecté
         $idSuccursaleUtilisateur = auth()->user()->id_succursale;

         // Obtenir les données des candidats liés à la succursale de l'utilisateur
         $candidats = Candidat::whereHas('utilisateur', function ($query) use ($idSuccursaleUtilisateur) {
             $query->where('id_succursale', $idSuccursaleUtilisateur);
         })-> whereNotNull('date_rdv')
            ->orderBy('date_rdv', 'desc')
            ->get();
    
        return $candidats;
    }
     
    public function rendezVous()
    {
        $candidats = $this->allCandiatWithRendezVous();
        return view('Commercial.Views.RendezVous', compact('candidats'));
    }

    public function changeStatutConsultationPayee($id, $statut)
    {
        try {
            $rendezVous = RendezVous::findOrFail($id);
            $rendezVous->consultation_payee = ($statut === 'yes');
            $rendezVous->save();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Consultation status changed successfully.'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'RendezVous with ID ' . $id . ' not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while changing the consultation status.'
            ], 500);
        }
    }
    
    public function changeStatutRendezVous($id, $statut)
    {
        try {
            $rendezVous = RendezVous::findOrFail($id);
            $rendezVous->rdv_effectue = ($statut === 'yes');
            $rendezVous->save();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Consultation status changed successfully.'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'RendezVous with ID ' . $id . ' not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while changing the consultation status.'
            ], 500);
        }
    }
    

     
    
}
