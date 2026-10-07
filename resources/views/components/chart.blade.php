@props([
    'id',
    'type' => 'bar',
    'data' => '{}',
    'options' => '{}',
])

<div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
    <canvas id="{{ $id }}" class="max-h-96"></canvas>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('{{ $id }}').getContext('2d');
    const data = @json($data);
    const options = @json($options);
    new Chart(ctx, {
        type: '{{ $type }}',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    rtl: true,
                    position: 'bottom',
                    labels: {
                        font: {
                            family: 'Vazirmatn',
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        font: {
                            family: 'Vazirmatn',
                        }
                    }
                },
                y: {
                    ticks: {
                        font: {
                            family: 'Vazirmatn',
                        }
                    }
                }
            },
            ...options
        }
    });
});
</script>
@endpush
