<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Tienda Online</title>
    <!-- Tailwind CSS (puedes usar Vite o CDN para pruebas rápidas) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 flex flex-col min-h-screen">

    <!-- Header / Navbar del Cliente -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-amber-500">Mi Tienda</a>
            <nav class="space-x-4">
                <a href="/" class="hover:text-amber-500">Inicio</a>
                <a href="#productos" class="hover:text-amber-500">Productos</a>
                <!-- Enlace al admin si el usuario inició sesión -->
                @auth
                    <a href="/admin/categories" class="text-sm bg-gray-800 text-white px-3 py-1.5 rounded-lg">Panel Admin</a>
                @endauth
            </nav>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="flex-grow max-w-7xl mx-auto px-4 py-8 w-full">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center py-4 mt-8">
        <p>&copy; {{ date('Y') }} Mi Tienda Online. Todos los derechos reservados.</p>
    </footer>

</body>
</html>
