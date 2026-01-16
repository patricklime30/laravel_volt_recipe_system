<?php

use Livewire\Volt\Component;
use App\Models\Recipe;

new class extends Component {
    public $thisWeekData = [];
    public $lastWeekData = [];
    public $total = 0;
    public $increase = 0;

    public function mount()
    {
        $userId = Auth::id();

        // this week
        $this->thisWeekData = Recipe::selectRaw('DATE(created_at) as day, COUNT(*) as count')
                                ->where('user_id', $userId)
                                ->where('created_at', '>=', now()->subDays(7))
                                ->groupBy('day')
                                ->orderBy('day')
                                ->pluck('count', 'day')
                                ->toArray();

        // last week
        $this->lastWeekData = Recipe::selectRaw('DATE(created_at) as day, COUNT(*) as count')
                                ->where('user_id', $userId)
                                ->whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])
                                ->groupBy('day')
                                ->orderBy('day')
                                ->pluck('count', 'day')
                                ->toArray();

        // Total recipes count for user
        $this->total = Recipe::where('user_id', $userId)->count();

        // Calculate increase percentage between total this week vs last week
        $thisWeekTotal = array_sum($this->thisWeekData);
        $lastWeekTotal = array_sum($this->lastWeekData);

        if ($lastWeekTotal > 0) {
            $this->increase = round(($thisWeekTotal - $lastWeekTotal) / $lastWeekTotal * 100);
        }
        else {
            $this->increase = $thisWeekTotal > 0 ? 100 : 0; // handle case when previous week was zero
        }
    }

}; ?>

<div class="max-w-xs bg-white rounded-lg shadow-sm px-5 py-3 border border-gray-200">

    <div class="flex items-center justify-between">
        <div class="flex gap-2 items-center text-gray-500 text-sm">
            <!-- Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
            </svg>
            
            <span>Total Recipes</span>
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
                
                Total recipes uploaded this week by this user.
            </div>
        </div>
    </div>
    
    <div class="mt-2 flex items-center gap-3">
        <p class="text-3xl font-semibold text-gray-900">{{ $total }}</p>
        
        <span class="inline-flex items-center gap-1 text-xs px-2 py-1 rounded-md {{ $increase > 0 ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
            {{ $increase }}%

            <!-- Icon -->
            @if($increase > 0)
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                </svg>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6 9 12.75l4.286-4.286a11.948 11.948 0 0 1 4.306 6.43l.776 2.898m0 0 3.182-5.511m-3.182 5.51-5.511-3.181" />
                </svg>
            @endif
        </span>
    </div>

</div>