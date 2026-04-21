<x-app-layout>
    <x-slot name="header">
        <h2>Eventos disponibles</h2>
    </x-slot>

    {{-- Mensajes --}}
    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="color: red;">
            {{ session('error') }}
        </div>
    @endif

    <p>Total eventos: {{ count($events) }}</p>

    {{-- Lista de eventos --}}
    @foreach ($events as $event)

        @php
            $inscrito = \App\Models\Registration::where('user_id', auth()->id())
                ->where('event_id', $event->id)
                ->exists();

            $total = \App\Models\Registration::where('event_id', $event->id)->count();
        @endphp

        <div style="border:1px solid #ccc; margin:10px; padding:10px;">
            <h3>{{ $event->title }}</h3>
            <p>{{ $event->description }}</p>
            <p><strong>Fecha:</strong> {{ $event->event_date }}</p>
            <p><strong>Lugar:</strong> {{ $event->location }}</p>

            {{-- Cupo --}}
            <p>
                Cupo: {{ $total }} / {{ $event->capacity }}
            </p>

            {{-- Estado --}}
            @if($inscrito)

                <span style="background: green; color: white; padding: 5px 10px; border-radius: 5px;">
                    Inscrito
                </span>

                <form method="POST" action="/events/{{ $event->id }}/unregister">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('¿Cancelar inscripción?')">
                        Cancelar inscripción
                    </button>
                </form>

            @elseif($total >= $event->capacity)

                <p style="color:red;">Evento lleno</p>

            @else

                <form method="POST" action="/events/{{ $event->id }}/register">
                    @csrf
                    <button>Inscribirme</button>
                </form>

            @endif

        </div>

    @endforeach

</x-app-layout>
