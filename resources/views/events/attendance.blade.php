<x-app-layout>

<div class="max-w-2xl mx-auto p-6">

    <h2 class="text-2xl font-bold mb-6">
        Registrar asistencia
    </h2>

    <p class="mb-4">
        Evento: {{ $event->title }}
    </p>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST">

        @csrf

        <label class="block mb-2">
            Correo del asistente
        </label>

        <input
            type="email"
            name="email"
            required
            class="w-full rounded-xl border-gray-300 mb-4">

        <button
            class="bg-emerald-600 text-white px-4 py-2 rounded-xl">

            Registrar asistencia

        </button>

    </form>

</div>

</x-app-layout>