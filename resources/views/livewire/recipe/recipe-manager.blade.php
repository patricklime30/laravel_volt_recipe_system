<?php

use Livewire\Volt\Component;
use App\Models\Recipe;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public string $sort = 'cooking_time';
    public string $direction = 'asc';
    public string $category = '';

    public string $heading = '';

    public bool $gridView = true;

    // filter by owner passed from blade
    public bool $owned = false;

    public bool $favorited = false;
    
    // from URL
    public string $search = '';
    protected $queryString = ['search'];

    public function mount($owned, string $title)
    {
        $this->owned = $owned ?? false;
        $this->heading = $title ?? '';
    }

    // automatically detected when call $this->recipes
    public function getRecipesProperty()
    {
        $userId = auth()->id();

        return Recipe::query()
                ->when($this->search, function($q){
                    $q->where('title', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%");
                })
                ->when($this->category, fn($q) => $q->where('category', $this->category))
                ->when($this->owned, fn($q) => $q->where('user_id', $userId))
                ->when($this->favorited, function($q) use($userId) {
                    $q->whereHas('favorites', function($query) use($userId) {
                        $query->where('user_id', $userId);
                    });
                })
                ->orderBy($this->sort, $this->direction)
                ->paginate(3);
    }

}; ?>


<div class="max-w-7xl">

    {{-- sort, filter, view button --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
       
        <h2 class="text-gray-800 font-semibold inline-flex items-center gap-2 text-lg">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-red-600">
                <path fill-rule="evenodd" d="M12.963 2.286a.75.75 0 0 0-1.071-.136 9.742 9.742 0 0 0-3.539 6.176 7.547 7.547 0 0 1-1.705-1.715.75.75 0 0 0-1.152-.082A9 9 0 1 0 15.68 4.534a7.46 7.46 0 0 1-2.717-2.248ZM15.75 14.25a3.75 3.75 0 1 1-7.313-1.172c.628.465 1.35.81 2.133 1a5.99 5.99 0 0 1 1.925-3.546 3.75 3.75 0 0 1 3.255 3.718Z" clip-rule="evenodd" />
            </svg>

            {{ $heading }}
        </h2>

        <div class="flex gap-2">
            {{-- sorting --}}
            <x-dropdown align="right" width="48">
                {{-- Trigger Button --}}
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-4 py-2 rounded-md font-semibold uppercase text-xs bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 transition">
                        Sorting

                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button> 
                </x-slot>

                {{-- Dropdown Content --}}
                <x-slot name="content">
                    {{-- Sort By Column --}}
                    <div class="px-4 py-2 text-gray-500 uppercase text-xs font-semibold">
                        Sort By
                    </div>
                    <x-dropdown-link href="#" wire:click="$set('sort', 'cooking_time')" class="{{ $sort === 'cooking_time' ? 'bg-blue-50 font-semibold text-indigo-600' : '' }}">
                        Cooking Time
                    </x-dropdown-link>
                    <x-dropdown-link href="#" wire:click="$set('sort', 'rating')" class="{{ $sort === 'rating' ? 'bg-indigo-50 font-semibold text-indigo-600' : '' }}">
                        Rating
                    </x-dropdown-link>
                    <x-dropdown-link href="#" wire:click="$set('sort', 'created_at')" class="{{ $sort === 'created_at' ? 'bg-indigo-50 font-semibold text-indigo-600' : '' }}">
                        Newest
                    </x-dropdown-link>

                    <div class="border-t my-1"></div>

                    {{-- Sort Direction --}}
                    <div class="px-4 py-2 text-gray-500 uppercase text-xs font-semibold">
                        Direction
                    </div>
                    <x-dropdown-link href="#" wire:click="$set('direction', 'asc')" class="{{ $direction === 'asc' ? 'bg-indigo-50 font-semibold text-indigo-600' : '' }}">
                        Ascending (A → Z)
                    </x-dropdown-link>
                    <x-dropdown-link href="#" wire:click="$set('direction', 'desc')" class="{{ $direction === 'desc' ? 'bg-indigo-50 font-semibold text-indigo-600' : '' }}">
                        Descending (Z → A)
                    </x-dropdown-link>
                </x-slot>
            </x-dropdown>

            {{-- category filter --}}
            <x-dropdown align="right" width="48">
                <!-- Trigger Button -->
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-4 py-2 rounded-md font-semibold uppercase text-xs bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 transition">
                        Category
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                </x-slot>

                <!-- Dropdown Content -->
                <x-slot name="content">
                    @foreach(['breakfast','lunch','dinner'] as $cat)
                        <x-dropdown-link href="#" wire:click="$set('category','{{ $cat }}')" 
                            class="{{ $category === $cat ? 'bg-indigo-50 font-semibold text-indigo-600' : '' }}">
                            {{ ucfirst($cat) }}
                        </x-dropdown-link>
                    @endforeach
                    <div class="border-t my-1"></div>
                    <x-dropdown-link href="#" wire:click="$set('category', '')" class="{{ !$category ? 'bg-indigo-50 font-semibold text-indigo-600' : '' }}">
                        All
                    </x-dropdown-link>
                </x-slot>
            </x-dropdown>

            {{-- grid button --}}
            <div class="flex items-center gap-2">
                <button 
                    wire:click="$toggle('gridView')"
                    class="inline-flex items-center gap-1 px-4 py-2 rounded-md {{ $gridView ? 'bg-gray-100 hover:bg-gray-200 text-gray-700' : 'bg-indigo-50 hover:bg-indigo-200 text-indigo-700' }} text-xs uppercase font-semibold">
                    
                    <!-- Default text -->
                    @if(!$gridView)
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 3h7v7H3V3zm0 11h7v7H3v-7zm11-11h7v7h-7V3zm0 11h7v7h-7v-7z"/>
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <path d="M5.625 3.75a2.625 2.625 0 1 0 0 5.25h12.75a2.625 2.625 0 0 0 0-5.25H5.625ZM3.75 11.25a.75.75 0 0 0 0 1.5h16.5a.75.75 0 0 0 0-1.5H3.75ZM3 15.75a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75ZM3.75 18.75a.75.75 0 0 0 0 1.5h16.5a.75.75 0 0 0 0-1.5H3.75Z" />
                        </svg>
                    @endif
                  
                    <span>
                        {{ $gridView ? 'List' : 'Grid' }}
                    </span>
                </button>
            </div>

        </div>
        
    </div>

    @if($gridView)
        {{-- Grid View --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-4">
            @forelse ($this->recipes as $recipe)
                <x-recipe-card :recipe="$recipe" :showStats="true"/>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center p-8 border rounded shadow bg-gray-50 mt-4">
                    <svg class="w-16 h-16 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
                    </svg>
                    <p class="text-gray-500 text-lg font-medium">No recipes found.</p>
                    <p class="text-gray-400 text-sm mt-1">Try adjusting your search or filters.</p>
                </div>
            @endforelse
        </div>
    @else
        {{-- List / Table View --}}
        <x-recipe-table :recipes="$this->recipes" :authUser="auth()->user()" :showReports="$owned" />
    @endif

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $this->recipes->links() }}
    </div>

    {{-- delete modal --}}
    <livewire:recipe.delete-recipe-modal />
</div>
