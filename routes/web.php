<?php



use App\Http\Controllers\DepenseController;
use App\Http\Controllers\EntreeController;
use App\Http\Controllers\DepenseControllerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\chartController;
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
    return view('connexion');
});

// web.php

Route::get('home', [HomeController::class, 'index'])->name('home');
Route::get('home/{method}', [HomeController::class, 'callMethod'])->where('method', '.*');


Route::post('ajoutDepense', [DepenseController::class, 'ajoutDepense'])->name('ajoutDepense');
Route::post('Banque', [EntreeController::class, 'ajoutEntree'])->name('ajoutEntree');
Route::get('Banque', [HomeController::class, 'Banque'])->name('Banque');
Route::get('Consultation', [HomeController::class, 'listeConsultantes'])->name('Consultation');
Route::get('DossierClients', [HomeController::class, 'allClient'])->name('DossierClients');
Route::get('DossierContacts', [HomeController::class, 'allCandidat'])->name('DossierContacts');
Route::get('OmondeTeam', [HomeController::class, 'OmondeTeam'])->name('OmondeTeam');

// Routes d'authentification

Route::get('connexion', [AuthController::class, 'showLoginForm'])->name('connexion.form');
Route::post('connexion', [AuthController::class, 'login']);
Route::get('sign-in', [HomeController::class, 'sign-in'])->name('sign-in');
Route::get('profile', [HomeController::class, 'profile'])->name('profile');
Route::get('virtual-reality', [HomeController::class, 'virtual-reality'])->name('virtual-reality');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


//
Route::put('/modifierContact/{id}', [Controller::class, 'modifierFormulaire'])->name('modifierContact');
Route::post('DossierContacts', [Controller::class, 'soumettreFormulaire'])->name('ajoutContact');

//Chart routes et controller

Route::get('/chart-data', [chartController::class, 'getChartData']);
Route::get('/chart-month', [chartController::class, 'getChartMonthData']);


//
Route::post('Consultation', [Controller::class, 'ajoutConsultation'])->name('ajoutConsultation');
Route::get('listeConsultantes', [HomeController::class, 'listeConsultantes'])->name('listeConsultantes');


// Exemple de route dans votre fichier web.php
Route::get('/recherche-candidat', [Controller::class , 'rechercheCandidat'])->name('rechercheCandidat');
