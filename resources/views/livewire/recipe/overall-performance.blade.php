<?php

use Livewire\Volt\Component;
use App\Models\Recipe;

new class extends Component {
    public array $labels = [];
     public array $data = [];

    public function mount(){
        $userId = auth()->id();

        $recipes = Recipe::where('user_id', $userId)
                        ->withCount('favorites')
                        ->orderByDesc('favorites_count')
                        ->take(5)
                        ->get();

        $this->labels = $recipes->pluck('title')->toArray();      // Recipe names
        $this->data = $recipes->pluck('favorites_count')->toArray(); // Number of favorites
                    
    }
}; ?>

<div>
    <h2 class="text-lg font-semibold mb-4">Performance</h2>

    <canvas id="performanceChart" class="w-full"></canvas>

    @push('scripts')
        <script>
        
            const dataLineChart = {
                labels: @json($labels),
                datasets: [
                    {
                        label: 'Top 5 Favorited Recipe',
                        data: @json($data),
                        backgroundColor: [
                            'rgba(255, 102, 0, 0.74)',
                        ],
                    }
                ]
            };

            const configLineChart = {
                type: 'line',
                data: dataLineChart,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                    }
                },
            };

            new Chart(document.getElementById('performanceChart'), configLineChart);
        </script>
    @endpush
</div>
