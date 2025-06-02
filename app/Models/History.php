<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $table = 'period_tabel';
    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'notes',
        'created_at',
        'updated_at',
    ];
}
