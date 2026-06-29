<x-app-layout>

    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-200">
            Selección de asiento
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <div class="bg-white dark:bg-[#1e293b] rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 p-8 md:p-12">


<div class="text-center mb-12">
    <h2 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight mb-3">
        {{ $event->title }}
    </h2>
    <p class="text-slate-500 dark:text-slate-400">
        Selecciona un asiento disponible para completar tu inscripción.
    </p>
</div>

@php
    $capacity = $event->space?->capacity ?? $event->capacity ?? 50;
    $columns = 10;
    $rows = ceil($capacity / $columns);
@endphp

<div class="max-w-2xl mx-auto mb-16 relative">
    <div class="bg-gradient-to-b from-slate-800 to-[#1e293b] border-t-4 border-emerald-500 rounded-t-[100px] shadow-[0_-15px_40px_-10px_rgba(16,185,129,0.2)] text-center py-6">
        <span class="text-emerald-500 font-black tracking-[0.3em] text-sm uppercase">
            Escenario
        </span>
    </div>
</div>

            <div class="overflow-x-auto pb-8">
                <div class="flex flex-col items-center gap-4 min-w-[600px]">

                    @for($row = 0; $row < $rows; $row++)
                        <div class="flex gap-3">
                            @for($seat = 1; $seat <= $columns; $seat++)
                                @php
                                    $number = ($row * $columns) + $seat;
                                    if($number > $capacity) break;
                                    $letter = chr(65 + $row);
                                    
                                    $occupied = $occupiedSeats->contains(function ($item) use ($letter, $seat) {
                                        return $item->seat_row == $letter && $item->seat_number == $seat;
                                    });
                                @endphp

                                <button
                                    type="button"
                                    data-row="{{ $letter }}"
                                    data-seat="{{ $seat }}"
                                    {{ $occupied ? 'disabled' : '' }}
                                    class="seat relative w-12 h-12 md:w-14 md:h-14 rounded-t-2xl rounded-b-md font-bold text-sm md:text-base transition-all duration-200 border-b-4 flex items-center justify-center
                                    {{ $occupied
                                        ? 'bg-red-500/80 border-red-700 text-white cursor-not-allowed opacity-60'
                                        : 'bg-slate-700 border-slate-800 text-slate-300 hover:bg-emerald-500 hover:border-emerald-700 hover:text-white hover:-translate-y-1 hover:shadow-lg hover:shadow-emerald-500/30 cursor-pointer'
                                    }}">
                                    {{ $letter }}{{ $seat }}
                                </button>
                            @endfor
                        </div>
                    @endfor

                </div>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-8 mt-4 border-t border-slate-200 dark:border-slate-800 pt-8 mb-10">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-t-xl rounded-b-sm bg-slate-700 border-b-4 border-slate-800 shadow-sm"></div>
                    <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Disponible</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-t-xl rounded-b-sm bg-emerald-500 border-b-4 border-emerald-700 shadow-md shadow-emerald-500/30"></div>
                    <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Seleccionado</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-t-xl rounded-b-sm bg-red-500/80 border-b-4 border-red-700 opacity-60"></div>
                    <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Ocupado</span>
                </div>
            </div>

            <div class="mt-8 bg-slate-50 dark:bg-[#1a2333] rounded-2xl p-8 border border-slate-200 dark:border-slate-800 flex flex-col md:flex-row items-center justify-between gap-6">
                
                <div class="text-center md:text-left">
                    <h3 class="font-medium text-sm text-slate-500 dark:text-slate-400 uppercase tracking-wide">
                        Asiento seleccionado
                    </h3>
                    <p id="selectedSeat" class="text-emerald-500 text-4xl font-black mt-1">
                        --
                    </p>
                </div>

                <form method="POST" action="{{ route('events.register', $event->id) }}" class="w-full md:w-auto m-0">
                    @csrf
                    <input type="hidden" id="seatRow" name="seat_row">
                    <input type="hidden" id="seatNumber" name="seat_number">

                    <button
                        id="confirmButton"
                        disabled
                        class="w-full md:w-auto px-10 py-4 rounded-xl bg-emerald-600 text-white font-bold tracking-wide transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-slate-700 hover:bg-emerald-500 hover:shadow-lg hover:shadow-emerald-500/30 hover:-translate-y-1">
                        Confirmar inscripción
                    </button>
                </form>

            </div>

        </div> {{-- Se cierra la tarjeta principal --}}

    </div> {{-- Se cierra el contenedor max-w --}}

    <script>
        let selected = null;
        const buttons = document.querySelectorAll('.seat');
        const text = document.getElementById('selectedSeat');
        const confirm = document.getElementById('confirmButton');

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                
                // 1. Limpiar los estilos del asiento previamente seleccionado (ignorando los ocupados)
                buttons.forEach(b => {
                    if(!b.disabled) {
                        b.classList.remove('bg-emerald-500', 'border-emerald-700', 'text-white', 'shadow-lg', 'shadow-emerald-500/30', '-translate-y-1', 'scale-105');
                        b.classList.add('bg-slate-700', 'border-slate-800', 'text-slate-300');
                    }
                });

                // 2. Aplicar los estilos al asiento clickeado
                button.classList.remove('bg-slate-700', 'border-slate-800', 'text-slate-300');
                button.classList.add('bg-emerald-500', 'border-emerald-700', 'text-white', 'shadow-lg', 'shadow-emerald-500/30', '-translate-y-1', 'scale-105');

                // 3. Lógica de valores
                selected = button.dataset.row + button.dataset.seat;
                text.textContent = selected;
                document.getElementById('seatRow').value = button.dataset.row;
                document.getElementById('seatNumber').value = button.dataset.seat;

                // 4. Habilitar botón de confirmación
                confirm.disabled = false;
            });
        });
    </script>

</x-app-layout>