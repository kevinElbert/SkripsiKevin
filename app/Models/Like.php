<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'likeable_id', 'likeable_type'];

    /**
     * Define polymorphic relationship.
     */
    public function likeable()
    {
        return $this->morphTo();
    }
}
