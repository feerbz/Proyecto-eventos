<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string',
        'description' => 'required|string',
        'event_date' => 'required|date',
        'location' => 'required|string',
        'capacity' => 'required|integer',

    ]);

    Event::create([
        'title' => $request->title,
        'description' => $request->description,
        'event_date' => $request->event_date,
        'location' => $request->location,
        'capacity' => $request->capacity,
        'status' => 'pending',
        'user_id' => auth()->id(),
    ]);

    return redirect ('/dashboard')->with('success', 'Evento creado correctamente');
}
public function index()
{
    $events = Event::orderBy('event_date','asc')->get();
    return view('events.index',compact('events'));
}
}
