<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Fallido - Mi Tienda</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-xl shadow-md text-center max-w-md w-full mx-4">
        <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl font-bold">
            ✕
        </div>

        <h1 class="text-2xl font-bold text-gray-800 mb-2">El pago no pudo ser procesado</h1>
        <p class="text-gray-600 mb-6">Hubo un problema al procesar tu pago a través de Mercado Pago. Puedes intentar nuevamente.</p>

        <div class="space-y-3">
            <a href="{{ route('cart.index') }}" class="block w-full bg-amber-400 hover:bg-amber-500 text-black font-bold py-2.5 rounded-lg border-2 border-black transition">
                Volver al Carrito
            </a>
            <a href="{{ route('home') }}" class="block w-full text-sm text-gray-500 hover:text-gray-800 font-medium">
                Ir al Inicio
            </a>
        </div>
    </div>

</body>
</html>
