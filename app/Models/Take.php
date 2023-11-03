<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Take extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question_id',
        'status',
        'score',
        'published',
        'published_at',
        'started_at',
        'finished_at',
        'content',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function takeAnswers(): HasMany
    {
        return $this->hasMany(TakeAnswer::class);
    }
}
