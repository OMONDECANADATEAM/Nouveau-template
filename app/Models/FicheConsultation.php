<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FicheConsultation extends Model
{
    use HasFactory;

    protected $table ='fiche_consultation';
    public $timestamps = false;

    protected $fillable = [
        'id_candidat',
        'lien_cv',
        'reponse1',
        'reponse2',
        'reponse3',
        'reponse4',
        'reponse5',
        'reponse6',
        'reponse7',
        'reponse8',
        'reponse9',
        'reponse10',
        'reponse11',
        'reponse12',
        'reponse13',
        'reponse14',
        'reponse15',
        'reponse16',
        'reponse17',
        'reponse18',
        'reponse19',
        'reponse20',
        'reponse21',
        'reponse22',
    ];

    public function candidat()
    {
        return $this->belongsTo(Candidat::class, 'id_candidat', 'id');
    }

}
