<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Airport extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'id',
        'name',
        'city_id',
        'iata',
        'icao',
        'latitude',
        'longitude',
        'altitude',
        'timezone',
        'dst',
        'tz',
        'type',
        'source'
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
