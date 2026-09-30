<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos - Mi Tienda</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    <!-- Cálculo dinámico de cantidad de productos en el carrito -->
    @php
        $cart = session('cart', []);
        $cartCount = array_sum(array_column($cart, 'quantity'));
    @endphp

    <!-- Navegación del Cliente -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('home') }}" class="text-2xl font-black text-amber-500 tracking-wide">
                    MI TIENDA
                </a>

                <div class="flex items-center space-x-4">
                    <!-- Enlace al Carrito con Contador Dinámico -->
                    <a href="{{ route('cart.index') }}" class="relative px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg flex items-center gap-2 transition">
                        <span>🛒 Carrito</span>
                        @if($cartCount > 0)
                            <span class="absolute -top-1.5 -right-1.5 bg-red-600 text-white text-xs font-black rounded-full h-5 w-5 flex items-center justify-center border-2 border-white shadow-md">
                                {{ $cartCount > 99 ? '99+' : $cartCount }}
                            </span>
                        @endif
                    </a>

                    <!-- Accesos de Usuario / Admin -->
                    @auth
                        <!-- Enlace a Mi Perfil -->
                        <a href="{{ route('profile.edit') }}" class="text-sm font-semibold text-gray-700 hover:text-amber-600 transition">
                            👤 {{ Auth::user()->name }}
                        </a>

                        @if(auth()->user()->is_admin ?? false)
                            <a href="{{ route('admin.products.index') }}" class="px-3 py-1.5 bg-gray-900 text-white text-sm font-medium rounded-md hover:bg-gray-800">
                                Panel Admin
                            </a>
                        @endif

                        <!-- Botón para Cerrar Sesión -->
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-semibold transition ml-1">
                                Cerrar Sesión
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 font-semibold">Ingresar</a>
                        <a href="{{ route('register') }}" class="text-sm bg-amber-400 text-black px-3 py-1.5 rounded-md font-bold hover:bg-amber-500 transition">Registrarse</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-grow w-full">

        <!-- Banner / Encabezado -->
        <div class="mb-8 text-center sm:text-left">
            <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Nuestros Productos</h1>
            <p class="mt-2 text-gray-600">Encuentra los mejores artículos al mejor precio.</p>
        </div>

        <!-- Filtro por Categorías -->
        <div class="mb-8">
            <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Filtrar por Categoría</h2>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('home') }}"
                   class="px-4 py-2 rounded-full text-sm font-medium transition {{ request('category') == '' ? 'bg-amber-400 text-black font-bold shadow-sm' : 'bg-white text-gray-700 border hover:bg-gray-50' }}">
                    Todas
                </a>

                @foreach($categories as $category)
                    <a href="{{ route('home', ['category' => $category->id]) }}"
                       class="px-4 py-2 rounded-full text-sm font-medium transition {{ request('category') == $category->id ? 'bg-amber-400 text-black font-bold shadow-sm' : 'bg-white text-gray-700 border hover:bg-gray-50' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Grilla de Productos -->
        @if($products->isEmpty())
            <div class="text-center py-12 bg-white rounded-xl shadow-sm border border-gray-100">
                <p class="text-gray-500 text-lg">No se encontraron productos en esta sección.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 flex flex-col overflow-hidden">

                        <!-- Imagen del producto -->
                        <div class="h-48 w-full bg-gray-100 flex items-center justify-center overflow-hidden">
                            @if($product->image)
                               <img src="{{ asset('storage/' . $product->image) }}"
                                 alt="{{ $product->name }}"
                                 onerror="this.onerror=null; this.src='{{ asset('images/placeholder.jpg') }}';"
                                   class="w-full h-48 object-cover">
                            @else
                                <span class="text-gray-400 text-sm">Sin imagen</span>
                            @endif
                        </div>

                        <!-- Info del producto -->
                        <div class="p-4 flex-grow flex flex-col justify-between">
                            <div>
                                <span class="text-xs font-semibold text-amber-600 uppercase tracking-wider">
                                    {{ $product->category->name ?? 'General' }}
                                </span>
                                <h3 class="text-lg font-bold text-gray-900 mt-1 line-clamp-1">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-sm text-gray-500 mt-1 line-clamp-2">
                                    {{ $product->description ?? 'Sin descripción disponible.' }}
                                </p>
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                                <span class="text-xl font-black text-gray-900">
                                    ${{ number_format($product->price, 2) }}
                                </span>

                                <!-- Formulario Agregar al Carrito -->
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-amber-400 hover:bg-amber-500 text-black font-extrabold px-3 py-1.5 rounded-lg text-sm border-2 border-black transition shadow-sm">
                                        + Agregar
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-6 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Mi Tienda Online. Todos los derechos reservados.
        </div>
    </footer>

</body>
</html>
