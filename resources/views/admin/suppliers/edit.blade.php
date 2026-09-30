<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Proveedor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Editar Proveedor #{{ $supplier->id }}</h1>

        <form action="{{ route('admin.suppliers.update', $supplier) }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium mb-1">Nombre / Razón Social *</label>
                <input type="text" name="name" value="{{ $supplier->name }}" required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Tipo de Proveedor</label>
                <select name="type" class="w-full border rounded p-2">
                    <option value="mayorista" {{ $supplier->type == 'mayorista' ? 'selected' : '' }}>Mayorista / Distribuidor</option>
                    <option value="artesano" {{ $supplier->type == 'artesano' ? 'selected' : '' }}>Artesano / Productor Local</option>
                    <option value="consignacion" {{ $supplier->type == 'consignacion' ? 'selected' : '' }}>Consignación / Feria</option>
                    <option value="propio" {{ $supplier->type == 'propio' ? 'selected' : '' }}>Propio</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" value="{{ $supplier->email }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Teléfono</label>
                    <input type="text" name="phone" value="{{ $supplier->phone }}" class="w-full border rounded p-2">
                </div>
            </div>

            <div class="flex justify-between items-center pt-4">
                <a href="{{ route('admin.suppliers.index') }}" class="text-gray-600 hover:underline">Cancelar</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Actualizar Proveedor</button>
            </div>
        </form>
    </div>
</body>
</html>
