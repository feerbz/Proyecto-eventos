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