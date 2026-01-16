<?php

use Livewire\Volt\Component;
use App\Models\Recipe;

new class extends Component {
    public string $search = '';

    public bool $showDropdown = false;

    // no array type
    public $recipes = [];

    public function applySearch()
    {
        if (!$this->search) {
            return collect();
        }

        $this->recipes = Recipe::when($this->search, function($q){
                                $q->where('title', 'like', "%{$this->search}%")
                                    ->orWhere('description', 'like', "%{$this->search}%");
                            })
                            ->select('id', 'title', 'description')
                            ->get();

        $this->showDropdown = true;
    }

    public function closeDropdown()
    {
        $this->showDropdown = false;
    }

}; ?>

<div>
    <!-- SEARCH -->
    <form wire:submit="applySearch" class="w-full relative">
        <!-- Search Input -->
        <x-text-input 
            wire:model="search" 
            type="text" 
            placeholder="Search recipes..."
            class="w-full" 
        />

        <!-- Search Icon Button -->
        <button 
            type="submit"
            wire:loading.attr="disabled"
            wire:target="applySearch"
            class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-indigo-600"
        >
            <!-- Loading spinner -->
            <svg wire:loading wire:target="applySearch" class="animate-spin h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>

            <!-- Heroicons Magnifying Glass -->
            <svg wire:loading.remove wire:target="applySearch" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
            </svg>
        </button>
    </form>

    <!-- Dropdown -->
    @if($showDropdown)
        <div class="absolute z-10 mt-2 w-full max-w-md rounded-lg border bg-white shadow max-h-64 overflow-y-auto">
            <!-- Close Button -->
            <div class="flex items-center justify-between px-2 py-1">
                <p class="text-xs text-gray-500">
                    Search found {{ $recipes->count() }} result(s)
                </p>

                <button
                    type="button"
                    wire:click="closeDropdown"
                    class="text-gray-400 hover:text-gray-600 rounded-full focus:outline-none"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

           <!-- Results -->
            @if($this->recipes->count())
                @foreach($this->recipes as $recipe)
                    <div class="flex items-center justify-between px-4 py-2 hover:bg-gray-100">
                        <div class="min-w-0">
                            <!-- Title -->
                            <p class="text-sm font-semibold text-gray-800">
                                {{ $recipe->title }}
                            </p>

                            <!-- Description -->
                            <p class="mt-1 text-xs text-gray-500 line-clamp-2">
                                {{ Str::limit($recipe->description, 100) }}
                            </p>
                        </div>

                        <a href="{{ route('recipe.show', $recipe->id) }}" wire:navigate
                            class="inline-flex items-center gap-1 px-3 py-1 rounded-md bg-white border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs font-semibold transition">
                            View
                        </a>
                    </div>
                @endforeach

            @else
                <!-- No Data -->
                <div class="px-4 py-3 text-sm text-gray-500 text-center">
                    No recipes found for
                    <span class="font-semibold">“{{ $search }}”</span>
                </div>
            @endif
        </div>
    @endif
</div>
