<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications'; 
    protected $fillable = ['title', 'body', 'user_id', 'read_at'];
}
