<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'description' => 'required',
        'event_date' => 'required',
        'location' => 'required',
        'capacity' => 'required|integer',

    ]);

    Event::create([
        'title' => $request->title,
        'description' => $request->description,
        'event_date' => $request->event_date,
        'location' => $request->location,
        'capacity' => $request->capacity,
    ]);
    return redirect ('/dashboard')->with('success', 'Evento creado correctamente');
}
}
