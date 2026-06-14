<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 dark:text-white tracking-tighter">
            Registrar <span class="text-emerald-600">Asistencia</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Mensajes de sesión --}}
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400 font-bold border border-emerald-200 dark:border-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-xl bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 font-bold border border-red-200 dark:border-red-800">
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700">
                <div class="mb-8">
                    <p class="text-xs font-bold text-emerald-600 uppercase tracking-widest mb-1">Evento activo</p>
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ $event->title }}</h3>
                </div>

                <form method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Correo electrónico del asistente
                        </label>
                        <input type="email" name="email" required autofocus placeholder="ejemplo@ipn.mx"
                               class="w-full text-lg rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-all py-3">
                    </div>

                    <button type="submit" 
                            class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg shadow-emerald-500/20 transition-all hover:-translate-y-0.5 active:scale-95 text-lg">
                        Confirmar asistencia
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>