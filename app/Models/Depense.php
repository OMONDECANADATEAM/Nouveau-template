<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{

     protected $table = 'depense' ;
    protected $fillable = [
        'id',
        'montant',
        'raison',
        'id_utilisateur',
        'date',
        
    ];

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'id_utilisateur', 'id');
    }
}

