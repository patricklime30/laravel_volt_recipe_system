<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit "{{ $recipe->title }}" Recipe
            </h2>

            <p class="text-gray-500 mt-1 text-sm">
                Update the title, description, ingredients, cooking steps, and photo to keep your culinary creation fresh and accurate.
            </p>
        </div>
    </x-slot>

    <div>
       <livewire:recipe.edit-recipe-form :recipe="$recipe" />
    </div>
</x-app-layout>