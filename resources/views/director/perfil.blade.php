@extends('layouts.director')

@section('title', 'Mi Perfil - Director')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Información del Director</h2>
            <p class="text-sm text-gray-600">Datos asociados a tu cuenta</p>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                <p class="text-sm text-gray-900">{{ Auth::user()->name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Correo</label>
                <p class="text-sm text-gray-900">{{ Auth::user()->email }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Rol</label>
                <p class="text-sm text-gray-900">Director</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Preferencias</h2>
            <p class="text-sm text-gray-600">Configuraciones personales</p>
        </div>
        <div class="p-6">
            <form class="space-y-6" onsubmit="event.preventDefault(); alert('Preferencias guardadas');">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tema</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-uth-green" aria-label="Tema">
                            <option>Claro</option>
                            <option>Oscuro</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Idioma</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-uth-green" aria-label="Idioma">
                            <option>Español</option>
                            <option>Inglés</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-uth-green text-white rounded-lg hover:bg-uth-green-dark">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
