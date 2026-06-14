<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 dark:text-white tracking-tighter">
            Métricas del <span class="text-emerald-600">Sistema</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Acciones --}}
            <div class="flex gap-3 mb-8">
                <a href="/metricas/exportar" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg shadow-emerald-500/20 transition-all">Exportar CSV</a>
                <a href="/metricas/pdf" class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-lg shadow-red-500/20 transition-all">Exportar PDF</a>
            </div>

            {{-- Grid de Tarjetas --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                @php
                    $stats = [
                        ['label' => 'Eventos', 'value' => $totalEvents],
                        ['label' => 'Aprobados', 'value' => $approvedEvents],
                        ['label' => 'Pendientes', 'value' => $pendingEvents],
                        ['label' => 'Usuarios', 'value' => $totalUsers],
                        ['label' => 'Inscripciones', 'value' => $totalRegistrations],
                        ['label' => 'Lista de Espera', 'value' => $totalWaitlist],
                        ['label' => 'Asistencias', 'value' => $totalAttendances],
                        ['label' => '% Asistencia', 'value' => $attendanceRate . '%'],
                    ];
                @endphp
                @foreach($stats as $stat)
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ $stat['label'] }}</h3>
                        <p class="text-3xl font-black text-gray-900 dark:text-white mt-2">{{ $stat['value'] }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Tabla de Asistencia --}}
            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 mb-10">
                <h3 class="text-xl font-black text-gray-900 dark:text-white mb-6">Asistencia por Evento</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-gray-400 uppercase text-xs font-bold tracking-wider">
                                <th class="pb-4">Evento</th>
                                <th class="pb-4 text-center">Registrados</th>
                                <th class="pb-4 text-center">Asistencias</th>
                                <th class="pb-4 text-center">% Asistencia</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($eventMetrics as $event)
                                @php $percent = $event->registrations_count > 0 ? round(($event->attendances_count * 100) / $event->registrations_count, 2) : 0; @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="py-4 font-bold text-gray-900 dark:text-white">{{ $event->title }}</td>
                                    <td class="py-4 text-center">{{ $event->registrations_count }}</td>
                                    <td class="py-4 text-center">{{ $event->attendances_count }}</td>
                                    <td class="py-4 text-center font-black {{ $percent >= 80 ? 'text-emerald-600' : ($percent >= 50 ? 'text-amber-500' : 'text-red-600') }}">
                                        {{ $percent }}%
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Gráfica --}}
            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700">
                <h3 class="text-xl font-black text-gray-900 dark:text-white mb-6">Porcentaje de Asistencia por Evento</h3>
                <canvas id="attendanceChart" class="max-h-[400px]"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('attendanceChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Asistencia (%)',
                    data: @json($chartData),
                    backgroundColor: '#059669',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, max: 100 } }
            }
        });
    </script>
</x-app-layout>