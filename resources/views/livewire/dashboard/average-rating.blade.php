<?php

use Livewire\Volt\Component;
use App\Models\Recipe;

new class extends Component {
    public $total = 0;

    public function mount(){
        $userId = auth()->id();

        $average = Recipe::where('user_id', $userId)->avg('rating');

        $this->total = round($average ?? 0, 2);                    
    }
}; ?>

<div class="max-w-xs bg-white rounded-lg shadow-sm px-5 py-3 border border-gray-200">

    <div class="flex items-center justify-between">
        <div class="flex gap-2 items-center text-gray-500 text-sm">
            <!-- Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
            </svg>
            
            <span>Average Rating</span>
        </div>

        <!-- Tooltip wrapper -->
        <div class="relative group">
            <!-- Info icon -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                class="size-4 cursor-pointer text-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
            </svg>

            <!-- Tooltip -->
            <div class="absolute right-0 mt-2 w-56 rounded-md bg-indigo-600 text-white text-xs p-2 opacity-0 
                        group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-20">
                
                <!-- Arrow -->
                <div class="absolute -top-1 right-2 w-2 h-2 bg-indigo-600 rotate-45"></div>
                
                Average all rating received by this user.
            </div>
        </div>
    </div>
    
    <div class="mt-2 flex items-center gap-3">
        <p class="text-3xl font-semibold text-gray-900">{{ $total }}</p>
    </div>

</div>