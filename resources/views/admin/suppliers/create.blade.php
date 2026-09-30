<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Agregar Nuevo Proveedor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Mostrar errores de validación si existen --}}
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                        <ul class="list-disc pl-5 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.suppliers.store') }}" method="POST" class="space-y-4">
                    @csrf

                    {{-- Nombre / Razón Social --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre / Razón Social *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500">
                    </div>

                    {{-- Tipo de Proveedor --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo de Proveedor</label>
                        <select name="type" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500">
                            <option value="mayorista" {{ old('type') == 'mayorista' ? 'selected' : '' }}>Mayorista / Distribuidor</option>
                            <option value="artesano" {{ old('type') == 'artesano' ? 'selected' : '' }}>Artesano / Productor Local</option>
                            <option value="consignacion" {{ old('type') == 'consignacion' ? 'selected' : '' }}>Consignación / Feria</option>
                            <option value="propio" {{ old('type') == 'propio' ? 'selected' : '' }}>Propio</option>
                        </select>
                    </div>

                    {{-- Email y Teléfono --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Teléfono</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500">
                        </div>
                    </div>

                    {{-- Botones de acción --}}
                    <div class="flex justify-between items-center pt-4">
                        <a href="{{ route('admin.suppliers.index') }}" class="text-gray-600 dark:text-gray-400 hover:underline">Cancelar</a>
                        <button type="submit" class="px-4 py-2 bg-amber-400 text-black font-extrabold text-sm rounded-lg border-2 border-black hover:bg-amber-500 shadow-md transition">
                            Guardar Proveedor
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
