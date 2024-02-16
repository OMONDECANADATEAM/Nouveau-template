<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatutProcedure extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'statut_procedure';
    protected $fillable = ['id' , 'label'   ];

    public function procedures()
    {
        return $this->hasMany(Procedure::class);
    }
    
}
