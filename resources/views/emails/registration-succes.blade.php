<h2>
    Confirmación de inscripción
</h2>

<p>
    Te registraste correctamente en:
</p>

<p>
    <strong>
        {{ $event->title }}
    </strong>
</p>

<p>
    Fecha:
    {{ $event->event_date }}
</p>

@if($event->space)

<p>
    Espacio:
    {{ $event->space->name }}
</p>

@endif

<p>
    Gracias por utilizar UniEvent.
</p>