<?php

namespace App\Models;

use \App\Models\consultante;
use \App\Models\Candidat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoConsultation extends Model
{
    use HasFactory;

    public $timestamps= false;
    protected $table ='info_consultation';

    protected $fillable = [
        'label', 'lien_zoom', 'lien_zoom_demarrer', 'date_heure', 'nombre_candidats', 'id_consultante', ];

        public function consultante()
        {
            return $this->belongsTo(Consultante::class, 'id_consultante', 'id');
        }

        public function candidats()
        {
            return $this->hasMany(Candidat::class, 'id_info_consultation', 'id');
        }
}
