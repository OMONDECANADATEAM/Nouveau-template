<?php

namespace App\Http\Controllers;

use App\Models\consultante;
use App\Models\InfoConsultation;
use Illuminate\Http\Request;

class InformatiqueController extends Controller
{
    //

    public function Equipe(){

        $users  = \App\Models\User::all();

        return view('Informatique.Views.Equipe' , ['users' => $users]);
    }

    public function Consultation(){

        $consultantes = consultante::all();
        $consultations = InfoConsultation::orderBy('date_heure', 'desc')->get();

        return view('Informatique.Views.Consultation', ['data_consultante' => $consultantes , 'consultations' => $consultations ]);
    }

}
