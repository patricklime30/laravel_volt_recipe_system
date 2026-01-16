<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            
            <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
                Hi, {{ auth()->user()->name }}!
            </h2>

            <p class="text-gray-500 mt-1 text-sm">
                Manage and explore all your favorite recipes here.
            </p>
        </div>
        
        <x-dropdown align="right" width="48">
            {{-- Trigger Button --}}
            <x-slot name="trigger">
                <a class="cursor-pointer mt-4 md:mt-0 bg-indigo-600 hover:bg-indigo-700 text-white inline-flex items-center gap-2 rounded-md font-semibold text-xs uppercase px-4 py-2">
                            
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    
                    Create Recipe

                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </a>
                
            </x-slot>

            {{-- Dropdown Content --}}
            <x-slot name="content">
                
                <x-dropdown-link href="{{ route('recipe.create') }}" wire.navigate>
                    Manual Input
                </x-dropdown-link>
               
                <x-dropdown-link x-data=""
                    x-on:click.prevent="$dispatch('upload-recipe-pdf')" class="cursor-pointer">
                   Upload PDF
                </x-dropdown-link>
            </x-slot>
        </x-dropdown>
        
    </x-slot>

    <div>
        {{-- overview stat --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- total recipes --}}
            <livewire:dashboard.total-recipes/>

            {{-- average rating --}}
            <livewire:dashboard.average-rating/>

            {{-- total comments --}}
            <livewire:dashboard.total-comments/>
        </div>

        {{-- table --}}
        <div class="mt-6">
            <!-- : means php variable or boolean -->
            <livewire:recipe.recipe-manager :owned="false" title="Recommended Recipes"/>
        </div>
        
    </div>

    <!-- modal upload recipe PDF -->
    <livewire:recipe.upload-recipe-pdf />
</x-app-layout>
