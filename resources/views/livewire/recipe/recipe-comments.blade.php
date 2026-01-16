<?php

use Livewire\Volt\Component;
use App\Models\Recipe;
use App\Notifications\RecipeCommentOrRatingNotification;

new class extends Component {
    public Recipe $recipe;

    public string $message = '';
    public bool $showAll = false;
    public int $limit = 3;

    // mount() runs once, polling does not re-run it
    public function mount(Recipe $recipe)
    {
        $this->recipe = $recipe;
    }

    public function getCommentsProperty()
    {
        $query = $this->recipe->comments()->latest();

        if (! $this->showAll) {
            $query->take($this->limit);
        }

        return $query->get();
    }

    public function getTotalCommentsProperty(): int
    {
        return $this->recipe->comments()->count();
    }

    public function showMore(){
        $this->showAll = true;
    }

    public function saveComments(){
        $this->recipe->comments()->create([
                'user_id' => auth()->id(),
                'message' => $this->message
            ]);

        $this->reset('message');

        $this->recipe->user->notify(new RecipeCommentOrRatingNotification($this->recipe, auth()->user(), 'comment'));

        // Send event to page
        $this->dispatch('comment-updated', total: $this->getTotalCommentsProperty());
    }
}; ?>

<div wire:poll.10s class="relative bg-white rounded-2xl shadow p-5 space-y-6">
    <!-- Comments Header -->
    <h2 class="text-lg font-semibold mb-4 text-gray-800">
        Comments 
        <span class="text-white text-xs ml-2 rounded-full bg-indigo-400 px-2">{{ $this->totalComments }}</span>
    </h2>

    <!-- Comment List -->
    <div class="relative space-y-8 {{ $showAll ? 'max-h-64 overflow-y-auto' : '' }}">
        @forelse($this->comments as $comment)
            <!-- Comment -->
            <div class="flex gap-3">
                <!-- <img src="https://i.pravatar.cc/40?img=1" class= alt=""> -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 rounded-full text-gray-700">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                
                <div class="flex-1">
                    <div class="flex items-center gap-2">
                        <span class="font-semibold capitalize">{{ $comment->user->name }}</span>
                        <span class="text-gray-500 text-sm">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>

                    <p class="mt-1 text-gray-700">
                        {{ $comment->message }}
                    </p>

                </div>
            </div>
        @empty
            <span class="text-gray-500 text-sm">No data found</span>
        @endforelse

        @if($this->totalComments > 3)
            <!-- Show More -->
            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 z-50">
                @if(!$showAll)
                    <a wire:click="showMore" 
                        class="text-indigo-600 hover:text-indigo-700 text-xs uppercase font-semibold transition inline-flex gap-2 cursor-pointer">
                        Show More
                        
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>

                    </a>
                @endif
            </div>
        @endif
    </div>

    <div class="border-t text-gray-300"></div>

    <div>
        <form wire:submit="saveComments">
            <textarea wire:model="message" id="comments" rows="3"
                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                name="comments" placeholder="Write your comment"></textarea>

            <div class="flex justify-end mt-3">
                <x-primary-button>
                    Send

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-4 ml-2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                    </svg>

                </x-primary-button>
            </div>
        </form>
    </div>
</div>
