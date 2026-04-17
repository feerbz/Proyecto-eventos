<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Eventos disponibles
        </h2>
    </x-slot>

    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    @foreach ($events as $event)
        <div style="border:1px solid #ccc; margin:10px; padding:10px;">
            <h3>{{ $event->title }}</h3>
            <p>{{ $event->description }}</p>
            <p><strong>Fecha:</strong> {{ $event->event_date }}</p>
            <p><strong>Lugar:</strong> {{ $event->location }}</p>
        </div>
    @endforeach

</x-app-layout>
