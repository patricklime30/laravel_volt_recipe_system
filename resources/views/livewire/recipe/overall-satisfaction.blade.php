<?php

use Livewire\Volt\Component;
use App\Models\Recipe;

new class extends Component {
    public array $pieData = [];

    public function mount(){
        $userId = auth()->id();

        $avg_rating = Recipe::where('user_id', $userId)->avg('rating');

        $avg_satisfaction = $avg_rating/5*100;

        $this->pieData = [
            'Satisfied' => round($avg_satisfaction ?? 0, 2),
            'Unsatisfied' => round((100 - $avg_satisfaction) ?? 0, 2)
        ];
                    
    }
}; ?>

<div>
    <h2 class="text-lg font-semibold mb-4">Overall Satisfaction</h2>

    <canvas id="satisfactionPieChart"></canvas>

    @push('scripts')
        <script>
        
            const dataDonutChart = {
                labels: @json(array_keys($pieData)),
                datasets: [
                    {
                        label: 'Satisfaction',
                        data: @json(array_values($pieData)),
                        backgroundColor: [
                            'rgba(78, 70, 229, 0.8)', // Satisfied
                            'rgba(220, 38, 38, 0.9)'  // Unsatisfied
                        ],
                    }
                ]
            };

            const configDonutChart = {
                type: 'doughnut',
                data: dataDonutChart,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                    }
                },
            };

            new Chart(document.getElementById('satisfactionPieChart'), configDonutChart);
        </script>
    @endpush
</div>
