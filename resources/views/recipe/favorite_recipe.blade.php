<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            
           <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Find Your Favorite Recipe
            </h2>

            <p class="text-gray-500 mt-1 text-sm">
                Discover and save recipes you love. Browse, cook, and make every meal your favorite.
            </p>
        </div>
    </x-slot>

    <div>

        {{-- table --}}
        <div class="mt-6">
            <livewire:recipe.recipe-manager :owned="false" :favorited="true" title="Favorited Recipes"/>
        </div>
        
    </div>
</x-app-layout>