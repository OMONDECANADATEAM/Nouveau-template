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
    return view('welcome');
});
Route::get('home',[HomeController::class, 'index'])->name('home');
Route::get('billing',[HomeController::class, 'index'])->name('hobillingme');
Route::get('dashboard',[HomeController::class, 'index'])->name('dashboard');
Route::get('notifications',[HomeController::class, 'index'])->name('notifications');
Route::get('profile',[HomeController::class, 'index'])->name('profile');
Route::get('rtl',[HomeController::class, 'index'])->name('rtl');
Route::get('sign-in',[HomeController::class, 'index'])->name('sign-in');
Route::get('sign-up',[HomeController::class, 'index'])->name('sign-up');
Route::get('tables',[HomeController::class, 'index'])->name('tables');
Route::get('virtual-reality',[HomeController::class, 'index'])->name('virtual-reality');

