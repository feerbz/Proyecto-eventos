<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">

<style>

body{
    font-family: DejaVu Sans;
    margin:20px;
}

h1{
    text-align:center;
}

.subtitle{
    text-align:center;
    color:#666;
    margin-bottom:20px;
}

.summary{
    margin-top:20px;
    margin-bottom:30px;
}

.summary td{
    padding:8px;
    border:1px solid #ddd;
}

table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:#e5e7eb;
}

th,td{
    border:1px solid #ccc;
    padding:8px;
    text-align:center;
}

</style>

</head>

<body>

<h1>UNI EVENT</h1>

<p class="subtitle">
Reporte Administrativo
</p>

<p>
Fecha de generación:
{{ now()->format('d/m/Y H:i') }}
</p>

<table class="summary">

<tr>
    <td>Eventos</td>
    <td>{{ $totalEvents }}</td>
</tr>

<tr>
    <td>Usuarios</td>
    <td>{{ $totalUsers }}</td>
</tr>

<tr>
    <td>Inscripciones</td>
    <td>{{ $totalRegistrations }}</td>
</tr>

<tr>
    <td>Asistencias</td>
    <td>{{ $totalAttendances }}</td>
</tr>

<tr>
    <td>% Asistencia Global</td>
    <td>{{ $attendanceRate }}%</td>
</tr>

</table>

<h2>
Asistencia por Evento
</h2>

<table>

<thead>

<tr>

<th>Evento</th>
<th>Registrados</th>
<th>Asistencias</th>
<th>%</th>

</tr>

</thead>

<tbody>

@foreach($eventMetrics as $event)

@php

$percent = $event->registrations_count > 0
? round(
($event->attendances_count * 100)
/ $event->registrations_count,
2
)
: 0;

@endphp

<tr>

<td>
{{ $event->title }}
</td>

<td>
{{ $event->registrations_count }}
</td>

<td>
{{ $event->attendances_count }}
</td>

<td>
{{ $percent }}%
</td>

</tr>

@endforeach

</tbody>

</table>

</body>

</html>