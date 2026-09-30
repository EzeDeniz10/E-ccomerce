<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mi Perfil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- TARJETA DE BIENVENIDA -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-2xl font-bold text-gray-900">
                    ¡Bienvenido/a a nuestra tienda, {{ Auth::user()->name }}! 👋
                </h3>
                <p class="mt-1 text-sm text-gray-600">
                    Desde aquí puedes gestionar los datos de tu cuenta, actualizar tu contraseña y revisar tu información.
                </p>
            </div>

            <!-- ACTUALIZAR INFORMACIÓN -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- CAMBIAR CONTRASEÑA -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- ELIMINAR CUENTA -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
