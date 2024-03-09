<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Depense;
use App\Models\Entree;
use App\Models\Procedure;
use App\Models\InfoConsultation;
use App\Models\FicheConsultation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public $timestamps = false;




   
 
    public function getAllTransactions($userId = null)
    {
        $depensesQuery = Depense::query();
        $entreesQuery = Entree::query();

        if ($userId) {
            $depensesQuery->where('id_utilisateur', $userId);
            $entreesQuery->where('id_utilisateur', $userId);
        }

        $depenses = $depensesQuery->get();
        $entrees = $entreesQuery->get();


        $transactions = $depenses->concat($entrees);
        $transactions = $transactions->sortByDesc('date');

        return  $transactions;
    }
}
