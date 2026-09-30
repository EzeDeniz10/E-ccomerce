<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Mi Tienda</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 antialiased min-h-screen">

    <!-- Header / Navbar -->
    <header class="bg-slate-900 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-black text-amber-400 tracking-wide">
                MI TIENDA
            </a>
            <a href="{{ route('home') }}" class="text-sm font-bold text-gray-300 hover:text-amber-400 transition">
                ← Volver a la Tienda
            </a>
        </div>
    </header>

    <!-- Contenido del Producto -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden grid grid-cols-1 md:grid-cols-2 gap-8 p-6 md:p-8">

            <!-- Columna Izquierda: Imagen del Producto -->
            <div class="bg-gray-100 rounded-xl overflow-hidden flex items-center justify-center border border-gray-200 max-h-[450px]">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                    <div class="py-24 text-gray-400 font-bold text-lg">Sin Imagen Disponible</div>
                @endif
            </div>

            <!-- Columna Derecha: Detalles del Producto -->
            <div class="flex flex-col justify-between">
                <div>
                    <!-- Categoría Badge -->
                    <span class="inline-block bg-slate-900 text-amber-400 text-xs font-bold px-3 py-1 rounded-full mb-3">
                        {{ $product->category->name ?? 'Sin Categoría' }}
                    </span>

                    <!-- Nombre y Precio -->
                    <h1 class="text-3xl font-black text-slate-900 mb-2 leading-tight">{{ $product->name }}</h1>
                    <div class="text-3xl font-black text-emerald-600 mb-4">${{ number_format($product->price, 2) }}</div>

                    <!-- Descripción -->
                    <div class="border-t border-b border-gray-200 py-4 my-4">
                        <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Descripción</h3>
                        <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">
                            {{ $product->description ?? 'Este producto no cuenta con una descripción detallada por el momento.' }}
                        </p>
                    </div>

                    <!-- Stock e Información adicional -->
                    <div class="flex items-center space-x-2 text-sm text-gray-500 mb-6 font-medium">
                        <span>Disponibilidad:</span>
                        @if($product->stock > 0)
                            <span class="text-emerald-600 font-bold">{{ $product->stock }} unidades disponibles</span>
                        @else
                            <span class="text-red-600 font-bold">Sin Stock disponible</span>
                        @endif
                    </div>
                </div>

                <!-- Selección de Cantidad y Botón Agregar -->
             <form action="{{ route('cart.add', $product) }}" method="POST" class="space-y-4">
    @csrf
    <div class="flex items-center space-x-4">
        <label for="quantity" class="text-sm font-bold text-gray-700">Cantidad:</label>
        <select id="quantity" name="quantity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 font-bold focus:ring-amber-400 focus:border-amber-400">
            @for($i = 1; $i <= min(10, max(1, $product->stock)); $i++)
                <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'unidad' : 'unidades' }}</option>
            @endfor
        </select>
    </div>

    <button type="submit" class="w-full py-3.5 bg-amber-400 text-black font-black text-base rounded-xl border-2 border-black hover:bg-amber-500 transition shadow-lg transform active:scale-[0.98]">
        🛒 AGREGAR AL CARRITO
    </button>
</form>

            </div>

        </div>

        <!-- Sección de Productos Relacionados -->
        @if($relatedProducts->count() > 0)
            <div class="mt-14">
                <h2 class="text-2xl font-black text-slate-900 mb-6">Productos Relacionados</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                        <a href="{{ route('products.show', $related) }}" class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden hover:shadow-lg transition p-3 flex flex-col justify-between">
                            <div class="h-32 bg-gray-100 rounded-lg overflow-hidden mb-3">
                                @if($related->image)
                                    <img src="{{ asset('storage/' . $related->image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-xs text-gray-400">Sin foto</div>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-slate-900 truncate">{{ $related->name }}</h4>
                                <p class="text-emerald-600 font-black text-sm">${{ number_format($related->price, 2) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </main>

</body>
</html>
