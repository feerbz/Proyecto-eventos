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
}
