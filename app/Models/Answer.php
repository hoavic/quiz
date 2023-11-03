<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question_id',
        'active',
        'correct',
        'name',
        'description'
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function getActiveAttribute($value) {
        if ($value === 1) {return true;}
        return false;
    }

    public function getCorrectAttribute($value) {
        if ($value === 1) {return true;}
        return false;
    }
}
