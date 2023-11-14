<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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
Route::get('home',[HomeController::class, 'index'])->name('home');
Route::get('Banque',[HomeController::class, 'Banque'])->name('Banque');
Route::get('Consultation',[HomeController::class, 'Consultation'])->name('Consultation');
Route::get('DossierClients',[HomeController::class, 'DossierClients'])->name('DossierClients');
Route::get('DossierContacts',[HomeController::class, 'DossierContacts'])->name('DossierContacts');
Route::get('OmondeTeam',[HomeController::class, 'OmondeTeam'])->name('OmondeTeam');
Route::get('connexion',[HomeController::class, 'connexion'])->name('connexion');
Route::get('sign-in',[HomeController::class, 'sign-in'])->name('sign-in');
Route::get('profile',[HomeController::class, 'profile'])->name('profile');
Route::get('virtual-reality',[HomeController::class, 'virtual-reality'])->name('virtual-reality');

