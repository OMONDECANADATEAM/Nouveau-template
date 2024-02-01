<?php

use App\Http\Controllers\CommercialController;
use App\Http\Controllers\DossierController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\EntreeController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\consultationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\chartController;
use App\Http\Controllers\ConsultanteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('Connexion.connexionPage');
});

// web.php

//Route Qui Ramene la page d'acceuil
Route::get('Dashboard', [HomeController::class, 'index'])->name('Dashboard');


//Routes Commercial
Route::get('/Commercial/Dashboard', [CommercialController::class, 'Dashboard'])->name('Commercial.Dashboard');
    //Route Chart Dashboard Commercial
Route::get('/Commercial/AppelsChart', [CommercialController::class, 'appelChartData']);
Route::get('/Commercial/ConsultationsChart', [CommercialController::class, 'consultationChartData']);
    //Route Dossier Contacts Commercial
Route::get('/Commercial/Contacts', [CommercialController::class, 'Contacts'])->name('Commercial.Contact');
Route::post('/Commercial/Contacts/AjouterProspect', [CommercialController::class, 'addProspect'])->name('Commercial.AddProspect');
Route::put('/Commercial/Contacts/ModifierProspect/{id}', [CommercialController::class, 'addProspect'])->name('Commercial.ModifierProspect');
     //Route Rendez Vous
Route::get('/Commercial/RendezVous', [CommercialController::class, 'RendezVous'])->name('Commercial.RendezVous');

Route::get('/Commercial/RendezVous/ConsultationPayee/{id}/{statut}', [CommercialController::class, 'changeStatutConsultationPayee'])->name('Commercial.ChangeStatutConsultation');
Route::get('/Commercial/RendezVous/RendezVousEffectue/{id}/{statut}', [CommercialController::class, 'changeStatutRendezVous'])->name('Commercial.ChangeStatutRendezVous');




Route::post('ajoutDepense', [DepenseController::class, 'ajoutDepense'])->name('ajoutDepense');
Route::post('Banque', [EntreeController::class, 'ajoutEntree'])->name('ajoutEntree');
Route::get('Banque', [HomeController::class, 'Banque'])->name('Banque');
Route::get('DossierClients', [HomeController::class, 'allClient'])->name('DossierClients');
Route::get('DossierContacts', [HomeController::class, 'allCandidat'])->name('DossierContacts');
Route::get('Consultation', [consultationController::class, 'listeConsultantes'])->name('Consultation');
Route::get('dashBoardConsultante', [HomeController::class, 'dashBoardConsultante'])->name('dashBoardConsultante');
Route::get('equipeView', [HomeController::class, 'equipeView'])->name('equipeView');
Route::get('documentAgent', [HomeController::class, 'documentAgent'])->name('documentAgent');


// Routes d'authentification
Route::get('connexion', [AuthController::class, 'showLoginForm'])->name('connexion.form');
Route::post('connexion', [AuthController::class, 'login'])->name('login');
Route::get('sign-in', [HomeController::class, 'sign-in'])->name('sign-in');
Route::get('adminDashboard', [HomeController::class, 'adminDashboard'])->name('adminDashboard');
Route::get('prochainesConsultations', [HomeController::class, 'prochainesConsultations'])->name('prochainesConsultations');

Route::get('virtual-reality', [HomeController::class, 'virtual-reality'])->name('virtual-reality');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


//
Route::put('/modifierContact/{id}', [Controller::class, 'modifierFormulaire'])->name('modifierContact');
Route::post('DossierContacts', [Controller::class, 'soumettreFormulaire'])->name('ajoutContact');

//Chart routes et controller



//
Route::post('Consultation', [Controller::class, 'ajoutConsultation'])->name('ajoutConsultation');


// Exemple de route dans votre fichier web.php
Route::get('/recherche-candidat', [Controller::class , 'rechercheCandidat'])->name('rechercheCandidat');
Route::get('/Consultation/{id}', [ConsultanteController::class , 'getListCandidatByConsultation'])->name('listcandidats');
Route::get('/Consultation/{id}/{id_candidat}', [ConsultanteController::class , 'getCandidatByConsultation'])->name('candidat');


Route::get('/ficheConsultation/{id_candidat}', [ConsultanteController::class , 'getCandidatFiche'])->name('candidatFiche');


// routes/web.php
Route::post('/ajouterCandidatAConsultation', [Controller::class, 'ajouterCandidatAConsultation']);
Route::post('/ajouterTypeDeVisa', [Controller::class, 'ajouterTypeDeVisa']);


Route::get('/creer-utilisateur', [UtilisateurController::class, 'formulaireCreation'])->name('creer-utilisateur.formulaire');
Route::post('/creer-utilisateur', [UtilisateurController::class, 'creer'])->name('creer-utilisateur.creer');


Route::get('/dossier', [HomeController::class, 'dossier'])->name('dossier');


Route::post('/save-remarques', [HomeController::class, 'saveRemarques']);

Route::post('/ajouterFichiersCandidat/{candidatId}', [DossierController::class, 'ajouterFichiersCandidat'])->name('ajoutFichiersCandidat');
Route::post('/ajouterFichiersAgent/{userId}', [DossierController::class, 'ajouterFichiersAgent'])->name('ajoutFichiersAgent');


Route::get('/toggle-consultation/{candidatId}', [consultationController::class, 'toggleConsultation'])->name('toggleConsultation');

Route::get('/waiting-list/{consultation_id}', [ConsultationController::class , 'getConsultationWaitingList'])->name('listedattente');