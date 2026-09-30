<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden #{{ $order->id }} - Panel Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen">

    <header class="bg-slate-900 text-white shadow-lg py-4">
        <div class="max-w-5xl mx-auto px-4 flex justify-between items-center">
            <a href="{{ route('admin.orders.index') }}" class="text-sm font-bold text-amber-400 hover:underline">← Volver a la Lista de Pedidos</a>
            <span class="text-xs text-gray-400">Orden #{{ $order->id }}</span>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-8">

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 rounded-r-lg font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Columna Izquierda: Detalle de Productos -->
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-md border p-6">
                    <h2 class="text-xl font-black text-slate-900 mb-4">Productos Comprados</h2>
                    <div class="divide-y">
                        @foreach($order->items as $item)
                            <div class="py-4 flex justify-between items-center">
                                <div>
                                    <h4 class="font-bold text-slate-800">{{ $item->product ? $item->product->name : 'Producto Eliminado' }}</h4>
                                    <p class="text-xs text-gray-500">Cantidad: {{ $item->quantity }} x ${{ number_format($item->price, 2) }}</p>
                                </div>
                                <span class="font-black text-emerald-600">${{ number_format($item->quantity * $item->price, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="border-t pt-4 mt-4 flex justify-between items-center text-lg font-black">
                        <span>Total Pedido:</span>
                        <span class="text-emerald-600">${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Columna Derecha: Datos Cliente y Cambio de Estado -->
            <div class="space-y-6">
                <!-- Datos del Cliente -->
                <div class="bg-white rounded-2xl shadow-md border p-6 space-y-3">
                    <h3 class="font-black text-slate-900 border-b pb-2">Datos del Cliente</h3>
                    <p class="text-sm"><span class="font-bold">Nombre:</span> {{ $order->customer_name }}</p>
                    <p class="text-sm"><span class="font-bold">Teléfono:</span> {{ $order->customer_phone }}</p>
                    <p class="text-sm"><span class="font-bold">Email:</span> {{ $order->customer_email ?? 'No especificado' }}</p>
                    <p class="text-sm"><span class="font-bold">Dirección:</span> {{ $order->address }}</p>
                    <p class="text-sm"><span class="font-bold">Ciudad:</span> {{ $order->city }}</p>
                </div>

                <!-- Cambiar Estado -->
                <div class="bg-white rounded-2xl shadow-md border p-6">
                    <h3 class="font-black text-slate-900 mb-3">Actualizar Estado</h3>
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="space-y-3">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="w-full p-2.5 border rounded-xl bg-gray-50 font-bold focus:ring-2 focus:ring-amber-400 focus:outline-none">
                            <option value="pendiente" {{ $order->status == 'pendiente' ? 'selected' : '' }}>PENDIENTE</option>
                            <option value="enviado" {{ $order->status == 'enviado' ? 'selected' : '' }}>ENVIADO</option>
                            <option value="entregado" {{ $order->status == 'entregado' ? 'selected' : '' }}>ENTREGADO</option>
                            <option value="cancelado" {{ $order->status == 'cancelado' ? 'selected' : '' }}>CANCELADO</option>
                        </select>
                        <button type="submit" class="w-full py-2.5 bg-slate-900 text-amber-400 font-bold rounded-xl hover:bg-slate-800 transition shadow-md">
                            Guardar Cambio
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </main>

</body>
</html>
