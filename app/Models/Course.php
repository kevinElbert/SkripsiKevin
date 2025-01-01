<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Tambahkan ini untuk membuat slug
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'video',
        'category_id',
        'admin_id',
        'is_published',
        'slug', // Assuming you're still using slug
        'short_description',
        'learning_points',
    ];
    
    public $timestamps = true; // Timestamps sudah benar

    // Boot method untuk mengisi slug secara otomatis
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($course) {
            $course->slug = Str::slug($course->title); // Membuat slug dari title
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function getFileSize()
    {
        return $this->file_size ?? 'Unknown';
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
    
    protected $casts = [
        'learning_points' => 'array',
    ];

    // In Course.php model
    public function subTopics()
    {
        return $this->hasMany(SubTopic::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
    
    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'user_courses', 'course_id', 'user_id')->withTimestamps();
    // }    

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_courses')->withPivot('progress')->withTimestamps();
    }
}

