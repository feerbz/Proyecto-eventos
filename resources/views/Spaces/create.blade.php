<x-app-layout>
    <div class="p-6 max-w-2xl mx-auto">

        <h2 class="text-2xl font-bold mb-6">
            Crear Espacio
        </h2>

        <form method="POST" action="/spaces" class="space-y-6">
            @csrf

            {{-- NOMBRE --}}
            <div>
                <label class="block text-sm font-medium mb-1">
                    Nombre del espacio
                </label>
                <input type="text" name="name"
                    class="w-full rounded-xl border-gray-300 dark:bg-gray-900"
                    required>
            </div>

            {{-- CAPACIDAD --}}
            <div>
                <label class="block text-sm font-medium mb-1">
                    Capacidad
                </label>
                <input type="number" name="capacity" id="capacityInput"
                    class="w-full rounded-xl border-gray-300 dark:bg-gray-900">
            </div>

            {{-- ILIMITADO --}}
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_unlimited" id="unlimitedCheck">
                <label for="unlimitedCheck" class="text-sm">
                    Sin límite de capacidad
                </label>
            </div>

            {{-- BOTÓN --}}
            <div class="flex justify-end">
                <button class="px-5 py-2 bg-emerald-600 text-white rounded-xl">
                    Guardar espacio
                </button>
            </div>

        </form>

    </div>
    
</x-app-layout>

{{-- SCRIPT --}}
<script>
document