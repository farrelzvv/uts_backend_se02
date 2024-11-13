<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    // Menentukan kolom yang dapat diisi (fillable)
    protected $fillable = [
        'title', 'description', 'content', 'author', 'category_id'
    ];

    // Relasi dengan kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

