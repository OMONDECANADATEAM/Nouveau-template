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
        'id', 'id_candidat', 'id_type_procedure' ];

    public function candidat()
    {
        return $this->belongsTo(Candidat::class, 'id_candidat');
    }

    public function typeProcedure()
    {
        return $this->belongsTo(TypeProcedure::class, 'id_type_procedure');
    }
}
