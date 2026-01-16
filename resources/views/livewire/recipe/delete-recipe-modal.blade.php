<?php

use Livewire\Volt\Component;
use App\Models\Recipe;
use Livewire\Attributes\On;

new class extends Component {
    public Recipe $recipe;

    #[On('delete-recipe')] 
    public function loadRecipeData($recipeId) {
        
        $this->recipe = Recipe::findOrFail($recipeId);

        $this->dispatch('open-modal', 'confirm-recipe-delete');
    }

    public function deleteRecipe(){
        if($this->recipe->image && Storage::disk('public')->exists($this->recipe->image)){
            Storage::disk('public')->delete($this->recipe->image);   
        }

        $this->recipe->delete();

        return redirect()->route('dashboard')->with('success', 'Recipe successfully deleted!');
    }
}; ?>

<x-modal name="confirm-recipe-delete" :show="false" focusable>
    <form wire:submit="deleteRecipe" class="p-6">

        <h2 class="text-lg font-medium text-gray-900">
            Are you sure you want to delete "{{ $recipe->title ?? 'this recipe' }}"?
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            This recipe will be permanently removed the recipe.
        </p>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                Cancel
            </x-secondary-button>

            <x-danger-button class="ms-3">
                Yes, Delete
            </x-danger-button>
        </div>
    </form>
</x-modal>