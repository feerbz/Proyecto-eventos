<x-app-layout>
    <h2>Crear evento</h2>

    <form method="POST" action="/events">
        @csrf 
        
        <input type="text" name="title" placeholder="Título"><br>
        <textarea name="description" placeholder="Descripción"></textarea><br>
        <input type="datetime-local" name="event_date"><br>
        <input type="text" name="location" placeholder="Lugar"><br>
        <input type="number" name="capacity" placeholder="Capacidad"><br>
        <p>Usuario actual: {{auth()->user()->email}}</p>
        <p>ID:{{auth()->id()}}</p>

        <button type="submit">Crear evento</button>
    </form>
</x-app-layout>