<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{

    public $timestamps = false;
    protected $table = 'candidat';
    protected $fillable = [
        'nom', 'prenom', 'pays', 'ville', 'numero_telephone', 'email', 'profession', 'consultation_payee', "date_naissance" , "id_utilisateur"
    ];

    public static function sauvegarderCandidat($data)
    {
        return self::create($data);
    }
}
