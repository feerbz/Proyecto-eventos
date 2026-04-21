<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\Registration;

class EventController extends Controller
{
    public function feed()
    {
        $events = Event::where('status','approved')
        ->with('registrations')
        ->orderBy ('event_date','asc')
        ->get();

        return view('dashboard', compact('events'));
    }

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

        return redirect('/dashboard')->with('success', 'Evento creado correctamente');
    }

    public function index()
    {
        if(auth()->user()->role === 'admin'){
    $events = Event::orderBy('event_date','asc')->get();
} else {
    $events = Event::where('status','approved')
        ->orderBy('event_date','asc')
        ->get();
}
        return view('events.index', compact('events'));
    }

    public function approve($id)
    {
        if(auth()->user()->role !== 'admin'){
            abort(403);
        }

        $event = Event::findOrFail($id);
        $event->status = "approved";
        $event->save();

        return back();
    }

    public function reject($id)
    {
        if(auth()->user()->role !== 'admin'){
            abort(403);
        }

        $event = Event::findOrFail($id);
        $event->status = 'rejected';
        $event->save();

        return back();
    }

public function myEvents()
{
    $events = Event::where('user_id', auth()->id())
        ->orderBy('event_date','asc')
        ->get();

    return view('events.my-events', compact('events'));
}
public function pending()
{
    if(auth()->user()->role !=='admin'){
        abort(403);
    }
    $events = Event::Where('status','pending')
    ->orderBy('event_date','asc')
    ->get();
    return view('events.pending', compact('events'));
}

public function edit($id)
{
    $event = Event::findOrFail($id);

    if($event->user_id !== auth()->id()){
        abort(403);
    }

    return view('events.edit', compact('event'));
}

public function update(Request $request, $id)
{
    $event = Event::findOrFail($id);

    if($event->user_id !== auth()->id()){
        abort(403);
    }

    $request->validate([
        'title' => 'required|string',
        'description' => 'required|string',
        'event_date' => 'required|date',
        'location' => 'required|string',
        'capacity' => 'required|integer',
    ]);

    $event->update([
        'title' => $request->title,
        'description' => $request->description,
        'event_date' => $request->event_date,
        'location' => $request->location,
        'capacity' => $request->capacity,
        'status' => 'pending',
    ]);

    return redirect('/mis-eventos')->with('success', 'Evento actualizado y enviado a revisión');
}

public function destroy($id)
{
    $event = Event::findOrFail($id);

    if($event->user_id !== auth()->id()){
        abort(403);
    }

    $event->delete();

    return back();
}

public function register($id)
{
    $event = Event::findOrFail($id);

    // validar cupo
    if($event->registrations()->count() >= $event->capacity){
        return back()->with('error', 'Evento lleno');
    }

    // evitar doble registro
    $exist = Registration::where('user_id', auth()->id())
        ->where('event_id', $id)
        ->exists();

    if($exist){
        return back()->with('error','Ya estás registrado');
    }

    Registration::create([
        'user_id' => auth()->id(),
        'event_id' => $id,
    ]);

    return back()->with('success', 'Te registraste al evento');
}
public function myRegistrations()
{
    $registrations = \App\Models\Registration::where('user_id', auth()->id())
        ->with('event')
        ->get();

    return view('events.my-registrations', compact('registrations'));
}
public function unregister($id)
{
    $registration = \App\Models\Registration::where('user_id', auth()->id())
        ->where('event_id', $id)
        ->first();

    if(!$registration){
        return back()->with('error', 'No estás inscrito en este evento');
    }

    $registration->delete();

    return back()->with('success', 'Te diste de baja del evento');
}
public function show(Event $event)
{
    // Solo cargamos el conteo de inscritos para evitar errores de relación
    $event->loadCount('registrations');
    
    return view('events.show', compact('event'));
}
}

