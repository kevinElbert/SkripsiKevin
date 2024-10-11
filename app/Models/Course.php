<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    // Menentukan kolom mana saja yang bisa diisi secara massal
    protected $fillable = [
        'title',
        'description',
        'image',
        'slug',
        'category_id', // Relasi dengan kategori
        'is_published', // Status kursus (published/draft)
    ];

    // Relasi ke model Category (jika Anda ingin menambahkan kategori)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
