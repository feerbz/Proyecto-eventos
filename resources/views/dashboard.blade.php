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
               class="inline-flex items-center justify-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg">
                + Proponer Evento
            </a>
        </div>
    </x-slot>

    {{-- MENSAJES --}}
    @if (session('success'))
        <div class="max-w-7xl mx-auto px-4 mt-6 text-green-600 font-bold">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="max-w-7xl mx-auto px-4 mt-6 text-red-600 font-bold">
            {{ session('error') }}
        </div>
    @endif

    <div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                @forelse ($events as $event)

                    @php
                        $inscrito = \App\Models\Registration::where('user_id', auth()->id())
                            ->where('event_id', $event->id)
                            ->exists();

                        $total = \App\Models\Registration::where('event_id', $event->id)->count();
                    @endphp

                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 flex flex-col">

                        <span class="text-xs font-bold text-emerald-600 mb-2">
                            {{ $event->location }}
                        </span>

                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                            {{ $event->title }}
                        </h3>

                        <p class="text-sm text-gray-500 mb-4">
                            {{ $event->description }}
                        </p>

                        <p class="text-sm mb-2">
                        {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y h:i A') }}
                        </p>

                        <p class="text-sm mb-4">
                        Cupo: {{ $total }} / {{ $event->capacity }}
                        </p>

                        {{-- BOTONES --}}
                        @if($inscrito)

                            <span class="text-green-600 font-bold mb-2">
                                Inscrito
                            </span>

                            <form method="POST" action="/events/{{ $event->id }}/unregister">
                                @csrf
                                @method('DELETE')
                                <button class="w-full bg-red-500 text-white py-2 rounded"
                                    onclick="return confirm('¿Cancelar inscripción?')">
                                    Cancelar inscripción
                                </button>
                            </form>

                        @elseif($total >= $event->capacity)

                            <span class="text-red-500 font-bold">
                                Evento lleno
                            </span>

                        @else

                            <form method="POST" action="/events/{{ $event->id }}/register">
                                @csrf
                                <button class="w-full bg-emerald-600 text-white py-2 rounded">
                                    Inscribirme
                                </button>
                            </form>

                        @endif

                    </div>

                @empty
                    <p>No hay eventos disponibles</p>
                @endforelse

            </div>

        </div>
    </div>
</x-app-layout>