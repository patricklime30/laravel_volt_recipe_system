<?php

use Livewire\Volt\Component;
use App\Models\RecipeRating;

new class extends Component {
    public array $pieData = [];

    public function mount(){
        $userId = auth()->id();

        $avg_rating = RecipeRating::whereIn('recipe_id', function($query) use ($userId) {
                            $query->select('id')
                                ->from('recipes')
                                ->where('user_id', $userId);
                        })->avg('rating');

        $avg_satisfaction = $avg_rating/5*100;

        $pieData = [
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
            const labels = {!! json_encode(array_keys($pieData)) !!};
            const dataValues = {!! json_encode(array_values($pieData)) !!};

            const data = {
                labels: labels,
                datasets: [{
                    label: 'Satisfaction',
                    data: dataValues,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)', // Satisfied
                        'rgba(255, 99, 132, 0.7)'  // Unsatisfied
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            };

            const config = {
                type: 'doughnut', // doughnut chart
                data: data,
                options: {
                    responsive: true,
                    cutout: '50%',
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            };

            new Chart(
                document.getElementById('satisfactionPieChart'),
                config
            );
        </script>
    @endpush
</div>
