<x-app-layout>
    <h2>Mis eventos</h2>

    @foreach ($events as $event)
        <div style="border:1px solid #ccc; margin:10px; padding:10px;">
            <h3>{{ $event->title }}</h3>
            <p>{{ $event->description }}</p>
            <p>Estado: {{ $event->status }}</p>

            <a href="/events/{{ $event->id }}/edit">Editar</a>

            <form method="POST" action="/events/{{ $event->id }}">
                @csrf
                @method('DELETE')
                <button>Eliminar</button>
            </form>
        </div>
    @endforeach
</x-app-layout>