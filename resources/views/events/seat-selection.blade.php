<x-app-layout>

    <x-slot name="header">
        <h2 class="font-bold text-2xl">
            Selección de asiento
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto py-10">

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-8">

            <h2 class="text-2xl font-bold mb-3">
                {{ $event->title }}
            </h2>

            <p class="text-gray-500 mb-8">
                Selecciona un asiento para completar tu inscripción.
            </p>

            @php

    $capacity = $event->capacity ?? 50;

    $columns = 10;

    $rows = ceil($capacity / $columns);

@endphp


            <div class="bg-gray-900 text-white rounded-lg text-center py-3 mb-10 font-bold">
                ESCENARIO
            </div>
            <div class="flex flex-col items-center gap-4">

    @for($row = 0; $row < $rows; $row++)

        <div class="flex gap-2">

            @for($seat = 1; $seat <= $columns; $seat++)

                @php

                    $number = ($row * $columns) + $seat;


                    if($number > $capacity) break;

                    $letter = chr(65 + $row);

                @endphp
                @php

    $occupied = $occupiedSeats->contains(function ($item) use ($letter, $seat) {

        return $item->seat_row == $letter
            && $item->seat_number == $seat;

    });

@endphp


    <button
        type="button"
        data-row="{{ $letter }}"
        data-seat="{{ $seat }}"
        {{ $occupied ? 'disabled' : '' }}

        class="seat w-14 h-14 rounded-lg font-bold transition
        {{ $occupied
            ? 'bg-red-500 text-white cursor-not-allowed'
            : 'bg-gray-200 hover:bg-emerald-500 hover:text-white'
        }}">

        {{ $letter }}{{ $seat }}

    </button>

            @endfor

        </div>


    @endfor

</div>
<div class="mt-10 text-center">

    <h3 class="font-bold text-lg">
        Asiento seleccionado:
    </h3>

    <p
        id="selectedSeat"
        class="text-emerald-600 text-xl font-black mt-2">
        Ninguno
    </p>

<form
    method="POST"
    action="{{ route('events.register', $event->id) }}"
    class="mt-6">

    @csrf

    <input
        type="hidden"
        id="seatRow"
        name="seat_row">

    <input
        type="hidden"
        id="seatNumber"
        name="seat_number">

    <button
        id="confirmButton"
        disabled
        class="px-8 py-3 rounded-xl bg-emerald-600 text-white font-bold opacity-50">

        Confirmar inscripción

    </button>

</form>

</div>

</div> {{-- Se cierra la tarjeta blanca --}}

</div> {{-- Se cierra el contenedor --}}

<script>

let selected = null;

const buttons = document.querySelectorAll('.seat');
console.log(buttons);

const text = document.getElementById('selectedSeat');

const confirm = document.getElementById('confirmButton');

buttons.forEach(button => {

    button.addEventListener('click', () => {

        buttons.forEach(b => {

            b.classList.remove(
                'bg-emerald-600',
                'text-white'
            );

            b.classList.add(
                'bg-gray-200'
            );

        });

        button.classList.remove(
            'bg-gray-200'
        );

        button.classList.add(
            'bg-emerald-600',
            'text-white'
        );

        selected =
            button.dataset.row +
            button.dataset.seat;

        text.textContent = selected;
        document.getElementById('seatRow').value =
    button.dataset.row;

document.getElementById('seatNumber').value =
    button.dataset.seat;

        confirm.disabled = false;

        confirm.classList.remove(
            'opacity-50'
        );

    });

});

</script>


</x-app-layout>