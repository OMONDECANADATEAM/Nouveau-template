<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    // Table name (optional if it follows Laravel's naming conventions)
    protected $table = 'tags';

    // Fields that are mass assignable
    protected $fillable = ['label'];

    /**
     * The dossiers that belong to the tag.
     */
    public function procedure()
    {
        return $this->belongsToMany(Procedure::class , 'id');
    }
}
