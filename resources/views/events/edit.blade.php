<x-app-layout>
    <h2>Editar evento</h2>

    <form method="POST" action="/events/{{ $event->id }}">
        @csrf
        @method('PUT')

        <input type="text" name="title" value="{{ $event->title }}" placeholder="Título"><br>

        <textarea name="description" placeholder="Descripción">{{ $event->description }}</textarea><br>

        <input type="datetime-local" name="event_date"
            value="{{ \Carbon\Carbon::parse($event->event_date)->format('Y-m-d\TH:i') }}">
        <br>

        <input type="text" name="location" value="{{ $event->location }}" placeholder="Lugar"><br>

        <input type="number" name="capacity" value="{{ $event->capacity }}" placeholder="Capacidad"><br>

        <button type="submit">Actualizar</button>
    </form>
</x-app-layout>