<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Period extends Model
{
    use HasFactory;

    protected $table = 'period_tabel'; // sesuaikan dengan nama tabel sebenarnya

    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'cyclelength',
        'periodlength',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
