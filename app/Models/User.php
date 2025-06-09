<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Period;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relasi 1 user punya banyak period (riwayat)
    public function periods()
    {
        return $this->hasMany(Period::class);
    }

    // Relasi 1 user punya 1 period (misal periode terbaru)
    public function period()
    {
        return $this->hasOne(Period::class);
    }

    public function hasRole($role)
{
    return $this->role === $role;
}
}
