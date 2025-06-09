<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;

    protected $table = 'period_tabel';

    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'cyclelength',
        'periodlength',
        'next_start_date',
        'next_end_date',
        'fertile_start_date',
        'fertile_end_date',
    ];
}
