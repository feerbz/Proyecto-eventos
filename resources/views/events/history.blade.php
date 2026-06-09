<x-app-layout>

    <div class="max-w-5xl mx-auto p-6">

        <h2 class="text-2xl font-bold mb-6">
            Historial de Participación
        </h2>

        <table class="w-full border">

            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2">Evento</th>
                    <th class="p-2">Fecha</th>
                    <th class="p-2">Estado</th>
                </tr>
            </thead>

            <tbody>

                @foreach($registrations as $registration)

                    <tr class="border-t">

                        <td class="p-2">
                            {{ $registration->event->title }}
                        </td>

                        <td class="p-2">
                            {{ $registration->event->event_date }}
                        </td>

                        <td class="p-2">

                            @if(
                                \Carbon\Carbon::parse(
                                    $registration->event->event_date
                                )->isPast()
                            )

                                Participó

                            @else

                                Inscrito

                            @endif

                        </td>

                    </tr>

                @endforeach

                @foreach($waitlists as $wait)

                    <tr class="border-t">

                        <td class="p-2">
                            {{ $wait->event->title }}
                        </td>

                        <td class="p-2">
                            {{ $wait->event->event_date }}
                        </td>

                        <td class="p-2">
                            Lista de espera
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</x-app-layout>