<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @if (session('success'))
    <div style="color: green;">
        {{session('success')}}
</div>
@endif
    <form method="POST" action="/events">
    @csrf 
    <input type="text" name ="title" placeholder ="Título"><br>
    <textarea name="description" placeholder="Descripción"></textarea><br>
    <input type="datetime-local" name="event_date"><br>
    <input type="text" name="location" placeholder="Lugar"><br>
    <input type="number" name="capacity" placeholder="Capacidad"><br>

    <button type="submit">Crear evento</button>
</form>
</x-app-layout>
