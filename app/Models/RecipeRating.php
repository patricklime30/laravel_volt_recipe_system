<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeRating extends Model
{
    protected $fillable = [
        'user_id',
        'recipe_id',
        'rating',
    ];

}
