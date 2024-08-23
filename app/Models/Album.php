<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model {
    use HasFactory;

    protected $fillable = [
        'spotify_id', 'title', 'artist','release_date','genre', 'cover_image_url'
    ];

    public function users() {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
