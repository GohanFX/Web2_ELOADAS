@extends('layouts.app')

@section('title', 'Diagramok')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-6">Formula 1 Statisztikák</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Drivers by Country Chart -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Top 10 ország pilóták szerint</h3>
                        <div style="height: 300px;">
                            <canvas id="driversByCountryChart"></canvas>
                        </div>
                    </div>

                    <!-- Races by Year Chart -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Versenyek évek szerint</h3>
                        <div style="height: 300px;">
                            <canvas id="racesByYearChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Top Drivers Chart -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4">Top 10 pilóta versenyek szerint</h3>
                    <div style="height: 400px;">
                        <canvas id="topDriversChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Drivers by Country - Pie Chart
    const driversByCountryCtx = document.getElementById('driversByCountryChart');
    new Chart(driversByCountryCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($driversByCountry->pluck('country')) !!},
            datasets: [{
                label: 'Pilóták száma',
                data: {!! json_encode($driversByCountry->pluck('total')) !!},
                backgroundColor: [
                    'rgba(99, 102, 241, 0.8)',
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(234, 179, 8, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(168, 85, 247, 0.8)',
                    'rgba(236, 72, 153, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(249, 115, 22, 0.8)',
                    'rgba(20, 184, 166, 0.8)',
                    'rgba(251, 146, 60, 0.8)'
                ],
                borderColor: [
                    'rgb(99, 102, 241)',
                    'rgb(34, 197, 94)',
                    'rgb(234, 179, 8)',
                    'rgb(239, 68, 68)',
                    'rgb(168, 85, 247)',
                    'rgb(236, 72, 153)',
                    'rgb(59, 130, 246)',
                    'rgb(249, 115, 22)',
                    'rgb(20, 184, 166)',
                    'rgb(251, 146, 60)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                }
            }
        }
    });

    // Races by Year - Line Chart
    const racesByYearCtx = document.getElementById('racesByYearChart');
    new Chart(racesByYearCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($racesByYear->pluck('year')) !!},
            datasets: [{
                label: 'Versenyek száma',
                data: {!! json_encode($racesByYear->pluck('total')) !!},
                backgroundColor: 'rgba(34, 197, 94, 0.2)',
                borderColor: 'rgb(34, 197, 94)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: 'rgb(34, 197, 94)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Top Drivers - Horizontal Bar Chart
    const topDriversCtx = document.getElementById('topDriversChart');
    new Chart(topDriversCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($topDrivers->pluck('name')) !!},
            datasets: [{
                label: 'Versenyek száma',
                data: {!! json_encode($topDrivers->pluck('results_count')) !!},
                backgroundColor: [
                    'rgba(99, 102, 241, 0.8)',
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(234, 179, 8, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(168, 85, 247, 0.8)',
                    'rgba(236, 72, 153, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(249, 115, 22, 0.8)',
                    'rgba(20, 184, 166, 0.8)',
                    'rgba(251, 146, 60, 0.8)'
                ],
                borderColor: [
                    'rgb(99, 102, 241)',
                    'rgb(34, 197, 94)',
                    'rgb(234, 179, 8)',
                    'rgb(239, 68, 68)',
                    'rgb(168, 85, 247)',
                    'rgb(236, 72, 153)',
                    'rgb(59, 130, 246)',
                    'rgb(249, 115, 22)',
                    'rgb(20, 184, 166)',
                    'rgb(251, 146, 60)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@endsection
