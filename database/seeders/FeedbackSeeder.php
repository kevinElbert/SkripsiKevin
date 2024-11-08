<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Feedback;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class FeedbackSeeder extends Seeder
{
    public function run()
    {
        // Menambahkan beberapa feedback secara manual
        Feedback::create([
            'course_id' => 1,
            'user_id' => 2, // user_id ada, jadi user_name diabaikan
            'comment' => 'Coursesnya sangat membantu dan mengasikan',
            'rating' => 5,
        ]);

        Feedback::create([
            'course_id' => 1,
            'user_id' => null, // user_id null, gunakan user_name sebagai pengganti
            'user_name' => 'Guest User',
            'comment' => 'Good content, but could be more detailed.',
            'rating' => 4,
        ]);

        Feedback::create([
            'course_id' => 1,
            'user_id' => null,
            'user_name' => 'Anonymous',
            'comment' => 'Found it helpful for beginners.',
            'rating' => 4,
        ]);
    }
}
