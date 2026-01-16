<?php

use Livewire\Volt\Component;
use App\Models\Recipe;

new class extends Component {
    // automatically detected when call $this->recipes
    public function getRecipesProperty()
    {
        return Recipe::query()
                ->select('id', 'title', 'image', 'description')
                ->orderBy('rating', 'DESC')
                ->limit(3)
                ->get();
    }
}; ?>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-4">
    @forelse ($this->recipes as $recipe)
        <x-recipe-card :recipe="$recipe" :showStats="false" :showActions="false"/>
    @empty
        <div class="col-span-full flex flex-col items-center justify-center p-8 border rounded shadow bg-gray-50 mt-4">
            <svg class="w-16 h-16 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
            </svg>
            <p class="text-gray-500 text-lg font-medium">No recipes found.</p>
            <p class="text-gray-400 text-sm mt-1">Try creating new one.</p>
        </div>
    @endforelse
</div>
