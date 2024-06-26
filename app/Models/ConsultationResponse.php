<?php

// app/Models/ConsultationResponse.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationResponse extends Model
{
    use HasFactory;

    protected $fillable = ['consultation_record_id', 'question_id', 'response'];

    public function consultationRecord()
    {
        return $this->belongsTo(ConsultationRecord::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
