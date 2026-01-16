<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'recipe_id',
        'message'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
