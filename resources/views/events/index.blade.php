<x-app-layout>
    <h2>Eventos</h2>

    @foreach ($events as $event)
    <div style ="border:1px solid #ccc; margin:10px; padding:10px;">
        <h3>{{$event->title}}</h3>
        <p>{{$event->description}}</p>
        <p>{{$event->event_date }}</p>
        <p>{{$event->location }}</p>
        <p>Capacidad: {{$event->capacity }}</p>
        <p><strong>Fecha:</strong> {{$event->event_date }}</p>
        <p><strong>Lugar:</strong> {{$event->location }}</p>
        <p><strong>Cupo:</strong> {{$event ->capacity }}</p>
        <p><strong>Estado:</strong> {{$event->status }}</p>
        

</div>
@endforeach

@if(auth()->user()->role === 'admin')
    <form method="POST" action="/events/{{ $event->id }}/approve">
        @csrf
        <button>Aprobar</button>
    </form>

    <form method="POST" action="/events/{{ $event->id }}/reject">
        @csrf
        <button>Rechazar</button>
    </form>
@endif

</x-app-layout>
