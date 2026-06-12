<x-app-layout>

    <div class="max-w-6xl mx-auto p-6">

        <h2 class="text-2xl font-bold mb-6">
            Calendario de Eventos
        </h2>
        <form method="GET" class="mb-4">

    <select
        name="space_id"
        onchange="this.form.submit()"
        class="rounded-xl border-gray-300">

        <option value="">
            Todos los espacios
        </option>

        @foreach($spaces as $space)

            <option
                value="{{ $space->id }}"
                {{ request('space_id') == $space->id ? 'selected' : '' }}>

                {{ $space->name }}

            </option>

        @endforeach

    </select>

</form>

        <div id="calendar"></div>

    </div>

</x-app-layout>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function() {

    var calendarEl = document.getElementById('calendar');

var calendar = new FullCalendar.Calendar(calendarEl, {

    initialView: 'dayGridMonth',

    eventClick: function(info) {

        info.jsEvent.preventDefault();

        window.location.href = info.event.url;

    },

    events: [

        @foreach($events as $event)

        {
            title: "{{ $event->title }}",

            start: "{{ \Carbon\Carbon::parse($event->event_date)->format('Y-m-d H:i:s') }}",

            url: "/events/{{ $event->id }}",

            extendedProps: {
                location: "{{ $event->location ?? $event->space?->name }}"
            }
        },

        @endforeach

    ]

});

    calendar.render();

});

</script>