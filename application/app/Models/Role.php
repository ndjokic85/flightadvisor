<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    const USER_ROLE = 'user';
    const ADMIN_ROLE = 'admin';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['name'];

    public $timestamps = true;

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
