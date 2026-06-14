<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-black text-2xl text-gray-800 dark:text-white tracking-tighter">
                    Administrar <span class="text-emerald-600">Espacios</span>
                </h2>
            </div>
            <a href="/spaces/create" 
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-emerald-500/20 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nuevo espacio
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Mensajes de Sesión --}}
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400 font-bold border border-emerald-200 dark:border-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-900/50 text-gray-600 dark:text-gray-400 uppercase text-xs font-bold tracking-wider">
                            <th class="px-8 py-5">Nombre</th>
                            <th class="px-8 py-5 text-center">Capacidad</th>
                            <th class="px-8 py-5 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($spaces as $space)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors group">
                                <td class="px-8 py-5 font-bold text-gray-900 dark:text-white">
                                    {{ $space->name }}
                                </td>
                                <td class="px-8 py-5 text-center text-gray-600 dark:text-gray-300 font-mono">
                                    {{ $space->is_unlimited ? '∞ Ilimitada' : $space->capacity }}
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="/spaces/{{ $space->id }}/edit" 
                                           class="px-3 py-1.5 bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 rounded-lg text-xs font-bold hover:bg-blue-100 transition-colors">
                                           Editar
                                        </a>
                                        <form action="/spaces/{{ $space->id }}" method="POST" onsubmit="return confirm('¿Eliminar espacio?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="px-3 py-1.5 bg-red-50 text-red-600 dark:bg-red-900/30 dark:text-red-400 rounded-lg text-xs font-bold hover:bg-red-100 transition-colors">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>