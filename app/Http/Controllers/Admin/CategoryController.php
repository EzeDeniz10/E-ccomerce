<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // Mostrar el listado de categorías
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    // Mostrar el formulario para crear una categoría
    public function create()
    {
        return view('admin.categories.create');
    }

    // Guardar la categoría en la base de datos
   // Guardar la categoría en la base de datos
   // Guardar la categoría en la base de datos

public function store(Request $request)
{
    $slug = Str::slug($request->name);

    // Si la categoría ya existe (incluso eliminada de forma lógica), genera un slug único
    if (Category::withTrashed()->where('slug', $slug)->exists()) {
        $slug = $slug . '-' . Str::random(4); // Ejemplo: "remeras-k2p8"
    }

    Category::create([
        'name' => $request->name,
        'slug' => $slug,
    ]);

    return redirect()->route('admin.categories.index')->with('success', 'Categoría creada correctamente.');
}

    // Formulario para editar
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // Actualizar los datos
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Categoría actualizada con éxito.');
    }

    // Eliminar la categoría
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Categoría eliminada con éxito.');
    }
}
