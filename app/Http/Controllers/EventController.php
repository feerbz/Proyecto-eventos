<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Space;
use App\Models\Category;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\Waitlist;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class EventController extends Controller
{
    /* ---------------- DASHBOARD ---------------- */
public function feed(Request $request)
{
    $events = Event::where('status', 'approved')
        ->with([
            'registrations',
            'user',
            'space',
            'categories'
        ]);

    if ($request->category) {
        $events->whereHas('categories', function ($query) use ($request) {
        $query->where('categories.id', $request->category);
        });
    }

    $events = $events
        ->orderBy('event_date', 'asc')
        ->get();

    $categories = \App\Models\Category::orderBy('name')->get();

    return view('dashboard', compact('events', 'categories'));
}

    /* ---------------- CREATE ---------------- */
    public function create()
    {
    $spaces = Space::all();
    $categories = Category::all();

    return view('events.create', compact('spaces', 'categories'));
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
        'location' => $spaceId ? null : $customLocation,
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

    $spaces = Space::all();
    $categories = Category::all();

    return view(
        'events.edit',
        compact('event', 'spaces', 'categories')
    );
}

    /* ---------------- UPDATE ---------------- */
    public function update(Request $request, $id)
{
    $event = Event::findOrFail($id);

    $spaceId = $request->space_id;
    $customLocation = $request->location;

    if ($spaceId === "other") {
        $spaceId = null;
    }
    $start = \Carbon\Carbon::parse($request->event_date);
$end = \Carbon\Carbon::parse(
    $start->format('Y-m-d') . ' ' . $request->end_time
);

if ($end <= $start) {
    return back()
        ->with('error', 'La hora de fin debe ser mayor a la de inicio')
        ->withInput();
}
    // CAPACIDAD
    if ($spaceId) {

        $space = Space::find($spaceId);

        if ($space && $space->is_unlimited) {
            $capacity = null;
        } else {
            $capacity = $request->capacity;
        }

    } else {

        $capacity = $request->capacity;
    }

    // IMAGEN
    $imagePath = $event->image;

    if ($request->hasFile('image')) {

        $imagePath = $request
            ->file('image')
            ->store('events', 'public');
    }
    if ($spaceId) {

    $events = Event::where('space_id', $spaceId)
        ->where('id', '!=', $event->id)
        ->whereDate('event_date', $start->toDateString())
        ->get();

    foreach ($events as $otherEvent) {

        $eventStart = \Carbon\Carbon::parse(
            $otherEvent->event_date
        );

        $eventEnd = \Carbon\Carbon::parse(
            $eventStart->format('Y-m-d') . ' ' . $otherEvent->end_time
        );

        if ($start < $eventEnd && $end > $eventStart) {

            return back()
                ->with('error', 'Ese espacio ya está ocupado en ese horario')
                ->withInput();
        }
    }
}
    $event->update([
        'title' => $request->title,
        'description' => $request->description,
        'event_date' => $request->event_date,
        'capacity' => $capacity,
        'space_id' => $spaceId,
        'location' => $spaceId ? null : $customLocation,
        'image' => $imagePath,
        'end_time' => $request->end_time,

        // vuelve a revisión
        'status' => 'pending',
    ]);

    // categorías
    $event->categories()->sync(
        $request->categories ?? []
    );

    return redirect('/mis-eventos')
        ->with('success', 'Evento actualizado y enviado nuevamente a revisión');
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

    $waitingUser = Waitlist::where('event_id', $id)
        ->orderBy('created_at')
        ->first();

    if ($waitingUser) {

        Registration::create([
            'user_id' => $waitingUser->user_id,
            'event_id' => $id,
        ]);

        Mail::raw(
            'Se liberó un lugar y has sido inscrito automáticamente en el evento.',
            function ($message) use ($waitingUser) {
                $message->to($waitingUser->user->email)
                        ->subject('Inscripción automática');
            }
        );

        $waitingUser->delete();
    }

    return back()->with('success', 'Inscripción cancelada');
}
    public function joinWaitlist($id)
{
    $exists = Waitlist::where('user_id', auth()->id())
        ->where('event_id', $id)
        ->exists();

    if ($exists) {
        return back()->with('error', 'Ya estás en lista de espera');
    }

    Waitlist::create([
        'user_id' => auth()->id(),
        'event_id' => $id,
    ]);

    return back()->with('success', 'Agregado a lista de espera');
}
public function leaveWaitlist($id)
{
    Waitlist::where('user_id', auth()->id())
        ->where('event_id', $id)
        ->delete();

    return back()->with(
        'success',
        'Has salido de la lista de espera'
    );
}
public function history()
{
    $registrations = Registration::where('user_id', auth()->id())
        ->with('event')
        ->get();

    $waitlists = Waitlist::where('user_id', auth()->id())
        ->with('event')
        ->get();

    return view('events.history', compact(
        'registrations',
        'waitlists'
    ));
}
public function calendar()
{
    $events = Event::where('status', 'approved')
        ->get();

    return view('events.calendar', compact('events'));
}

}


