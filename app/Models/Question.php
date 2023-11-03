<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'type',
        'active',
        'level',
        'score',
        'name',
        'description'
    ];

    protected static function boot() {
        parent::boot();

        static::deleting(function($question) {
            foreach($question->answers as $answer){
                $answer->delete();
            }
        });
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function getActiveAttribute($value) {
        if ($value === 1) {return true;}
        return false;
    }
}
