@extends('layouts.app')

@section('title', 'Revisar Memoria - Sistema de Estadías UTH')
@section('page-title', 'Revisar Memoria de Estadía')

@section('sidebar-menu')
    <!-- Dashboard -->
    <a href="{{ route('biblioteca.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-2">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
        </svg>
        Inicio
    </a>
    
    <!-- Validación de Memorias -->
    <div class="mb-4">
        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Validación de Memorias</h3>
        <a href="{{ route('biblioteca.memorias-pendientes') }}" class="flex items-center px-4 py-3 text-uth-green bg-uth-green/10 rounded-lg mb-1">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Memorias Pendientes
        </a>
        <a href="{{ route('biblioteca.memorias-validadas') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 8l2 2 4-4"></path>
            </svg>
            Memorias Validadas
        </a>
        <a href="{{ route('biblioteca.memorias-rechazadas') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Memorias Rechazadas
        </a>
    </div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('biblioteca.memorias-pendientes') }}" 
               class="text-gray-500 hover:text-gray-700 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Revisar Memoria de Estadía</h1>
                <p class="text-gray-600 mt-1">Valida o rechaza la memoria enviada por el estudiante</p>
            </div>
        </div>
        <div class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-medium">
            Pendiente de validación
        </div>
    </div>

    <!-- Información del Estudiante -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Información del Estudiante</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo</label>
                <p class="text-gray-900">{{ $documento->estudiante->user->name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Número de Control</label>
                <p class="text-gray-900">{{ $documento->estudiante->numero_control }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Carrera</label>
                <p class="text-gray-900">{{ $documento->estudiante->carrera->nombre ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                <p class="text-gray-900">{{ $documento->estudiante->user->email }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Empresa</label>
                <p class="text-gray-900">{{ $documento->estadia->empresa->nombre ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Período de Estadía</label>
                <p class="text-gray-900">
                    @if($documento->estadia)
                        {{ $documento->estadia->fecha_inicio ? $documento->estadia->fecha_inicio->format('d/m/Y') : 'N/A' }} - 
                        {{ $documento->estadia->fecha_fin ? $documento->estadia->fecha_fin->format('d/m/Y') : 'N/A' }}
                    @else
                        N/A
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Información del Documento -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Información del Documento</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del Archivo</label>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-gray-900">{{ $documento->nombre_archivo }}</p>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Subida</label>
                <p class="text-gray-900">{{ $documento->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tamaño del Archivo</label>
                <p class="text-gray-900">{{ number_format($documento->tamaño_archivo / 1024 / 1024, 2) }} MB</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Documento</label>
                <p class="text-gray-900">Memoria de Estadía</p>
            </div>
        </div>
        
        <!-- Botón de descarga -->
        <div class="mt-6">
            <a href="{{ route('biblioteca.descargar-memoria', $documento->id) }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-500 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Descargar Memoria
            </a>
        </div>
    </div>

    <!-- Acciones de Validación -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Validar Memoria -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center mb-4">
                <div class="p-2 bg-green-100 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Validar Memoria</h3>
            </div>
            <p class="text-gray-600 mb-4">La memoria cumple con todos los requisitos y puede ser aprobada.</p>
            
            <form action="{{ route('biblioteca.validar-memoria', $documento->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Comentarios (opcional)</label>
                    <textarea name="comentarios" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500"
                              placeholder="Agregar comentarios sobre la validación..."></textarea>
                </div>
                <button type="submit" 
                        class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-500 transition-colors"
                        onclick="return confirm('¿Estás seguro de que deseas validar esta memoria?')">
                    Validar Memoria
                </button>
            </form>
        </div>

        <!-- Rechazar Memoria -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center mb-4">
                <div class="p-2 bg-red-100 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Rechazar Memoria</h3>
            </div>
            <p class="text-gray-600 mb-4">La memoria no cumple con los requisitos y debe ser corregida.</p>
            
            <form action="{{ route('biblioteca.rechazar-memoria', $documento->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Motivo del rechazo *</label>
                    <textarea name="comentarios" rows="4" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"
                              placeholder="Especifica los motivos del rechazo y las correcciones necesarias..."></textarea>
                </div>
                <button type="submit" 
                        class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-500 transition-colors"
                        onclick="return confirm('¿Estás seguro de que deseas rechazar esta memoria?')">
                    Rechazar Memoria
                </button>
            </form>
        </div>
    </div>

    <!-- Historial de Comentarios (si existe) -->
    @if($documento->comentarios_validacion)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Historial de Comentarios</h2>
        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-gray-700">{{ $documento->comentarios_validacion }}</p>
            @if($documento->fecha_validacion)
            <p class="text-sm text-gray-500 mt-2">
                Comentario agregado el {{ $documento->fecha_validacion->format('d/m/Y H:i') }}
            </p>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection