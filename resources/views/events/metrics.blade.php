<x-app-layout>

<div class="max-w-6xl mx-auto p-6">

    <h2 class="text-2xl font-bold mb-6">
        Métricas del Sistema
    </h2>
    <a
    href="/metricas/exportar"
    class="bg-emerald-600 text-white px-4 py-2 rounded-xl inline-block mb-6">

    Exportar CSV

</a>

<a
    href="/metricas/pdf"
    class="bg-red-600 text-white px-4 py-2 rounded-xl inline-block mb-6 ml-2">

    Exportar PDF

</a>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-gray-500">Eventos</h3>
            <p class="text-3xl font-bold">
                {{ $totalEvents }}
            </p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-gray-500">Aprobados</h3>
            <p class="text-3xl font-bold">
                {{ $approvedEvents }}
            </p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-gray-500">Pendientes</h3>
            <p class="text-3xl font-bold">
                {{ $pendingEvents }}
            </p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-gray-500">Usuarios</h3>
            <p class="text-3xl font-bold">
                {{ $totalUsers }}
            </p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-gray-500">Inscripciones</h3>
            <p class="text-3xl font-bold">
                {{ $totalRegistrations }}
            </p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-gray-500">Lista de Espera</h3>
            <p class="text-3xl font-bold">
                {{ $totalWaitlist }}
            </p>
        </div>
        <div class="bg-white rounded-xl shadow p-6">
    <h3 class="text-gray-500">
        Asistencias
    </h3>

    <p class="text-3xl font-bold">
        {{ $totalAttendances }}
    </p>
</div>

<div class="bg-white rounded-xl shadow p-6">
    <h3 class="text-gray-500">
        % Asistencia
    </h3>

    <p class="text-3xl font-bold">
        {{ $attendanceRate }}%
    </p>
</div>

</div>


    </div>
    <div class="mt-8">

    <h3 class="text-xl font-bold mb-4">
        Asistencia por Evento
    </h3>

    <table class="w-full border">

        <thead>

            <tr class="bg-gray-100">

                <th class="p-2">Evento</th>
                <th class="p-2">Registrados</th>
                <th class="p-2">Asistencias</th>
                <th class="p-2">% Asistencia</th>

            </tr>

        </thead>

        <tbody>

        @foreach($eventMetrics as $event)

            <tr class="border-t">

                <td class="p-2">
                    {{ $event->title }}
                </td>

                <td class="p-2">
                    {{ $event->registrations_count }}
                </td>
                <td class="p-2">

    @php

        $percent = $event->registrations_count > 0
            ? round(
                ($event->attendances_count * 100)
                / $event->registrations_count,
                2
            )
            : 0;

    @endphp

    <span class="
        {{ $percent >= 80
            ? 'text-green-600 font-bold'
            : ($percent >= 50
                ? 'text-yellow-600 font-bold'
                : 'text-red-600 font-bold')
        }}
    ">

        {{ $percent }}%

    </span>

</td>
                    <td class="p-2">

                    {{ $event->registrations_count > 0
                        ? round(($event->attendances_count * 100) / $event->registrations_count, 2)
                        : 0
                    }}%

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>
<div class="mt-8">

    <h3 class="text-xl font-bold mb-4">
        Porcentaje de Asistencia por Evento
    </h3>

    <canvas id="attendanceChart"></canvas>

</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

const ctx = document.getElementById('attendanceChart');

new Chart(ctx, {

    type: 'bar',

    data: {

        labels: @json($chartLabels),

        datasets: [{

            label: 'Asistencia (%)',

            data: @json($chartData)

        }]

    },

    options: {

        scales: {

            y: {

                beginAtZero: true,

                max: 100

            }

        }

    }

});

</script>

</x-app-layout>