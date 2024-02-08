<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'documents';
    protected $fillable = [
        'id', 
        'id_dossier', 
        'nom', 
        'url'  
    ];
    public function dossier()
    {
        return $this->belongsTo(Dossier::class, 'id_dossier', 'id');
    }

    public function candidat()
    {
        return $this->belongsTo(Candidat::class, 'id_candidat', 'id');
    }
}
