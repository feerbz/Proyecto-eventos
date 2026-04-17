<x-app-layout>
    <h2>Eventos pendientes</h2>

    @foreach ($events as $event)
        <div style="border:1px solid #ccc; margin:10px; padding:10px;">
            <h3>{{ $event->title }}</h3>
            <p>{{ $event->description }}</p>

            <form method="POST" action="/events/{{ $event->id }}/approve">
                @csrf
                <button>Aprobar</button>
            </form>

            <form method="POST" action="/events/{{ $event->id }}/reject">
                @csrf
                <button>Rechazar</button>
            </form>
        </div>
    @endforeach
</x-app-layout>