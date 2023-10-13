<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Taxonomy extends Model
{
    use HasFactory, NodeTrait;

    protected $fillable = [
        'name',
        'slug',
        'continent_id',
        'description'
    ];

    public $timestamps = false;

    public function countries() {
        return $this->morphedByMany(Country::class, 'taxonomyable');
    }

}
