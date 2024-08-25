<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'description',
        'director',
        'genre',
        'release_year'
    ];

    public function rates(){
        return $this->hasMany(Rating::class);
    }
}
