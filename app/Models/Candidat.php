<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Candidat extends Model
{

    public $timestamps = false;
    protected $table = 'candidat';
    protected $fillable = [
        'nom', 'prenom', 'pays', 'ville', 'numero_telephone', 'email', 'profession', 'consultation_payee', "date_naissance" , "id_utilisateur", 'remarque_agent', 'versement_effectuee', 'consultation_effectuee', 'date_rdv'
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
        return $this->belongsTo(User::class, 'id_utilisateur');
    }

    public function ficheConsultation()
    {
        return $this->hasOne(FicheConsultation::class, 'id_candidat');
    }
    public function infoConsultation()
    {
        return $this->belongsTo(InfoConsultation::class, 'id_info_consultation');
    }
    
  
     public function proceduresDemandees()
    {
        return $this->hasMany(Procedure::class, 'id_candidat');
    }

    public function rendezVous()
    {
        return $this->hasOne(RendezVous::class, 'candidat_id');
    }
    public function dossier()
    {
        return $this->hasOne(Dossier::class, 'id_candidat', 'id');
    }
    
}

