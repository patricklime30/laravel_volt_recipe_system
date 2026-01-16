<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Deep Dive Into the Recipe
            </h2>

            <p class="text-gray-500 mt-1 text-sm">
                Explore the full details of this recipe—ingredients, and instructions.
                Save it, rate it, or add your own comments.
            </p>
        </div>

        <!-- Back Buttons -->
        <x-secondary-button wire:navigate href="{{ route('dashboard') }}" class="mt-4 md:mt-0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
            </svg>

            Back
        </x-secondary-button>
    </x-slot>

    <div class="max-w-7xl space-y-6">

        <!-- Top Image Section -->
        <div 
            class="relative w-full h-48 sm:h-64 md:h-72 lg:h-80 rounded-2xl overflow-hidden shadow-md">

            <!-- Image -->
            <img src="{{ asset('storage/' . $recipe->image) }}"
                alt="{{ $recipe->title }}"
                class="w-full h-full object-cover">

            <!-- Favorite Button -->
            <div class="absolute top-4 right-4 bg-white/90 w-10 h-10 rounded-full flex items-center justify-center">
                <livewire:recipe.recipe-favorite-button :recipe="$recipe"/>
            </div>
            
        </div>

        <!-- Recipe Title & Quantity Counter -->
        <div class="bg-white rounded-2xl shadow p-5 space-y-6">

            <!-- Header -->
            <div class="flex justify-between items-center gap-4">
                <div class="flex-1">
                    <h1 class="text-2xl font-bold leading-tight">
                        {{ $recipe->title }}
                    </h1>

                    <p class="text-gray-500 text-xs capitalize mt-1">
                        created at {{ $recipe->created_at->format('d M Y h:i') }}
                    </p>

                     <!-- Description -->
                    <p class="text-gray-700 text-sm leading-relaxed mt-2">
                        {{ $recipe->description ?? 'No Description' }}
                    </p>
                </div>

                @if(auth()->user()->id == $recipe->user_id)
                    <!-- Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-2 py-1 rounded-md font-semibold uppercase text-xs
                                        bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link href="{{ route('recipe.edit', $recipe) }}" wire:navigate>
                                Edit
                            </x-dropdown-link>

                            <x-dropdown-link class="text-red-500 hover:bg-red-100 hover:text-red-600 cursor-pointer"
                                x-data=""
                                x-on:click.prevent="$dispatch('delete-recipe', { recipeId: {{ $recipe->id }} })">
                                Delete
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                @endif
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-4 sm:divide-x text-center">
                {{-- Rating --}}
                <div class="space-y-1 p-2">
                    <div x-data="{
                                average_rating: {{ $recipe->rating ?? 0 }},
                                total: {{ $recipe->totalRatings() ?? 0 }},
                            }"
                        x-on:rating-updated.window="average_rating = $event.detail.average; total = $event.detail.total;"
                        class="flex justify-center items-center gap-1">

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="currentColor" class="size-5 text-yellow-400">
                            <path fill-rule="evenodd"
                                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" />
                        </svg>
                        
                        <p class="font-semibold text-xs text-gray-500">
                            <span class="text-lg text-gray-900" x-text="average_rating"></span>
                            (<span x-text="total"></span>)
                        </p>
                       
                    </div>

                    <p class="text-xs text-gray-500">Ratings</p>
                </div>

                {{-- category --}}
                <div class="space-y-1 p-2">
                    <div class="flex justify-center items-center gap-1">
                       
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-red-500">
                            <path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" />
                            <path fill-rule="evenodd" d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087Zm6.163 3.75A.75.75 0 0 1 10 12h4a.75.75 0 0 1 0 1.5h-4a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                        </svg>

                        <span class="font-semibold capitalize text-lg text-gray-900">{{ $recipe->category ?? 'Breakfast' }}</span>
                    </div>
                    <p class="text-xs text-gray-500">Category</p>
                </div>

                {{-- Cooking Time --}}
                <div class="space-y-1 p-2">
                    <div class="flex justify-center items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="currentColor" class="size-5 text-orange-500">
                            <path fill-rule="evenodd"
                                d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" />
                        </svg>
                        <span class="font-semibold text-lg text-gray-900">{{ $recipe->cooking_time }} min</span>
                    </div>
                    <p class="text-xs text-gray-500">Cooking Time</p>
                </div>

                {{-- Comments/People --}}
                <div class="space-y-1 p-2">
                    <div x-data="{
                                total_comment: {{ $recipe->comments->count() }},
                            }"
                            x-on:comment-updated.window="total_comment = $event.detail.total;"
                            class="flex justify-center items-center gap-1">
                        
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="currentColor" class="size-5 text-indigo-500">
                            <path fill-rule="evenodd"
                                d="M4.848 2.771A49.144 49.144 0 0 1 12 2.25c2.43 0 4.817.178 7.152.52 1.978.292 3.348 2.024 3.348 3.97v6.02c0 1.946-1.37 3.678-3.348 3.97-1.94.284-3.916.455-5.922.505a.39.39 0 0 0-.266.112L8.78 21.53A.75.75 0 0 1 7.5 21v-3.955a48.842 48.842 0 0 1-2.652-.316c-1.978-.29-3.348-2.024-3.348-3.965V6.741c0-1.946 1.37-3.68 3.348-3.97Z" />
                        </svg>
                        
                        <span class="font-semibold text-lg text-gray-900" x-text="`${total_comment} people`"></span>
                    </div>
                    <p class="text-xs text-gray-500">Comments</p>
                </div>
            </div>

        </div>


        <div class="bg-white rounded-2xl shadow p-5 space-y-6 text-center">
            <span class="font-semibold text-gray-800">If you like this recipe, don't hesitate to add your rating!</span>

            <div class="flex justify-center items-center gap-3">
                <img src="{{ asset('storage/'. $recipe->image) }}" class="w-10 h-10 rounded-full" alt="">
                
                <div class="flex flex-col">
                    <span class="font-semibold capitalize">{{ $recipe->title }}</span>
                    <span class="text-gray-500 text-sm capitalize">by {{ $recipe->user->name }}</span>
                </div>
            </div>

            {{-- star rating component --}}
            <livewire:recipe.recipe-rating :recipe="$recipe"/>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <!-- Ingredients -->
            <div class="col-span-2 md:col-span-1 bg-white rounded-2xl shadow p-5 space-y-4">
                <h2 class="text-lg font-semibold text-gray-800">Ingredients</h2>

                <div class="space-y-4 text-gray-700 max-h-64 overflow-y-auto">
                    @foreach ($recipe->ingredients as $i => $item)
                        <div class="flex justify-between items-center">
                            <label class="flex items-center gap-2">

                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-5 text-gray-700">
                                    <path fill-rule="evenodd"
                                        d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                        clip-rule="evenodd" />
                                </svg>

                                {{ $item }}
                            </label>

                        </div>
                    @endforeach

                </div>
            </div>

            <!-- Instructions -->
            <div class="col-span-2 bg-white rounded-2xl shadow p-5 space-y-4">
                <h2 class="font-semibold text-lg text-gray-800">Instructions</h2>

                <ul class="divide-y divide-gray-200 max-h-64 overflow-y-auto">
                    @foreach ($recipe->instructions as $i => $item)
                        <li class="py-3 flex justify-between items-start">
                            <span class="text-gray-700">{{ $i + 1 }}. {{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>

        <!-- Add Comments -->
        <livewire:recipe.recipe-comments :recipe="$recipe"/>

        {{-- delete modal --}}
        <livewire:recipe.delete-recipe-modal/>
    </div>

</x-app-layout>
