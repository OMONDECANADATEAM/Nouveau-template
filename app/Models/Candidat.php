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
    public function entrees()
{
    return $this->hasMany(Entree::class, 'id_candidat');
}

public function utilisateur()
{
    return $this->belongsTo(User::class, 'id_utilisateur'); // Assurez-vous d'ajuster la clé étrangère si nécessaire
}

}

