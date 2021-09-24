<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'country_id'];

    public $timestamps = true;

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function airports(): HasMany
    {
        return $this->hasMany(Airport::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function latestComments(): HasMany
    {
        return $this->hasMany(Comment::class)->orderBy('id', 'DESC');
    }

    public function scopeSearch($query, $name)
    {
        if ($name) {
            $query->where('name', 'LIKE', '%' . $name . '%');
        }
    }
}
