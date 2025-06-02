<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $table = 'article_tabel';
    protected $fillable = [
        'title',
        'content',
        'image_url',
        'author',
        'created_at',
        'link',
    ];
}
