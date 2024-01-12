<?php

namespace App\Models;

use App\Models\ProcedureDemande;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeProcedure extends Model
{
    use HasFactory;

    protected $table = 'type_procedure';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'label',
        'montant',
        // Ajoutez d'autres colonnes fillables si nécessaire
    ];


    public function proceduresDemandees()
    {
        return $this->hasMany(ProcedureDemande::class, 'id_type_procedure');
    }
}

