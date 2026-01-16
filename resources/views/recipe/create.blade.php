<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Your Own Recipe
            </h2>

            <p class="text-gray-500 mt-1 text-sm">
                Share your culinary creations! Fill out the details below including ingredients, instructions, and a photo so others can enjoy your recipe.
            </p>
        </div>
    </x-slot>

    <div>
       <livewire:recipe.create-recipe-form />
    </div>
</x-app-layout>
