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
    $request->validate([
        'name' => [
            'required',
            'string',
            'max:255',
            'not_regex:/^[0-9]+$/',
        ],
        'capacity' => [
            'nullable',
            'integer',
            'min:1',
        ],
    ], [
        'name.required' => 'El nombre del espacio es obligatorio.',
        'name.not_regex' => 'El nombre del espacio no puede contener únicamente números.',
        'capacity.integer' => 'La capacidad debe ser un número entero.',
        'capacity.min' => 'La capacidad debe ser mayor que 0.',
    ]);

    if (!$request->has('is_unlimited') && !$request->filled('capacity')) {
        return back()
            ->withErrors([
                'capacity' => 'La capacidad es obligatoria si el espacio no es ilimitado.'
            ])
            ->withInput();
    }

    Space::create([
        'name' => $request->name,
        'capacity' => $request->has('is_unlimited')
            ? null
            : $request->capacity,
        'is_unlimited' => $request->has('is_unlimited'),
    ]);

    return redirect('/dashboard')
        ->with('success', 'Espacio creado');
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
    $request->validate([
        'name' => [
            'required',
            'string',
            'max:255',
            'not_regex:/^[0-9]+$/',
        ],
        'capacity' => [
    'nullable',
    'integer',
    'min:1',
],
    ], [
        'name.required' => 'El nombre del espacio es obligatorio.',
        'name.not_regex' => 'El nombre del espacio no puede contener solamente numeros',
        'capacity.required_unless' => 'La capacidad es obligatoria si el espacio no es ilimitado.',
        'capacity.integer' => 'La capacidad debe ser un número entero.',
        'capacity.min' => 'La capacidad debe ser mayor que 0.',
    ]);

    $space = Space::findOrFail($id);
    $space->update([
    'name' => $request->name,
    'capacity' => $request->has('is_unlimited')
        ? null
        : $request->capacity,
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
