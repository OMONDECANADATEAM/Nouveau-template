<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\InfoConsultation;

class consultante extends Model
{
    use HasFactory;

    protected $table = 'consultante';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_utilisateur', 'id');
    }

    public function infoConsultations()
    {
        return $this->hasMany(InfoConsultation::class, 'id_consultante', 'id');
    }

// Modèle InfoConsultation
    public function candidats()
    {
        return $this->hasMany(Candidat::class, 'id_info_consultation', 'id');
    }

    public function procedures()
    {
        return $this->hasMany(Procedure::class, 'consultante_id');
    }
}
