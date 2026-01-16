<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            
           <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Check Your Own Recipe
            </h2>

            <p class="text-gray-500 mt-1 text-sm">
                Discover delicious recipes tailored to your taste. Explore, cook, and enjoy meals created by you.
            </p>
        </div>
    </x-slot>

    <div>

        <div class="max-w-6xl mx-auto flex flex-col md:flex-row gap-6">

            <!-- Left Info Panel -->
            <div class="md:w-2/3 bg-white rounded-lg shadow p-6">
                <livewire:recipe.overall-performance/>
            </div>

            <!-- Right Chart Panel -->
            <div class="md:w-1/3 bg-indigo-50 text-indigo-700 rounded-lg shadow p-6">
                 <livewire:recipe.overall-satisfaction/>
            </div>
        </div>
        
        <!-- table -->
        <div class="mt-6">
            <livewire:recipe.recipe-manager :owned="true" title="My Recipes"/>
        </div>
        
    </div>

</x-app-layout>