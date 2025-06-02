<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $table ='user_tabel';
    protected $fillable = [
        'name',
        'email',
        'password',
        'birth_date',
        'last_login',
    ];
}
