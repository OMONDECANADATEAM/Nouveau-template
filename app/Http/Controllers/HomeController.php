<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }
    public function DossierContacts()
    {
        return view('DossierContacts');
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
    public function OmondeTeam()
    {
        return view('OmondeTeam');
    }

    public function profile()
    {
        return view('profile');
    }

    public function connexion()
    {
        return view('connexion');
    }
    public function getLastEntries()
{

    $entries = \App\Models\Entree::with('candidat')->orderBy('date', 'desc')->take(10)->get();

    // Retournez les données à la vue
    return view('home', compact('entries'));
}

public function callMethod($method)
{
    if (method_exists($this, $method)) {
        // Appeler la méthode dynamiquement
        return $this->{$method}();
    } else {
        // Gérer le cas où la méthode n'existe pas
        abort(404);
    }
}
}
