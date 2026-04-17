<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function feed()
    {
        $events = Event::where('status','approved')
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
        'status' => 'pending', // 🔥 CLAVE
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




}

