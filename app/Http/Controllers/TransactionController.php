<?php

// app/Http/Controllers/TransactionController.php

namespace App\Http\Controllers;

use App\Models\Entree;
use PDF; // Utilisez l'alias PDF défini dans config/app.php
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function print($id)
    {
        $transaction = Entree::findOrFail($id);
        $pdf = PDF::loadView('Documents.Recu', compact('transaction'));
        return $pdf->download('recu_paiement.pdf');
    }
}
