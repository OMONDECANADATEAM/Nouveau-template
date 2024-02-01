<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    use HasFactory;

    protected $table = 'rdv';
    public $timestamps = false;
    protected $fillable = ['date_rdv', 'candidat_id', 'commercial_id' , 'rdv_effectue' , 'consultation_payee'];

    /**
     * Relation avec le modèle Candidat
     */
    public function candidat()
    {
        return $this->belongsTo(Candidat::class, 'candidat_id');
    }

    /**
     * Relation avec le modèle User (pour le commercial)
     */
    public function commercial()
    {
        return $this->belongsTo(User::class, 'commercial_id');
    }
}
