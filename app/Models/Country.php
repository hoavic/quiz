<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'continent_id',
        'description'
    ];

    public $timestamps = false;

    public function continent(): BelongsTo
    {
        return $this->belongsTo(Continent::class);
    }

    public function taxonomies() {
        return $this->morphToMany(Taxonomy::class, 'taxonomyable');
    }
}
