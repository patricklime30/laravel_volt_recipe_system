<?php

use Livewire\Volt\Component;
use App\Models\Recipe;

new class extends Component {
    
    public Recipe $recipe;

    // mount() runs once, polling does not re-run it
    public function mount(Recipe $recipe)
    {
        $this->recipe = $recipe;
    }

    public function getIsFavoritedProperty(): bool
    {
        return $this->recipe->isFavoritedBy(auth()->id());
    }

    public function setFavoriteRecipe()
    {
        $this->recipe->toggleFavorite(auth()->id());
    }
}; ?>

<div>

    <button wire:click="setFavoriteRecipe"
        class="flex text-gray-300 hover:text-gray-700 transition">
        
        @if ($this->isFavorited)
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-gray-700">
                <path fill-rule="evenodd" d="M6.32 2.577a49.255 49.255 0 0 1 11.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 0 1-1.085.67L12 18.089l-7.165 3.583A.75.75 0 0 1 3.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93Z" clip-rule="evenodd" />
            </svg>
        @else
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                <path fill-rule="evenodd"
                    d="M6.32 2.577a49.255 49.255 0 0 1 11.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 0 1-1.085.67L12 18.089l-7.165 3.583A.75.75 0 0 1 3.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93Z"
                    clip-rule="evenodd" />
            </svg>
        @endif
    </button>
</div>
