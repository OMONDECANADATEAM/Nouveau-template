<?php

// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('Connexion.connexionPage');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->route('Dashboard');
        }

        return redirect()->route('connexion.form')->with('error', 'Adresse e-mail ou mot de passe incorrect.');

    }

    public function logout()
{
    Auth::logout();
    return redirect('/');
}

}

