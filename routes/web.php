<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
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

Route::get('home', [HomeController::class, 'index'])->name('home');
Route::get('Banque', [HomeController::class, 'Banque'])->name('Banque');
Route::get('Consultation', [HomeController::class, 'Consultation'])->name('Consultation');
Route::get('DossierClients', [HomeController::class, 'DossierClients'])->name('DossierClients');
Route::get('DossierContacts', [HomeController::class, 'DossierContacts'])->name('DossierContacts');
Route::get('OmondeTeam', [HomeController::class, 'OmondeTeam'])->name('OmondeTeam');

// Routes d'authentification

Route::get('connexion', [AuthController::class, 'showLoginForm'])->name('connexion.form');
Route::post('connexion', [AuthController::class, 'login']);
Route::get('sign-in', [HomeController::class, 'sign-in'])->name('sign-in');
Route::get('profile', [HomeController::class, 'profile'])->name('profile');
Route::get('virtual-reality', [HomeController::class, 'virtual-reality'])->name('virtual-reality');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

