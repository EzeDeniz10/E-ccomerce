<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category; // <-- Importante
use App\Models\Supplier; // <-- Importante si usas proveedores
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Trae los productos paginados y sus relaciones para evitar N+1 queries
        $products = Product::with(['category', 'supplier'])->latest()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

   public function create()
    {
        // Consultamos las categorías disponibles
        $categories = Category::all();

        // Si también necesitas proveedores en tu formulario:
        $suppliers = Supplier::all();

        // Enviamos las variables a la vista
        return view('admin.products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        // Lógica para guardar el producto
    }

   public function edit(Product $product)
{
    $categories = Category::all();
    $suppliers = Supplier::all();

    return view('admin.products.edit', compact('product', 'categories', 'suppliers'));
}

    public function update(Request $request, Product $product)
    {
        // Lógica para actualizar el producto
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}
