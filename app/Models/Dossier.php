<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dossier extends Model
{
    use HasFactory;

     	 	 	
    public $timestamps = false;
    protected $table = 'dossiers';
    protected $fillable = [
        'id', 
        'id_candidat', 
        'id_agent', 
        'url'  
    ];

    public function candidat()
    {
        return $this->belongsTo(Candidat::class, 'id_candidat', 'id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'id_dossier', 'id');
    }
}

