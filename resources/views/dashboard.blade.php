<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-gray-800 dark:text-white tracking-tighter">
                    Cartelera <span class="text-emerald-600">Universitaria</span>
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">
                    Descubre los próximos eventos en tu comunidad.
                </p>
            </div>

            <a href="/events/create"
               class="inline-flex items-center justify-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-emerald-500/20 active:scale-95">
                + Proponer Evento
            </a>
        </div>
    </x-slot>

    {{-- MENSAJES --}}
    @if (session('success'))
        <div class="max-w-7xl mx-auto px-4 mt-6">
            <div class="bg-emerald-50 dark:bg-emerald-900/30 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm">
                <p class="text-emerald-800 dark:text-emerald-300 font-bold text-sm">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="max-w-7xl mx-auto px-4 mt-6">
            <div class="bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm">
                <p class="text-red-800 dark:text-red-300 font-bold text-sm">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('dashboard') }}" class="mb-6">

    <label class="block text-sm font-medium mb-2">
        Filtrar por categoría
    </label>

    <select
        name="category"
        onchange="this.form.submit()"
        class="rounded-xl border-gray-300"
    >
        <option value="">Todas las categorías</option>

        @foreach($categories as $category)
            <option
                value="{{ $category->id }}"
                {{ request('category') == $category->id ? 'selected' : '' }}
            >
                {{ $category->name }}
            </option>
        @endforeach

    </select>

</form>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

@forelse ($events as $event)

@php
    $inscrito = \App\Models\Registration::where('user_id', auth()->id())
        ->where('event_id', $event->id)
        ->exists();

    $enEspera = \App\Models\Waitlist::where('user_id', auth()->id())
        ->where('event_id', $event->id)
        ->exists();

    $total = \App\Models\Registration::where('event_id', $event->id)->count();
    $enListaEspera = \App\Models\Waitlist::where('user_id', auth()->id())
    ->where('event_id', $event->id)
    ->exists();
@endphp

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border p-6 flex flex-col">

        <span class="text-xs text-emerald-600 mb-2">
            {{ $event->location ?? $event->space?->name }}
        </span>

        {{-- IMAGEN --}}
        @if($event->image)
            <img src="/event-image/{{ $event->id }}"
                class="w-full h-40 object-cover rounded-xl mb-4">
        @endif

        <h3 class="text-lg font-bold">
            {{ $event->title }}
        </h3>
        @if($event->categories->count())
    <div class="flex flex-wrap gap-2 mt-2">
        @foreach($event->categories as $category)
            <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">
                {{ $category->name }}
            </span>
        @endforeach
    </div>
@endif
        {{-- AUTOR --}}
        <p class="text-xs text-gray-400 mb-2">
            Creado por: {{ $event->user->name }}
        </p>

        <p class="text-sm text-gray-500 mb-3">
            {{ $event->description }}
        </p>

        <p class="text-sm mb-2">
            📅 {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y h:i A') }}
        </p>
        <p class="text-sm mb-4">
    👥 
@if(
    ($event->space && $event->space->is_unlimited)
    || is_null($event->capacity)
)
    ∞ ILIMITADO
@else
    {{ $total }} / {{ $event->capacity }}
@endif
</p>
        {{-- BOTONES --}}
@if($inscrito)

    <form method="POST" action="/events/{{ $event->id }}/unregister">
        @csrf
        @method('DELETE')
        <button class="bg-red-500 text-white px-3 py-1 rounded">
            Cancelar inscripción
        </button>
    </form>

@elseif($enEspera)

    <form method="POST" action="/events/{{ $event->id }}/waitlist">
        @csrf
        @method('DELETE')

 <button class="bg-red-500 text-white px-3 py-1 rounded border border-black">
    Salir de lista de espera
</button>
    </form>

@elseif(
    !is_null($event->capacity)
    && !$event->space?->is_unlimited
    && $total >= $event->capacity
)

    <form method="POST" action="/events/{{ $event->id }}/waitlist">
        @csrf
        <button class="bg-green-600 text-white px-3 py-1 rounded">
            Entrar a lista de espera
        </button>
    </form>

@else

    <form method="POST" action="/events/{{ $event->id }}/register">
        @csrf
        <button class="bg-green-600 text-white px-3 py-1 rounded">
            Inscribirme
        </button>
    </form>

@endif
     </div>

@empty

    <div class="col-span-full flex flex-col items-center justify-center py-20 text-center">
        <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-full mb-4">
            <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-800 dark:text-white">
            No hay eventos disponibles
        </h3>
        <p class="text-gray-500 dark:text-gray-400 mt-2">
            Vuelve más tarde para ver las novedades.
        </p>
    </div>

@endforelse

            </div>

        </div>
    </div>
</x-app-layout>