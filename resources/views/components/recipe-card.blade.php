@props([
    'recipe',
    'showStats' => true,
    'showActions' => true,
])

<div class='bg-white rounded-lg border p-4 shadow-sm overflow-hidden hover:shadow-lg transition flex flex-col'>

    <img src="{{ asset('storage/'. $recipe->image) }}" 
        class="rounded mb-4 w-full h-48 object-cover"/>

    <h3 class="font-bold text-lg truncate">{{ $recipe->title }}</h3>

    @if($showStats)
        <div class="mt-2 flex justify-between text-sm text-gray-600">
            <span class="flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                    fill="currentColor" class="size-4 text-orange-500">
                    <path fill-rule="evenodd"
                        d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" />
                </svg>
                
                {{ $recipe->cooking_time }} mins
            </span>
            <span class="flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                    fill="currentColor" class="size-4 text-yellow-400">
                    <path fill-rule="evenodd"
                        d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" />
                </svg>

                {{ $recipe->rating ?? 0 }}
            </span>
        </div>
    @endif

    <!-- Optional: short preview of ingredients -->
    @if(!empty($recipe->description))
        <p class="text-gray-500 text-sm mt-2 line-clamp-2">
            {{ Str::limit($recipe->description, 80) }}
        </p>
    @else
        <p class="text-gray-500 text-sm mt-2 line-clamp-2 italic">
            No Description
        </p>
    @endif

    <!-- Details button -->
    @if($showActions)
        <div class="mt-6 text-center flex justify-between items-center pt-3">
            <a href="{{ route('recipe.show', $recipe) }}" wire:navigate
                class="text-indigo-600 hover:text-indigo-700 text-xs uppercase font-semibold transition">
                Read More
            </a>

            <div class="text-sm flex items-center">
                <livewire:recipe.recipe-favorite-button :recipe="$recipe" wire:key="recipe-{{ $recipe->id }}"/>
            </div>
    
        </div>
    @endif
</div>