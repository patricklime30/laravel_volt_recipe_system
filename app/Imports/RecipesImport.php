<?php

namespace App\Imports;

use App\Models\Recipe;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class RecipesImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $imageUrl = '';
        $cookingTime = "";

        if (!empty($row['cooking_time'] && $row['image_url'])) {
            preg_match('/\d+/', $row['cooking_time'], $matches);
            
            $cookingTime = $matches[0] ?? null;

            $imageContents = Http::get($row['image_url'])->body();

            $imageName = Str::uuid() . '.jpg';

            Storage::disk('public')->put("recipes/{$imageName}", $imageContents);

            $imageUrl = "recipes/{$imageName}";
        }

        return new Recipe([
            'image' => $imageUrl ?? null,
            'title' => $row['title'] ?? null,
            'ingredients' => array_map('trim', explode(',', $row['ingredients'])),
            'instructions' => array_map('trim', explode(',', $row['instructions'])),
            'description' => $row['description'] ?? null,
            'cooking_time' => $cookingTime ?? null,
            'category' => $row['category'] ?? null,
            'user_id' => auth()->id(),
        ]);
    }
}
