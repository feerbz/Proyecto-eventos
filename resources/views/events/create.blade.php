<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Nuevo Evento') }}
        </h2>
    </x-slot>

    @if (session('error'))
        <div class="max-w-3xl mx-auto mt-6 sm:px-6 lg:px-8">
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm" role="alert">
                <p class="font-medium">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-8 sm:p-10">

                    <form method="POST" action="/events" enctype="multipart/form-data" class="space-y-8">
                        @csrf

                        {{-- TÍTULO --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Título *</label>
                            <input type="text" name="title" value="{{ old('title') }}"
                                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-colors"
                                placeholder="Ej. Conferencia de Tecnología">
                            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- GRID FECHAS --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Fecha y Hora *</label>
                                <input type="datetime-local" name="event_date" value="{{ old('event_date') }}"
                                <input type="datetime-local" name="event_date" value="{{ old('event_date') }}"
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-colors">
                                @error('event_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Hora de fin *</label>
                                <input type="time" name="end_time" value="{{ old('end_time') }}"
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-colors">
                                @error('end_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- GRID ESPACIO Y CAPACIDAD --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Espacio</label>
                                <select name="space_id" id="spaceSelect" 
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-colors">
                                    <option value="">-- Selecciona un espacio --</option>
                                    @foreach($spaces as $space)
                                        <option value="{{ $space->id }}" data-capacity="{{ $space->capacity }}" data-unlimited="{{ $space->is_unlimited ? '1' : '0' }}">
                                            {{ $space->name }}
                                        </option>
                                    @endforeach
                                    <option value="other">Otro (especificar)</option>
                                </select>
                                @error('space_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Capacidad</label>
                                <input type="text" name="capacity" id="capacityInput"
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-colors bg-gray-50 cursor-not-allowed"
                                    placeholder="Selecciona un espacio">
                                @error('capacity') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- LUGAR LIBRE (Oculto por defecto) --}}
                        <div id="customLocationField" style="display:none;" class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-xl border border-gray-200 dark:border-gray-600">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Especificar Lugar</label>
                            <input type="text" name="location" value="{{ old('location') }}"
                                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-colors"
                                placeholder="Ej. Pasillo de conexión">
                        </div>

                        {{-- DESCRIPCIÓN --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Descripción *</label>
                            <textarea name="description" rows="4"
                                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-colors resize-none"
                                placeholder="Escribe los detalles del evento aquí...">{{ old('description') }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- CATEGORÍAS (Grid Layout) --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Categorías</label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                @foreach($categories as $category)
                                    <label class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-xl cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                            class="w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 rounded focus:ring-emerald-500 dark:focus:ring-emerald-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $category->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- IMAGEN (Estilo Dropzone) --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Imagen de Portada</label>
                            <input type="file" name="image" accept=".jpg,.png"
                                class="block w-full text-sm text-gray-500 dark:text-gray-400
                                file:mr-4 file:py-3 file:px-4
                                file:rounded-xl file:border-0
                                file:text-sm file:font-semibold
                                file:bg-emerald-50 file:text-emerald-700
                                hover:file:bg-emerald-100
                                dark:file:bg-emerald-900/50 dark:file:text-emerald-400
                                dark:hover:file:bg-emerald-900 transition-colors cursor-pointer border border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-2">
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Formatos permitidos: JPG, PNG.</p>
                            @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- BOTÓN --}}
                        <div class="flex justify-end pt-4 border-t border-gray-100 dark:border-gray-700">
                            <button type="submit" 
                                class="w-full sm:w-auto px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-md transition-transform transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-emerald-500 focus:ring-opacity-50">
                                Crear Evento
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const spaceSelect = document.getElementById('spaceSelect');
        const capacityInput = document.getElementById('capacityInput');
        const customField = document.getElementById('customLocationField');

        spaceSelect.addEventListener('change', function () {
            let selectedOption = this.options[this.selectedIndex];
            let capacity = selectedOption.getAttribute('data-capacity');
            let unlimited = selectedOption.getAttribute('data-unlimited');

            if (this.value === 'other') {
                customField.style.display = 'block';
                capacityInput.value = '';
                capacityInput.removeAttribute('readonly');
                capacityInput.classList.remove('bg-gray-50', 'cursor-not-allowed');
            } else if (this.value === '') {
                customField.style.display = 'none';
                capacityInput.value = '';
                capacityInput.removeAttribute('readonly');
                capacityInput.classList.remove('bg-gray-50', 'cursor-not-allowed');
            } else {
                customField.style.display = 'none';
                capacityInput.classList.add('bg-gray-50', 'cursor-not-allowed');

if (unlimited === '1') {
    capacityInput.value = '';
    capacityInput.placeholder = 'Capacidad ilimitada';
    capacityInput.setAttribute('readonly', true);
} else {
                    capacityInput.value = capacity;
                    capacityInput.setAttribute('readonly', true);
                }
            }
        });
    });
    </script>
</x-app-layout>