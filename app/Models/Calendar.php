<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;
    protected $table ='calendar_tabel';
    protected $fillable = [
        'user_id',
        'title',
        'event_date',
        'created_at',
        'updated_at',
    ];
}
