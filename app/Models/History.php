<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class History extends Model
{
    use HasFactory;
    protected $table ='period_tabel';
    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'cyclelength',
        'periodlength',
    ];
}