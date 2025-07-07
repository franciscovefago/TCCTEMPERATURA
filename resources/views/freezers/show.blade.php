<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalhes do Freezer
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <p><strong>Nome:</strong> {{ $freezer->numero }}</p>
            
            <h2><strong>Gráfico de Temperatura e Umidade:</strong></h2>
            <form method="GET" class="flex items-center space-x-4 my-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium">Data Inicial</label>
                    <input type="date" name="start_date" id="start_date"
                        value="{{ \Carbon\Carbon::parse($startDate)->format('Y-m-d') }}"
                        class="rounded border-gray-300" required>
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium">Data Final</label>
                    <input type="date" name="end_date" id="end_date"
                        value="{{ \Carbon\Carbon::parse($endDate)->format('Y-m-d') }}"
                        class="rounded border-gray-300" required>
                </div>
                <div class="pt-5">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        Filtrar
                    </button>
                </div>
            </form>

            <canvas id="chart" height="100"></canvas>

            <div class="mt-4 flex space-x-2">
                <a href="{{ route('freezers.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Voltar</a>
            </div>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = @json($labels);
        const temperaturas = @json($temperaturas);
        const umidades = @json($umidades);

        const ctx = document.getElementById('chart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Temperatura (ºC)',
                        data: temperaturas,
                        borderColor: 'rgb(255, 99, 132)',
                        fill: false,
                        tension: 0.4
                    },
                    {
                        label: 'Umidade (%)',
                        data: umidades,
                        borderColor: 'rgb(54, 162, 235)',
                        fill: false,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'Gráfico de Temperatura e Umidade'
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Data/Hora'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Valor'
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>