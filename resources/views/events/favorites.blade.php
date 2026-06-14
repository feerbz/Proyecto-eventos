<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-gray-800 dark:text-white tracking-tighter">
                Mis <span class="text-emerald-600">Favoritos</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($events as $event)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col transition-all duration-300 hover:shadow-xl group">
                        
                        {{-- ENCABEZADO DE TARJETA (Estado e ID) --}}
                        <div class="px-5 py-3 border-b border-gray-50 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 flex justify-between items-center">
                            
                            @if($event->status === 'approved')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></span> Aprobado
                                </span>
                            @elseif($event->status === 'rejected')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span> Rechazado
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">
                                    <span class="w-1.5 h-1.5 bg-amber-500 rounded-full mr-1.5"></span> Pendiente
                                </span>
                            @endif

                            <span class="text-[10px] text-gray-400 font-mono font-semibold">ID: #{{ $event->id }}</span>
                        </div>

                        {{-- CUERPO DE LA TARJETA --}}
                        <div class="p-6 flex-grow flex flex-col">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 leading-tight group-hover:text-emerald-600 transition-colors">
                                {{ $event->title }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-3 mb-4">
                                {{ $event->description }}
                            </p>

                            {{-- COMENTARIO ADMINISTRATIVO (Si fue rechazado) --}}
                            @if($event->status === 'rejected' && $event->admin_comment)
                                <div class="mb-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/50 rounded-xl p-3">
                                    <p class="text-[10px] font-bold text-red-700 dark:text-red-400 uppercase tracking-wider mb-1">
                                        Comentario administrativo
                                    </p>
                                    <p class="text-xs text-red-600 dark:text-red-300">
                                        {{ $event->admin_comment }}
                                    </p>
                                </div>
                            @endif

                            {{-- DETALLES (Fecha y Lugar) --}}
                            <div class="space-y-2 mt-auto pt-4 border-t border-gray-50 dark:border-gray-700/50">
                                <div class="flex items-center text-sm font-medium text-gray-600 dark:text-gray-400">
                                    <span class="text-emerald-500 mr-2 text-base">📅</span>
                                    {{ $event->event_date ?? 'Fecha no definida' }}
                                </div>
                                <div class="flex items-center text-sm font-medium text-gray-600 dark:text-gray-400">
                                    <span class="text-emerald-500 mr-2 text-base">📍</span>
                                    {{ $event->location }}
                                </div>
                            </div>
                        </div>

                        {{-- PIE DE TARJETA (Botones) --}}
                        <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 flex gap-3">
                            <a href="/events/{{ $event->id }}" 
                               class="flex-1 text-center py-2 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 dark:bg-emerald-900/30 dark:hover:bg-emerald-900/50 dark:text-emerald-400 rounded-xl font-bold text-sm transition-colors">
                                Ver detalle
                            </a>

                            <form method="POST" action="/events/{{ $event->id }}/favorite" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button class="w-full py-2 bg-red-50 hover:bg-red-100 text-red-600 dark:bg-red-900/20 dark:hover:bg-red-900/40 dark:text-red-400 rounded-xl font-bold text-sm transition-colors flex items-center justify-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                    Quitar
                                </button>
                            </form>
                        </div>

                    </div>
                @empty
                    {{-- ESTADO VACÍO --}}
                    <div class="col-span-full flex flex-col items-center justify-center py-24 text-center">
                        <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-full mb-5 shadow-inner">
                            <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-black text-gray-800 dark:text-white">
                            Aún no hay favoritos
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 font-medium">
                            Explora la cartelera y guarda los eventos que más te interesen.
                        </p>
                        <a href="/dashboard" class="mt-6 inline-flex items-center px-6 py-2.5 bg-emerald-600 text-white rounded-xl font-bold text-sm hover:bg-emerald-700 shadow-md transition-all hover:-translate-y-0.5">
                            Ir a la cartelera
                        </a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>