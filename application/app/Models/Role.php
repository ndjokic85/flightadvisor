<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
