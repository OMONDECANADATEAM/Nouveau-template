<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Candidat;
use App\Models\InfoConsultation;
use App\Models\Entree;
use App\Models\consultante;


class HomeController extends Controller
{

    public function index()
    {
        // Vérifiez si l'utilisateur est connecté
        if (Auth::check()) {
            // Obtenez le rôle de l'utilisateur
            $userRole = Auth::user()->id_role_utilisateur;
    
            // Redirigez l'utilisateur en fonction de son rôle
            switch ($userRole) {
                case 0:
                    // Consultante, redirigez-la vers la page "OmondeTeam"
                    return redirect()->route('dashBoardConsultante');
                case 1:
                case 2:
                case 3:
                    // Utilisateur simple, redirigez-le vers la page "home"
                    return view('Dashboard.home');
                default:
                    // Si le rôle n'est pas reconnu, redirigez-le vers la page de connexion
                    return redirect()->route('login');
            }
        }
    
        // Si l'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
        return redirect()->route('login');
    }
    
    
    public function DossierContacts()
    {
        return view('Contact.DossierContacts');
    }
    public function DossierClients()
    {
        return view('DossierClients');
    }
    public function Banque()
    {
        return view('Banque');
    }
   
    public function Consultation()
    {
        return view('Consultation');
    }
    public function dashBoardConsultante()
    {
        return view('dashBoardConsultante');
    }

    public function adminDashboard()
    {
        return view('adminDashboard');
    }

    public function connexion()
    {
        return view('Connexion.connexionPage');
    }

    public function dossier()
    {
        return view('dossier');
    }
    public function equipeView()
    {
        return view('Team');
    }
    public function documentAgent()
    {
        return view('documentAgent');
    }

    public function allCandidat()
    {
        // Obtenir l'utilisateur connecté
        $idSuccursaleUtilisateur = auth()->user()->id_succursale;
    
            // Obtenir les données des candidats liés à la succursale de l'utilisateur
            $candidats = Candidat::whereHas('utilisateur', function ($query) use ($idSuccursaleUtilisateur) {
                $query->where('id_succursale', $idSuccursaleUtilisateur);
            })
            ->orderBy('date_enregistrement', 'desc')
            ->get();
    
            // Passer les données à la vue principale
            return view('Contact.DossierContacts', ['data_candidat' => $candidats]);
     
    }
    

 
    
    public function allClient() {
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
    
        return view('DossierClients', ['data_client' => $candidats, 'dates_paiement' => $datesPaiement]);
    }
    


 
    public function listeConsultantes()
    {
        
        $consultantes = Consultante::all();

        return view('Consultation', ['data_consultante' => $consultantes]);
    }


    public function saveRemarques(Request $request)
    {
        $candidatId = $request->input('candidatId');
        $remarques = $request->input('remarques');

        $candidat = Candidat::find($candidatId);
        if ($candidat) {
            $candidat->remarque_consultante = $remarques;
            $candidat->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }


    public function getListCandidatByConsultation($id)
    {
        // Récupérer la consultation par son ID
        $info_consultation = InfoConsultation::find($id);

        // Récupérer la liste des consultations liées (exemple : consultations du même patient)
        $consultationsList = Candidat::where('id_info_consultation', $info_consultation->id)
            ->get();

        return view('listcandidats', compact('info_consultation', 'consultationsList'));
    }

    public function getCandidatByConsultation($id, $id_candidat)
    {
        // Récupérer la consultation par son ID
        $info_consultation = InfoConsultation::find($id);
        $consultation = Candidat::find($id_candidat);

        // Récupérer la liste des consultations liées (exemple : consultations du même patient)
        
            return view('candidat', compact('info_consultation', 'consultation'));
       
    }

    public function getCandidatFiche($id_candidat)
    {

        $consultation = Candidat::find($id_candidat);

        // Récupérer la liste des consultations liées (exemple : consultations du même patient)
        
            return view('ficheConsultation', compact('consultation'));
       
    }

   
}
