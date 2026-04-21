<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="/dashboard" class="p-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm hover:bg-gray-50 transition-all text-gray-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <h2 class="font-black text-xl text-gray-800 dark:text-white tracking-tighter">
                Detalles del <span class="text-emerald-600">Evento</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex flex-col lg:flex-row gap-8">
                
                <div class="flex-1 space-y-8">
                    <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] p-10 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="px-4 py-1.5 bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400 text-xs font-black uppercase tracking-widest rounded-full">
                                {{ $event->location }}
                            </span>
                            <span class="text-gray-400 text-xs font-bold uppercase tracking-widest">Publicado {{ $event->created_at->diffForHumans() }}</span>
                        </div>

                        <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-6 leading-tight tracking-tighter">
                            {{ $event->title }}
                        </h1>

                        <div class="prose dark:prose-invert max-w-none">
                            <p class="text-lg text-gray-600 dark:text-gray-300 leading-relaxed">
                                {{ $event->description }}
                            </p>
                        </div>

                        <div class="mt-10 h-64 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-[2rem] flex items-center justify-center overflow-hidden relative">
                             <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                             <svg class="w-20 h-20 text-white/20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-96">
                    <div class="sticky top-24 space-y-6">
                        <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] p-8 shadow-xl border border-gray-100 dark:border-gray-700">
                            <div class="space-y-6">
                                <div>
                                    <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Información Clave</h4>
                                    <div class="space-y-4">
                                        <div class="flex items-center gap-4">
                                            <div class="p-3 bg-gray-50 dark:bg-gray-900 rounded-2xl text-emerald-600">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            </div>
                                            <div>
                                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-tighter leading-none">Fecha</p>
                                                <p class="text-sm font-bold text-gray-800 dark:text-white">{{ \Carbon\Carbon::parse($event->event_date)->format('d M, Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <div class="p-3 bg-gray-50 dark:bg-gray-900 rounded-2xl text-emerald-600">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            </div>
                                            <div>
                                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-tighter leading-none">Hora</p>
                                                <p class="text-sm font-bold text-gray-800 dark:text-white">{{ \Carbon\Carbon::parse($event->event_date)->format('h:i A') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-6 border-t border-gray-100 dark:border-gray-700">
                                    <div class="flex justify-between items-end mb-6">
                                        <div>
                                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">Disponibilidad</p>
                                            <p class="text-2xl font-black text-gray-900 dark:text-white">
                                                {{ $event->capacity - $event->registrations_count }} 
                                                <span class="text-sm font-medium text-gray-500">Libres</span>
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xs font-bold text-emerald-600">{{ $event->registrations_count }} inscritos</p>
                                        </div>
                                    </div>

                                    {{-- LÓGICA DE INSCRIPCIÓN INTEGRADA --}}
                                    @php
                                        $inscrito = \App\Models\Registration::where('user_id', auth()->id())
                                            ->where('event_id', $event->id)
                                            ->exists();
                                    @endphp

                                    @if($inscrito)
                                        <div class="space-y-3">
                                            <div class="text-center bg-emerald-50 dark:bg-emerald-900/20 py-2 rounded-xl border border-emerald-100 dark:border-emerald-800">
                                                <span class="text-emerald-600 dark:text-emerald-400 font-bold text-sm">✓ Ya tienes tu lugar</span>
                                            </div>
                                            <form method="POST" action="/events/{{ $event->id }}/unregister">
                                                @csrf
                                                @method('DELETE')
                                                <button class="w-full bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 hover:bg-red-500 hover:text-white font-bold py-3 rounded-2xl transition-all border border-red-100 dark:border-red-800"
                                                    onclick="return confirm('¿Cancelar inscripción?')">
                                                    Cancelar lugar
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($event->registrations_count >= $event->capacity)
                                        <button disabled class="w-full bg-gray-100 dark:bg-gray-700 text-gray-400 font-bold py-3 rounded-2xl cursor-not-allowed">
                                            Evento Lleno
                                        </button>
                                    @else
                                        <form method="POST" action="/events/{{ $event->id }}/register">
                                            @csrf
                                            <button class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black py-4 rounded-2xl shadow-lg shadow-emerald-500/20 transition-all active:scale-95">
                                                Inscribirme ahora
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-800 dark:bg-gray-700 rounded-[2rem] p-6 text-white shadow-lg">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-emerald-500 flex items-center justify-center font-black text-xl">
                                    {{ substr($event->user->name ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold uppercase opacity-60 tracking-widest">Organizado por</p>
                                    <p class="font-bold leading-tight">{{ $event->user->name ?? 'Comunidad UPIICSA' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>