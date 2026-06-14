<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Space;
use App\Models\Category;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\Waitlist;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\RegistrationSuccessMail;
use App\Mail\EventUpdatedMail;
use App\Models\Favorite;


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
    $event->load(
    'registrations.user',
    'space'
);

foreach ($event->registrations as $registration) {

    Mail::to(
        $registration->user->email
    )->send(
        new EventUpdatedMail($event)
    );

}
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
        Mail::to(auth()->user()->email)
    ->send(new RegistrationSuccessMail($event));


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

public function reject(Request $request, $id)
{
    $event = Event::findOrFail($id);

    $event->status = 'rejected';

    $event->admin_comment =
        $request->admin_comment;

    $event->save();

    return back()->with(
        'error',
        'Evento rechazado'
    );
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

public function calendar(Request $request)
{
    $events = Event::where('status', 'approved')
        ->with('space');

    if ($request->space_id) {

        $events->where('space_id', $request->space_id);

    }

    $events = $events->get();

    $spaces = Space::orderBy('name')->get();

    return view(
        'events.calendar',
        compact('events', 'spaces')
    );
}
public function metrics()
{
    $totalEvents = Event::count();

    $approvedEvents = Event::where(
        'status',
        'approved'
    )->count();

    $pendingEvents = Event::where(
        'status',
        'pending'
    )->count();

    $totalUsers = User::count();

    $totalRegistrations = Registration::count();

    $totalWaitlist = Waitlist::count();

    $totalAttendances = Attendance::count();

    $attendanceRate = $totalRegistrations > 0
        ? round(
            ($totalAttendances * 100) / $totalRegistrations,
            2
        )
        : 0;
        $eventMetrics = Event::withCount([
    'registrations',
    'attendances'
])->get();
$chartLabels = $eventMetrics->pluck('title');

$chartData = $eventMetrics->map(function ($event) {

    return $event->registrations_count > 0
        ? round(
            ($event->attendances_count * 100)
            / $event->registrations_count,
            2
        )
        : 0;

});
    return view('events.metrics', compact(
        'totalEvents',
        'approvedEvents',
        'pendingEvents',
        'totalUsers',
        'totalRegistrations',
        'totalWaitlist',
        'totalAttendances',
        'attendanceRate',
        'eventMetrics',
        'chartLabels',
        'chartData'
    ));
}
public function attendanceForm($id)
{
    $event = Event::findOrFail($id);

    return view(
        'events.attendance',
        compact('event')
    );
}
public function registerAttendance(Request $request, $id)
{
    $user = User::where(
        'email',
        $request->email
    )->first();

    if (!$user) {

        return back()->with(
            'error',
            'No existe un usuario con ese correo.'
        );
    }

    $registered = Registration::where(
        'user_id',
        $user->id
    )
    ->where(
        'event_id',
        $id
    )
    ->exists();

    if (!$registered) {

        return back()->with(
            'error',
            'El usuario no está inscrito en este evento.'
        );
    }

    $alreadyExists = Attendance::where(
        'user_id',
        $user->id
    )
    ->where(
        'event_id',
        $id
    )
    ->exists();

    if ($alreadyExists) {

        return back()->with(
            'error',
            'La asistencia ya fue registrada.'
        );
    }

    Attendance::create([
        'user_id' => $user->id,
        'event_id' => $id
    ]);

    return back()->with(
        'success',
        'Asistencia registrada correctamente.'
    );
}
public function attendanceIndex()
{
    $events = Event::whereDate(
            'event_date',
            now()->toDateString()
        )
        ->where('status', 'approved');

    if (auth()->user()->role !== 'admin') {

        $events->where(
            'user_id',
            auth()->id()
        );

    }

    $events = $events->get();

    return view(
        'attendance.index',
        compact('events')
    );
}
public function exportMetrics()
{
    $filename = 'reporte_eventos.csv';

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="'.$filename.'"',
    ];

    $callback = function () {

        $file = fopen('php://output', 'w');

        fputcsv($file, [
            'Evento',
            'Registrados',
            'Asistencias',
            'Porcentaje'
        ]);

        $events = Event::withCount([
            'registrations',
            'attendances'
        ])->get();

        foreach ($events as $event) {

            $percent = $event->registrations_count > 0
                ? round(
                    ($event->attendances_count * 100)
                    / $event->registrations_count,
                    2
                )
                : 0;

            fputcsv($file, [
                $event->title,
                $event->registrations_count,
                $event->attendances_count,
                $percent . '%'
            ]);
        }

        fclose($file);
    };

    return response()->stream(
        $callback,
        200,
        $headers
    );
}
public function exportMetricsPdf()
{
    $totalEvents = Event::count();

    $totalUsers = User::count();

    $totalRegistrations = Registration::count();

    $totalAttendances = Attendance::count();

    $attendanceRate = $totalRegistrations > 0
        ? round(
            ($totalAttendances * 100) / $totalRegistrations,
            2
        )
        : 0;

    $eventMetrics = Event::withCount([
        'registrations',
        'attendances'
    ])->get();

    $pdf = Pdf::loadView(
        'pdf.metrics',
        compact(
            'totalEvents',
            'totalUsers',
            'totalRegistrations',
            'totalAttendances',
            'attendanceRate',
            'eventMetrics'
        )
    );

    return $pdf->download(
        'Reporte_UniEvent.pdf'
    );
}
public function favorite($id)
{
    $exists = Favorite::where(
        'user_id',
        auth()->id()
    )
    ->where(
        'event_id',
        $id
    )
    ->exists();

    if (!$exists) {

        Favorite::create([
            'user_id' => auth()->id(),
            'event_id' => $id
        ]);

    }

    return back()->with(
        'success',
        'Evento agregado a favoritos'
    );
}

public function unfavorite($id)
{
    Favorite::where(
        'user_id',
        auth()->id()
    )
    ->where(
        'event_id',
        $id
    )
    ->delete();

    return back()->with(
        'success',
        'Evento eliminado de favoritos'
    );
}

public function favorites()
{
    $events = Event::whereIn(
        'id',
        Favorite::where(
            'user_id',
            auth()->id()
        )->pluck('event_id')
    )->get();

    return view(
        'events.favorites',
        compact('events')
    );
}

}


