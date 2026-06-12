<x-app-layout>

<div class="max-w-5xl mx-auto p-6">

    <h2 class="text-2xl font-bold mb-6">
        Control de asistencia
    </h2>

    @forelse($events as $event)

        <div class="border rounded-xl p-4 mb-4">

            <h3 class="font-bold text-lg">
                {{ $event->title }}
            </h3>

            <p>
                {{ $event->event_date }}
            </p>

            <a
                href="/events/{{ $event->id }}/attendance"
                class="bg-blue-600 text-white px-4 py-2 rounded-xl inline-block mt-3">

                Registrar asistencia

            </a>

        </div>

    @empty

        <p>
            No tienes eventos programados para hoy.
        </p>

    @endforelse

</div>

</x-app-layout>