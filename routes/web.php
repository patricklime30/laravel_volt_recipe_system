<?php

use App\Models\Recipe;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');


Route::middleware('auth')->group(function () {

    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::view('recipe/create', 'recipe.create')->name('recipe.create');

    Route::view('recipe/mine', 'recipe.my_recipe')->name('recipe.mine');

    Route::view('recipe/my_favorite', 'recipe.favorite_recipe')->name('my.favorite.recipe');

    Route::get('recipe/{recipe}', function (Recipe $recipe) {
        return view('recipe.show', compact('recipe'));
    })->name('recipe.show');

    Route::get('recipe/{recipe}/edit', function (Recipe $recipe) {
        return view('recipe.edit', compact('recipe'));
    })->name('recipe.edit');

    Route::view('help', 'help')->name('help');

});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
