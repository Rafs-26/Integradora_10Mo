@extends('layouts.app')

@section('title', 'Mi Perfil - Profesor')
@section('page-title', 'Mi Perfil')

@section('sidebar-menu')
    <a href="{{ route('teacher.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-2">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
        </svg>
        Inicio
    </a>

    <a href="{{ route('teacher.perfil') }}" class="flex items-center px-4 py-3 text-uth-green bg-uth-green/10 rounded-lg mb-2">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
        Mi Perfil
    </a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
    @endif
    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <ul class="text-sm text-red-800 list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Información del Profesor</h2>
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
                <label class="block text-sm font-medium text-gray-700 mb-1">Especialidad</label>
                <p class="text-sm text-gray-900">{{ $profesor->especialidad ?? 'No especificada' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Grado Académico</label>
                <p class="text-sm text-gray-900">{{ $profesor->grado_academico ?? 'No especificado' }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Actualizar Perfil</h2>
            <p class="text-sm text-gray-600">Modifica tu información de contacto</p>
        </div>
        <div class="p-6">
            <form action="{{ route('teacher.perfil.actualizar') }}" method="POST" class="space-y-6" novalidate>
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                        <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $profesor->telefono) }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-uth-green" maxlength="20" pattern="^[0-9\-\s\+]{7,20}$" aria-describedby="telefonoHelp">
                        <p id="telefonoHelp" class="text-xs text-gray-500 mt-1">Solo números, espacios y '+ -'.</p>
                    </div>
                    <div>
                        <label for="extension" class="block text-sm font-medium text-gray-700 mb-1">Extensión</label>
                        <input type="text" id="extension" name="extension" value="{{ old('extension', $profesor->extension) }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-uth-green" maxlength="10">
                    </div>
                    <div>
                        <label for="especialidad" class="block text-sm font-medium text-gray-700 mb-1">Especialidad</label>
                        <input type="text" id="especialidad" name="especialidad" value="{{ old('especialidad', $profesor->especialidad) }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-uth-green" maxlength="255">
                    </div>
                    <div>
                        <label for="grado_academico" class="block text-sm font-medium text-gray-700 mb-1">Grado Académico</label>
                        <input type="text" id="grado_academico" name="grado_academico" value="{{ old('grado_academico', $profesor->grado_academico) }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-uth-green" maxlength="100">
                    </div>
                </div>
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('teacher.dashboard') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Cancelar</a>
                    <button type="submit" class="px-6 py-2 bg-uth-green text-white rounded-lg hover:bg-uth-green-dark">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
