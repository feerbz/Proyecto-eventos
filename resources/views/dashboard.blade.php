<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-gray-800 dark:text-white tracking-tighter">
                    Cartelera <span class="text-emerald-600">Universitaria</span>
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Descubre los próximos eventos en tu comunidad.</p>
            </div>
            <a href="/events/create" class="inline-flex items-center justify-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-emerald-500/20 active:scale-95">
                + Proponer Evento
            </a>
        </div>
    </x-slot>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
             x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
             class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
            <div class="bg-emerald-50 dark:bg-emerald-900/30 border-l-4 border-emerald-500 p-4 shadow-sm rounded-r-xl flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="h-6 w-6 text-emerald-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <p class="text-emerald-800 dark:text-emerald-300 font-bold text-sm">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors">
                    <span class="text-2xl leading-none">&times;</span>
                </button>
            </div>
        </div>
    @endif

    <div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                @forelse ($events as $event)
                    <div class="group bg-white dark:bg-gray-800 rounded-[2rem] shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col transition-all duration-300 hover:shadow-2xl hover:shadow-emerald-500/10 hover:-translate-y-1">
                        
                        <div class="p-8 flex-grow flex flex-col">
                            <div class="mb-4">
                                <span class="inline-block px-3 py-1 rounded-full bg-emerald-50 dark:bg-emerald-900/30 text-[10px] font-extrabold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">
                                    {{ $event->location }}
                                </span>
                            </div>

                            <h3 class="text-xl font-black text-gray-900 dark:text-white mb-3 leading-tight group-hover:text-emerald-600 transition-colors">
                                {{ $event->title }}
                            </h3>

                            <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-3 mb-6 leading-relaxed flex-grow">
                                {{ $event->description }}
                            </p>

                            <div class="flex items-center gap-4 text-gray-400 dark:text-gray-500 border-t border-gray-50 dark:border-gray-700/50 pt-6">
                                <div class="flex flex-col">
                                    <span class="text-[10px] uppercase font-bold tracking-tighter text-gray-400">Fecha</span>
                                    <span class="text-sm font-bold text-gray-700 dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('d M, Y') }}
                                    </span>
                                </div>
                                <div class="w-px h-8 bg-gray-100 dark:bg-gray-700"></div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] uppercase font-bold tracking-tighter text-gray-400">Hora</span>
                                    <span class="text-sm font-bold text-gray-700 dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('h:i A') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="px-8 pb-8">
                            <button class="w-full py-3 bg-gray-900 dark:bg-gray-700 text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-emerald-600 transition-all duration-300 active:scale-[0.98]">
                                Ver detalles
                            </button>
                        </div>
                    </div>

                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-20 text-center">
                        <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-full mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white">No hay eventos próximos</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2">Vuelve más tarde para ver las novedades de la universidad.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>