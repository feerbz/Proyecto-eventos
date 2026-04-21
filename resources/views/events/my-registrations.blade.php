<x-app-layout>
    <x-slot name="header">
        <h2>Mis inscripciones</h2>
    </x-slot>

    @foreach($registrations as $reg)

        <div style="border:1px solid #ccc; margin:10px; padding:10px;">
            <h3>{{ $reg->event->title }}</h3>
            <p>{{ $reg->event->description }}</p>
            <p><strong>Fecha:</strong> {{ $reg->event->event_date }}</p>
            <p><strong>Lugar:</strong> {{ $reg->event->location }}</p>

            <form method="POST" action="/events/{{ $reg->event->id }}/unregister">
                @csrf
                @method('DELETE')

                <button onclick="return confirm('¿Cancelar inscripción?')">
                    Cancelar inscripción
                </button>
            </form>

        </div>

    @endforeach

</x-app-layout>