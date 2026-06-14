<h2>
    Evento actualizado
</h2>

<p>
    El evento:
</p>

<p>
    <strong>
        {{ $event->title }}
    </strong>
</p>

<p>
    ha sido modificado.
</p>

<p>
    Consulta los nuevos detalles en UniEvent.
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