<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'slug',
        'category_id',
        'is_published',
        'admin_id' // Menambahkan relasi ke admin (pengguna)
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke model Score
    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    // Metode untuk mendapatkan ukuran file (asumsi kamu menyimpan file path atau ukuran dalam field tertentu)
    public function getFileSize()
    {
        // Misal ukuran file disimpan dalam sebuah field `file_path`, kamu bisa menggunakan storage size function
        $filePath = storage_path('app/public/courses/' . $this->file_path);
        
        if (file_exists($filePath)) {
            return filesize($filePath); // Mengembalikan ukuran file dalam bytes
        }

        return 0; // Jika file tidak ditemukan atau tidak ada, kembalikan 0
    }
}
