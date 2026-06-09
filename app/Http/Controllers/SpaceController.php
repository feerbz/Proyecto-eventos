<?php

namespace App\Http\Controllers;

use App\Models\Space;
use Illuminate\Http\Request;

class SpaceController extends Controller
{
    public function create()
    {
        return view('spaces.create');
    }

    public function store(Request $request)
    {
        Space::create([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'is_unlimited' => $request->has('is_unlimited'),
        ]);

        return redirect('/dashboard')->with('success', 'Espacio creado');
    }
    public function index()
{
    $spaces = Space::all();

    return view('spaces.index', compact('spaces'));
}

public function edit($id)
{
    $space = Space::findOrFail($id);

    return view('spaces.edit', compact('space'));
}

public function update(Request $request, $id)
{
    $space = Space::findOrFail($id);

    $space->update([
        'name' => $request->name,
        'capacity' => $request->capacity,
        'is_unlimited' => $request->has('is_unlimited'),
    ]);

    return redirect('/spaces')
        ->with('success', 'Espacio actualizado');
}

public function destroy($id)
{
    $space = Space::findOrFail($id);

    if ($space->events()->exists()) {

        return redirect('/spaces')
            ->with('error',
                'No se puede eliminar un espacio con eventos asociados');
    }

    $space->delete();

    return redirect('/spaces')
        ->with('success', 'Espacio eliminado');
}
}
