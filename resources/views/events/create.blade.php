<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Nuevo Evento') }}
        </h2>
    </x-slot>
    @if (session('error'))
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-8">

                    <form method="POST" action="/events" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        {{-- TÍTULO --}}
                        <div>
                            <label class="block text-sm font-medium">Título *</label>
                            <input type="text" name="title" value="{{ old('title') }}"
                                class="w-full rounded-xl border-gray-300 dark:bg-gray-900">
                            @error('title') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                        </div>

                        {{-- FECHA --}}
                        <div>
                            <label class="block text-sm font-medium">Fecha y Hora *</label>
                            <input type="datetime-local" name="event_date" value="{{ old('event_date') }}"
                                class="w-full rounded-xl border-gray-300 dark:bg-gray-900">
                            @error('event_date') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                        </div>
                        <div>
    <label class="block text-sm font-medium">Hora de fin *</label>
    <input type="time" name="end_time"
        value="{{ old('end_time') }}"
        class="w-full rounded-xl border-gray-300 dark:bg-gray-900">
</div>

                        {{-- ESPACIO --}}
                        <div>
                            <label class="block text-sm font-medium">Espacio</label>

                            <select name="space_id" id="spaceSelect" class="w-full rounded-xl">
    <option value="">-- Selecciona un espacio --</option>

    @foreach($spaces as $space)
        <option 
            value="{{ $space->id }}"
            data-capacity="{{ $space->capacity }}"
            data-unlimited="{{ $space->is_unlimited ? '1' : '0' }}"

        >
            {{ $space->name }}
        </option>
    @endforeach

    <option value="other">Otro (especificar)</option>
</select>
                            @error('space_id') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                        </div>

{{-- LUGAR LIBRE --}}
<div id="customLocationField" style="display:none;">
    <label class="block text-sm font-medium">Lugar</label>
    <input type="text" name="location" value="{{ old('location') }}">
</div>
                        {{-- CAPACIDAD --}}
                        <div>
                            <label class="block text-sm font-medium">Capacidad </label>
                            <input 
                                type="number" 
                                name="capacity" 
                                id="capacityInput"
                                class="w-full rounded-xl border-gray-300 dark:bg-gray-900"
>
                            @error('capacity') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                        </div>

                        {{-- DESCRIPCIÓN --}}
                        <div>
                            <label class="block text-sm font-medium">Descripción *</label>
                            <textarea name="description" rows="4"
                                class="w-full rounded-xl border-gray-300 dark:bg-gray-900">{{ old('description') }}</textarea>
                            @error('description') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                        </div>

                        {{-- IMAGEN --}}
                        <div>
                            <label class="block text-sm font-medium">Imagen</label>
                            <input 
    type="file" 
    name="image" 
    accept=".jpg,,.png,"
    class="w-full"
>
                            @error('image') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                        </div>

                        {{-- BOTÓN --}}
                        <div class="flex justify-end">
                            <button class="px-5 py-2 bg-emerald-600 text-white rounded-xl">
                                Crear evento
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

        } else if (this.value === '') {

            customField.style.display = 'none';
            capacityInput.value = '';
            capacityInput.removeAttribute('readonly');

        } else {

            customField.style.display = 'none';

            if (unlimited === '1') {
                // ESPACIO ILIMITADO
                capacityInput.value = '∞';
                capacityInput.setAttribute('readonly', true);

            } else {
                // ESPACIO NORMAL
                capacityInput.value = capacity;
                capacityInput.setAttribute('readonly', true);
            }
        }
    });

});
</script>

</x-app-layout>