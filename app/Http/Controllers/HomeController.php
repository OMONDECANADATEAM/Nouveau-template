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
    
}
