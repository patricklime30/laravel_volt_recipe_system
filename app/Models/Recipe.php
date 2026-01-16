<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'ingredients',
        'instructions',
        'image',
        'cooking_time',
        'rating',
        'category',
    ];

    protected $casts = [
        'ingredients' => 'array',   // JSON to PHP array
        'instructions' => 'array',  // JSON to PHP array
        'rating' => 'decimal:1',    // decimal with 1 decimal place
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ratings()
    {
        return $this->hasMany(RecipeRating::class);
    }

    // model function to calculate average rating
    public function averageRating()
    {
        return round($this->ratings()->avg('rating') ?? 0, 1);
    }

    // model function to calculate total user who rates
    public function totalRatings()
    {
        return $this->ratings()->count();
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function isFavoritedBy($userId)
    {
        return $this->favorites()->where('user_id', $userId)->exists() ?? false;
    }

    public function toggleFavorite($userId){

        $favorite = $this->favorites()
            ->where('user_id', $userId)
            ->first();

        if ($favorite) {
            $favorite->delete();   // unfavorite
        } else {
            $this->favorites()->create([
                'user_id' => $userId,
            ]);
        }
        
    }
}
