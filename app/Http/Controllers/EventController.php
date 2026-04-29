<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Space;
use App\Models\Registration;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /* ---------------- DASHBOARD ---------------- */
    public function feed()
    {
        $events = Event::where('status', 'approved')
            ->with(['registrations','user','space'])
            ->orderBy('event_date', 'asc')
            ->get();

        return view('dashboard', compact('events'));
    }

    /* ---------------- CREATE ---------------- */
    public function create()
    {
        $spaces = Space::all();
        return view('events.create', compact('spaces'));
    }

    /* ---------------- STORE ---------------- */
public function store(Request $request)
{
$request->validate([
    'title' => 'required|string',
    'description' => 'required|string',
    'event_date' => 'required|date',
    'end_time' => 'required|date_format:H:i',
    'capacity' => 'nullable|integer|min:1',
    'location' => 'nullable|string',
    'space_id' => 'nullable',
    'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
], [
    'image.mimes' => 'La imagen debe ser JPG, PNG o WEBP',
    'image.max' => 'La imagen no debe superar los 2MB',
]);

    $spaceId = $request->space_id;
    $customLocation = $request->location;

    // SI ES "OTRO"
    if ($spaceId === "other") {
        $spaceId = null;
    }

    // PARSEAR HORAS
    $start = \Carbon\Carbon::parse($request->event_date);
    $end = \Carbon\Carbon::parse($start->format('Y-m-d') . ' ' . $request->end_time);

    // VALIDAR HORAS
    if ($end <= $start) {
        return back()->with('error', 'La hora de fin debe ser mayor a la de inicio')->withInput();
    }

    
    if ($spaceId) {

        $events = Event::where('space_id', $spaceId)
            ->whereDate('event_date', $start->toDateString())
            ->get();

        foreach ($events as $event) {

            $eventStart = \Carbon\Carbon::parse($event->event_date);
            $eventEnd = \Carbon\Carbon::parse(
                $eventStart->format('Y-m-d') . ' ' . $event->end_time
            );

            
            if ($start < $eventEnd && $end > $eventStart) {
                return redirect()->back()
    ->with('error', 'Ese espacio ya está ocupado en ese horario')
    ->withInput();
            }
        }
    }

    // CAPACIDAD SEGÚN ESPACIO
    if ($spaceId) {
        $space = Space::find($spaceId);

        if ($space && $space->is_unlimited) {
            $capacity = null;
        } else {
            if (!$request->capacity) {
                return back()->with('error', 'La capacidad es obligatoria para este espacio')->withInput();
            }
            $capacity = $request->capacity;
        }
    } else {
        $capacity = $request->capacity;
    }

    // IMAGEN
    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('events', 'public');
    }

    // CREAR EVENTO
    $event = Event::create([
        'title' => $request->title,
        'description' => $request->description,
        'event_date' => $request->event_date,
        'end_time' => $request->end_time,
        'capacity' => $capacity,
        'status' => 'pending',
        'user_id' => auth()->id(),
        'space_id' => $spaceId,
        'location' => $customLocation,
        'image' => $imagePath,
    ]);

    // CATEGORÍAS
    if ($request->categories) {
        $event->categories()->attach($request->categories);
    }

    return redirect('/dashboard')->with('success', 'Evento creado correctamente');
}

    /* ---------------- INDEX ---------------- */
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $events = Event::orderBy('event_date', 'asc')->get();
        } else {
            $events = Event::where('status', 'approved')
                ->orderBy('event_date', 'asc')
                ->get();
        }

        return view('events.index', compact('events'));
    }

    /* ---------------- SHOW ---------------- */
    public function show(Event $event)
    {
        $event->loadCount('registrations');
        return view('events.show', compact('event'));
    }

    /* ---------------- EDIT ---------------- */
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('events.edit', compact('event'));
    }

    /* ---------------- UPDATE ---------------- */
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update($request->all());

        return redirect('/mis-eventos');
    }

    /* ---------------- DELETE ---------------- */
    public function destroy($id)
    {
        Event::findOrFail($id)->delete();
        return back();
    }

    /* ---------------- REGISTER ---------------- */
    public function register($id)
    {
        $event = Event::with('space')->findOrFail($id);
        $total = $event->registrations()->count();

        if (!$event->space?->is_unlimited && $total >= $event->capacity) {
            return back()->with('error', 'Evento lleno');
        }

        $exists = Registration::where('user_id', auth()->id())
            ->where('event_id', $id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Ya estás registrado');
        }

        Registration::create([
            'user_id' => auth()->id(),
            'event_id' => $id,
        ]);

        return back()->with('success', 'Registrado');
    }

    /* ---------------- MIS EVENTOS ---------------- */
    public function myEvents()
    {
        $events = Event::where('user_id', auth()->id())
            ->orderBy('event_date', 'asc')
            ->get();

        return view('events.my-events', compact('events'));
    }

    /* ---------------- MIS INSCRIPCIONES ---------------- */
    public function myRegistrations()
    {
        $registrations = Registration::where('user_id', auth()->id())
            ->with('event')
            ->get();

        return view('events.my-registrations', compact('registrations'));
    }

    /* ---------------- PENDIENTES ---------------- */
    public function pending()
    {
        $events = Event::where('status', 'pending')
            ->orderBy('event_date', 'asc')
            ->get();

        return view('events.pending', compact('events'));
    }

    public function approve($id)
    {
        $event = Event::findOrFail($id);
        $event->status = 'approved';
        $event->save();

        return back()->with('success', 'Evento aprobado');
    }

    public function reject($id)
    {
        $event = Event::findOrFail($id);
        $event->status = 'rejected';
        $event->save();

        return back()->with('error', 'Evento rechazado');
    }

    public function unregister($id)
    {
        Registration::where('user_id', auth()->id())
            ->where('event_id', $id)
            ->delete();

        return back()->with('success', 'Inscripción cancelada');
    }
}


