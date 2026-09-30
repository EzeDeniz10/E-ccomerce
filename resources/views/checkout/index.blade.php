<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos de Envío - Mi Tienda</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 antialiased min-h-screen">

    <header class="bg-slate-900 text-white shadow-lg py-4">
        <div class="max-w-6xl mx-auto px-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-black text-amber-400 tracking-wide">MI TIENDA</a>
            <a href="{{ route('cart.index') }}" class="text-sm font-bold text-gray-300 hover:text-amber-400">← Volver al Carrito</a>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 py-10">
        <h1 class="text-3xl font-black mb-8">Datos de Entrega</h1>

        <div class="bg-white rounded-2xl shadow-md border p-6 md:p-8">

            <form action="{{ route('checkout.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nombre Completo *</label>
                        <input type="text" name="customer_name" value="{{ old('customer_name') }}" required class="w-full p-3 border rounded-xl bg-gray-50 focus:ring-2 focus:ring-amber-400 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Teléfono de Contacto *</label>
                        <!-- CORREGIDO: Cambiado de name="phone" a name="customer_phone" -->
                        <input type="tel" name="customer_phone" value="{{ old('customer_phone') }}" inputmode="tel" required class="w-full p-3 border rounded-xl bg-gray-50 focus:ring-2 focus:ring-amber-400 focus:outline-none" placeholder="Ej: 1122334455">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Correo Electrónico (Opcional)</label>
                    <input type="email" name="customer_email" value="{{ old('customer_email') }}" inputmode="email" class="w-full p-3 border rounded-xl bg-gray-50 focus:ring-2 focus:ring-amber-400 focus:outline-none" placeholder="ejemplo@correo.com">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Dirección de Entrega *</label>
                        <input type="text" name="address" value="{{ old('address') }}" required class="w-full p-3 border rounded-xl bg-gray-50 focus:ring-2 focus:ring-amber-400 focus:outline-none" placeholder="Calle y número">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Ciudad / Localidad *</label>
                        <input type="text" name="city" value="{{ old('city') }}" required class="w-full p-3 border rounded-xl bg-gray-50 focus:ring-2 focus:ring-amber-400 focus:outline-none">
                    </div>
                </div>

                <button type="submit" class="w-full py-4 bg-emerald-500 text-white font-black text-lg rounded-xl hover:bg-emerald-600 transition shadow-lg mt-4">
                    📦 CONFIRMAR Y FINALIZAR COMPRA
                </button>

                <!-- Bloque para mostrar mensajes de error si ocurren -->
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6">
                        <p class="font-bold">Revisá los siguientes campos:</p>
                        <ul class="list-disc pl-5 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6 font-bold">
                        {{ session('error') }}
                    </div>
                @endif
            </form>
        </div>
    </main>
</body>
</html>
