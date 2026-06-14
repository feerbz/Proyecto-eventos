<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Mis favoritos') }}
            </h2>
            
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($events as $event)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col transition-transform hover:scale-[1.01]">
                        
                        <div class="px-5 py-3 border-b border-gray-50 dark:border-gray-700 flex justify-between items-center">
                            <span class="text-[10px] font-extrabold uppercase tracking-widest

@if($event->status === 'approved')
    text-emerald-500
@elseif($event->status === 'rejected')
    text-red-500
@else
    text-amber-500
@endif

">

●

@if($event->status === 'approved')

    Aprobado

@elseif($event->status === 'rejected')

    Rechazado

@else

    Pendiente

@endif

</span>
                            <span class="text-[10px] text-gray-400 font-mono">ID: #{{ $event->id }}</span>
                        </div>

                        <div class="p-6 flex-grow">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 leading-tight">
                                {{ $event->title }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-3 mb-4">
                                {{ $event->description }}
                            </p>
                            @if(
    $event->status === 'rejected'
    && $event->admin_comment
)

<div class="mb-4 bg-red-50 border border-red-200 rounded-xl p-3">

    <p class="text-xs font-bold text-red-700 uppercase">
        Comentario administrativo
    </p>

    <p class="text-sm text-red-600 mt-1">
        {{ $event->admin_comment }}
    </p>

</div>

@endif
 <div class="space-y-2">
                                <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $event->event_date ?? 'Fecha no definida' }}
                                </div>
                                <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $event->location }}
                                </div>
                            </div>
                        </div>

                        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-t flex gap-2">

    <a
        href="/events/{{ $event->id }}"
        class="flex-1 text-center py-2 bg-blue-600 text-white rounded-lg font-bold">

        Ver detalle

    </a>

    <form
        method="POST"
        action="/events/{{ $event->id }}/favorite"
        class="flex-1">

        @csrf
        @method('DELETE')

        <button
            class="w-full py-2 bg-red-500 text-white rounded-lg font-bold">

            ❤️ Quitar

        </button>

    </form>

</div>
                @empty
                    <div class="col-span-full bg-white dark:bg-gray-800 p-16 text-center rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">No hay eventos</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-1">Parece que aún no has registrado ningún evento.</p>
                        <a href="/events/create" class="mt-6 inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-xl font-bold text-sm hover:bg-emerald-700 transition-all">
                            Crear mi primer evento
                        </a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>