<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 dark:text-white tracking-tighter">
            Calendario de <span class="text-emerald-600">Eventos</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- FILTRO DE ESPACIOS --}}
            <form method="GET" class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center gap-4">
                <label class="text-sm font-bold text-gray-700 dark:text-gray-300 whitespace-nowrap">
                    Filtrar por espacio:
                </label>
                
                <select name="space_id" onchange="this.form.submit()"
                    class="w-full sm:w-64 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 text-sm font-medium transition-colors">
                    
                    <option value="">Todos los espacios</option>
                    
                    @foreach($spaces as $space)
                        <option value="{{ $space->id }}" {{ request('space_id') == $space->id ? 'selected' : '' }}>
                            {{ $space->name }}
                        </option>
                    @endforeach

                </select>
            </form>

            {{-- CONTENEDOR DEL CALENDARIO --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
                
                {{-- Contenedor donde FullCalendar inyecta su vista --}}
                <div id="calendar"></div>

            </div>

        </div>
    </div>

    {{-- LIBRERÍAS DE FULLCALENDAR --}}
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

    {{-- ESTILOS PERSONALIZADOS PARA ADAPTAR FULLCALENDAR A TAILWIND --}}
    <style>
        .fc {
            font-family: inherit !important;
        }
        .fc .fc-toolbar-title {
            font-weight: 900 !important;
            font-size: 1.5rem !important;
            color: #1f2937;
        }
        .fc .fc-button-primary {
            background-color: #059669 !important;
            border-color: #059669 !important;
            border-radius: 0.5rem !important;
            font-weight: 600 !important;
            text-transform: capitalize !important;
            transition: all 0.2s;
        }
        .fc .fc-button-primary:hover {
            background-color: #047857 !important;
        }
        .fc .fc-button-primary:not(:disabled):active,
        .fc .fc-button-primary:not(:disabled).fc-button-active {
            background-color: #064e3b !important;
            border-color: #064e3b !important;
        }
        .fc .fc-col-header-cell-cushion {
            padding: 12px 8px !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            font-size: 0.875rem !important;
            color: #4b5563;
        }
        .fc-theme-standard td, .fc-theme-standard th {
            border-color: #e5e7eb !important;
        }
        .fc-h-event, .fc-event {
            background-color: #10b981 !important;
            border: none !important;
            border-radius: 6px !important;
            padding: 3px 6px !important;
            font-size: 0.75rem !important;
            font-weight: 700 !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
            cursor: pointer;
            transition: transform 0.1s;
        }
        .fc-event:hover {
            transform: scale(1.02);
        }
        .fc .fc-daygrid-day.fc-day-today {
            background-color: #ecfdf5 !important;
        }

        /* DARK MODE */
        @media (prefers-color-scheme: dark) {
            .fc .fc-toolbar-title { color: #f9fafb !important; }
            .fc .fc-col-header-cell-cushion { color: #9ca3af !important; }
            .fc-theme-standard td, .fc-theme-standard th, .fc-scrollgrid {
                border-color: #374151 !important;
            }
            .fc .fc-daygrid-day.fc-day-today {
                background-color: rgba(16, 185, 129, 0.1) !important;
            }
            .fc .fc-daygrid-day-number { color: #d1d5db !important; }
            .fc-theme-standard .fc-scrollgrid { border-color: #374151 !important; }
            .fc .fc-button-primary:disabled {
                background-color: #064e3b !important;
                border-color: #064e3b !important;
                opacity: 0.5;
            }
        }
    </style>

    {{-- LÓGICA DEL CALENDARIO --}}
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

</x-app-layout>