<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{

    public $timestamps = false;
    protected $table = 'candidat';
    protected $fillable = [
        'nom', 'prenom', 'pays', 'ville', 'numero_telephone', 'email', 'profession', 'consultation_payee', "date_naissance" , "id_utilisateur", 'remarque_agent'
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

    public function ficheConsultation()
    {
        return $this->hasOne(FicheConsultation::class, 'id_candidat');
    }
public function infoConsultation()
{
    return $this->belongsTo(InfoConsultation::class, 'id_info_consultation');
}
}

