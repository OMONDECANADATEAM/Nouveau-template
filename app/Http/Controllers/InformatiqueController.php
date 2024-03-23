<?php

namespace App\Http\Controllers;

use App\Models\consultante;
use App\Models\InfoConsultation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InformatiqueController extends Controller
{
    //

    public function Equipe()
    {

        $users  = \App\Models\User::all();

        return view('Informatique.Views.Equipe', ['users' => $users]);
    }

    public function Consultation()
    {
        Carbon::setLocale('fr');
        $consultantes = consultante::all();
        $consultations = InfoConsultation::orderBy('date_heure', 'desc')->get();
        $consultations->transform(function ($consultations) {
            if ($consultations->date_heure) {
                $dateFormatee = Carbon::parse($consultations->date_heure)->translatedFormat('l j F Y H:i');
                $consultations->dateFormatee = ucwords($dateFormatee);
            } else {
                $consultations->dateFormatee = 'N / A'; // Ou toute autre valeur par défaut que vous souhaitez afficher pour les valeurs nulles
            }
            return $consultations;
        });
        return view('Informatique.Views.Consultation', ['data_consultante' => $consultantes, 'consultations' => $consultations]);
    }
}
