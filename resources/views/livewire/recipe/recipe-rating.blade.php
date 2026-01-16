<?php

use Livewire\Volt\Component;
use App\Models\Recipe;
use App\Notifications\RecipeCommentOrRatingNotification;

new class extends Component {
    public Recipe $recipe;
    public int $rating = 0;

    public function mount(Recipe $recipe)
    {
        $this->recipe = $recipe;

        $this->rating = $this->recipe->ratings()
                            ->where('user_id', auth()->id())
                            ->first()->rating ?? 0;
    }

    public function setRating($value)
    {
        // update the rating value
        $this->rating = $value;
        
        // Create or update user's rating
        $this->recipe->ratings()->updateOrCreate(
            [
                'user_id' => auth()->id()
            ],
            [   
                'rating' => $value
            ]
        );

        // Recalculate totals
        $avg = $this->recipe->averageRating();
        $count = $this->recipe->totalRatings();

        // Save final average into recipes table
        $this->recipe->update([
            'rating' => $avg
        ]);

        $this->recipe->user->notify(new RecipeCommentOrRatingNotification($this->recipe, auth()->user(), 'rating'));

        // Send event to page
        $this->dispatch('rating-updated', average: $avg, total: $count);
    }
}; ?>

<div class="flex items-center justify-center gap-1">

    @for ($i = 1; $i <= 5; $i++)
        <button wire:click="setRating({{ $i }})"
            class="transition transform hover:scale-110 focus:outline-none">
            @if ($i <= $rating)
                <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.285 3.97a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.387 2.46a1 1 0 00-.364 1.118l1.286 3.97c.3.922-.755 1.688-1.538 1.118L10 14.347l-3.95 2.916c-.783.57-1.838-.196-1.539-1.118l1.286-3.97a1 1 0 00-.364-1.118L1.796 9.397c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.285-3.97z" />
                </svg>
            @else
                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11.48 3.499a.562.562 0 011.04 0l2.123 4.768a.563.563 0 00.475.326l5.127.35a.563.563 0 01.323.986l-3.905 3.555a.563.563 0 00-.182.54l1.18 4.99a.562.562 0 01-.84.61l-4.38-2.69a.563.563 0 00-.586 0l-4.38 2.69a.563.563 0 01-.84-.61l1.18-4.99a.563.563 0 00-.182-.54L2.43 9.93a.563.563 0 01.323-.986l5.127-.35a.563.563 0 00.475-.326l2.123-4.768z" />
                </svg>
            @endif
        </button>
    @endfor
</div>