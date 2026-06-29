<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('events')->get();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }
    public function store(Request $request)
{
    $request->validate([
        'name' => [
            'required',
            'string',
            'max:255',
            'regex:/.*[A-Za-zÁÉÍÓÚáéíóúÑñ].*/',
        ],
    ], [
        'name.required' => 'El nombre de la categoría es obligatorio.',
        'name.regex' => 'La categoría debe contener al menos una letra.',
        'name.max' => 'La categoría no puede tener más de 255 caracteres.',
    ]);

    Category::create([
        'name' => $request->name,
    ]);

    return redirect('/categories')
        ->with('success', 'Categoría creada');
}

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $category->events()->detach();

        $category->delete();

        return redirect('/categories')
            ->with('success', 'Categoría eliminada');
    }
}