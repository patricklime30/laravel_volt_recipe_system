@props([
    'recipes',
    'showActions' => true,
    'authUser' => null,
    'showReports' => false,
])

<div class="overflow-x-auto border rounded-lg shadow-md mt-4">
    <table class="w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr class="text-center text-xs font-medium text-gray-500 uppercase">
                <th class="px-4 py-2">Image</th>
                <th class="px-4 py-2">Title</th>
                <th class="px-4 py-2">Cooking Time</th>
                <th class="px-4 py-2">Rating</th>

                @if($showReports)
                    <th class="px-4 py-2">Satisfaction %</th>
                    <th class="px-4 py-2">Comments</th>
                @endif

                <th class="px-4 py-2 sticky right-0 z-10 bg-gray-50">Action</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($this->recipes as $recipe)
                <tr class="text-center">
                    <td class="px-4 py-2">
                        <img src="{{ asset('storage/'. $recipe->image) }}" class="h-16 w-16 rounded object-cover mx-auto"/>
                    </td>
                    <td class="px-4 py-2 font-medium text-gray-900">{{ $recipe->title }}</td>
                    <td class="px-4 py-2 text-gray-600">
                        <div class="flex items-center justify-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="currentColor" class="size-5 text-orange-500">
                                <path fill-rule="evenodd"
                                    d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" />
                            </svg> 
                            {{ $recipe->cooking_time }} mins
                        </div>
                    </td>
                    <td class="px-4 py-2 text-gray-600">
                        <div class="flex items-center justify-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="currentColor" class="size-5 text-yellow-400">
                                <path fill-rule="evenodd"
                                    d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" />
                            </svg>
                
                            {{ $recipe->rating ?? 0}}
                        </div>
                    </td>

                    @if($showReports)
                        
                        @php
                            $satisfaction_percentage = $recipe->rating/5*100;
                        @endphp

                        <td class="px-4 py-2 text-gray-600">
                            <div class="flex items-center justify-center gap-1">
                               
                                @if($satisfaction_percentage >= 60)
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" 
                                        fill="currentColor" class="size-5 text-green-400">
                                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-2.625 6c-.54 0-.828.419-.936.634a1.96 1.96 0 0 0-.189.866c0 .298.059.605.189.866.108.215.395.634.936.634.54 0 .828-.419.936-.634.13-.26.189-.568.189-.866 0-.298-.059-.605-.189-.866-.108-.215-.395-.634-.936-.634Zm4.314.634c.108-.215.395-.634.936-.634.54 0 .828.419.936.634.13.26.189.568.189.866 0 .298-.059.605-.189.866-.108.215-.395.634-.936.634-.54 0-.828-.419-.936-.634a1.96 1.96 0 0 1-.189-.866c0-.298.059-.605.189-.866Zm2.023 6.828a.75.75 0 1 0-1.06-1.06 3.75 3.75 0 0 1-5.304 0 .75.75 0 0 0-1.06 1.06 5.25 5.25 0 0 0 7.424 0Z" clip-rule="evenodd" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" 
                                        fill="currentColor" class="size-5 text-red-400">
                                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-2.625 6c-.54 0-.828.419-.936.634a1.96 1.96 0 0 0-.189.866c0 .298.059.605.189.866.108.215.395.634.936.634.54 0 .828-.419.936-.634.13-.26.189-.568.189-.866 0-.298-.059-.605-.189-.866-.108-.215-.395-.634-.936-.634Zm4.314.634c.108-.215.395-.634.936-.634.54 0 .828.419.936.634.13.26.189.568.189.866 0 .298-.059.605-.189.866-.108.215-.395.634-.936.634-.54 0-.828-.419-.936-.634a1.96 1.96 0 0 1-.189-.866c0-.298.059-.605.189-.866Zm-4.34 7.964a.75.75 0 0 1-1.061-1.06 5.236 5.236 0 0 1 3.73-1.538 5.236 5.236 0 0 1 3.695 1.538.75.75 0 1 1-1.061 1.06 3.736 3.736 0 0 0-2.639-1.098 3.736 3.736 0 0 0-2.664 1.098Z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                    
                                {{ $satisfaction_percentage }} %
                            </div>
                        </td>

                        <td class="px-4 py-2 text-gray-600">
                            <div class="flex items-center justify-center gap-1">
                               
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="currentColor" class="size-5 text-indigo-500">
                                    <path fill-rule="evenodd"
                                        d="M4.848 2.771A49.144 49.144 0 0 1 12 2.25c2.43 0 4.817.178 7.152.52 1.978.292 3.348 2.024 3.348 3.97v6.02c0 1.946-1.37 3.678-3.348 3.97-1.94.284-3.916.455-5.922.505a.39.39 0 0 0-.266.112L8.78 21.53A.75.75 0 0 1 7.5 21v-3.955a48.842 48.842 0 0 1-2.652-.316c-1.978-.29-3.348-2.024-3.348-3.965V6.741c0-1.946 1.37-3.68 3.348-3.97Z" />
                                </svg>
                    
                                {{ $recipe->comments->count() }}
                            </div>
                        </td>
                    @endif
                    
                    @if($showActions)
                        <td class="px-4 py-2 sticky right-0 z-10 bg-gray-50 space-y-1">
                            <a href="{{ route('recipe.show', $recipe) }}" wire:navigate
                                class="inline-flex items-center gap-1 px-3 py-1 rounded-md bg-white border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs font-semibold transition">
                                View
                            </a>
                            
                            @if($authUser && $authUser->id == $recipe->user_id)
                                <a href="{{ route('recipe.edit', $recipe) }}" wire:navigate
                                    class="inline-flex items-center gap-1 px-3 py-1 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold transition">
                                    Edit
                                </a>

                                <a x-data=""
                                    x-on:click.prevent="$dispatch('delete-recipe', { recipeId: {{ $recipe->id }} })"
                                    class="inline-flex items-center gap-1 px-3 py-1 rounded-md bg-red-600 hover:bg-red-700 text-white text-xs font-semibold transition cursor-pointer">
                                    Delete
                                </a>
                            @endif
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-400">No recipes found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>