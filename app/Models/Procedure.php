<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    use HasFactory;

    protected $table = 'procedure_demande';
    public $timestamps = false;

    protected $fillable = [
        'id', 'id_candidat', 'id_procedure' ];


    public function candidats()
    {
        return $this->hasMany(Candidat::class);
    }
}
