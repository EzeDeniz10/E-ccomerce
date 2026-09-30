@extends('layouts.shop')

@section('content')
    <div class="text-center mb-8">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Bienvenido a nuestra Tienda</h1>
        <p class="text-gray-600">Explora nuestro catálogo de categorías y productos.</p>
    </div>

    <!-- Sección de Productos / Categorías -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Ejemplo de tarjeta de producto/categoría -->
        @forelse($categories as $category)
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <h2 class="text-xl font-bold mb-2 text-gray-800">{{ $category->name }}</h2>
                <p class="text-gray-600 text-sm mb-4">{{ $category->description ?? 'Sin descripción' }}</p>
                <a href="#" class="inline-block bg-amber-400 text-black font-bold px-4 py-2 rounded hover:bg-amber-500">
                    Ver Categoría
                </a>
            </div>
        @empty
            <p class="col-span-3 text-center text-gray-500">No hay categorías disponibles por el momento.</p>
        @endforelse
    </div>
@endsection
