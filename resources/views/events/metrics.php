<x-app-layout>

<div class="max-w-6xl mx-auto p-6">

    <h2 class="text-2xl font-bold mb-6">
        Métricas del Sistema
    </h2>

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

</div>

</x-app-layout>