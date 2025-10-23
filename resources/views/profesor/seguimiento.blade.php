@extends('layouts.app')

@section('title', 'Seguimiento de Estadías - Dashboard Profesor')
@section('page-title', 'Seguimiento de Estadías')

@section('sidebar-menu')
    <!-- Dashboard -->
    <a href="{{ route('teacher.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-2">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
        </svg>
        Inicio
    </a>
    
    <!-- Supervisión -->
    <div class="mb-4">
        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Supervisión</h3>
        <a href="{{ route('teacher.mis-estudiantes') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            Mis Estudiantes
        </a>
        <a href="{{ route('teacher.solicitudes-cartas') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Solicitudes de Cartas
        </a>
        <a href="{{ route('teacher.seguimiento') }}" class="flex items-center px-4 py-3 text-uth-green bg-uth-green/10 rounded-lg mb-1">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            Seguimiento
        </a>
        <a href="{{ route('teacher.evaluaciones') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-8 0v10a2 2 0 002 2h4a2 2 0 002-2V7m-8 0V6a2 2 0 012-2h4a2 2 0 012 2v1"></path>
            </svg>
            Evaluaciones
        </a>
    </div>
    
    <!-- Documentos -->
    <div class="mb-4">
        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Documentos</h3>
        <a href="{{ route('teacher.documentos-por-revisar') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Por Revisar
        </a>
        <a href="{{ route('teacher.documentos-revisados') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8l6 6 10-10"></path>
            </svg>
            Revisados
        </a>
        <a href="{{ route('teacher.formatos') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Formatos
        </a>
    </div>
            Por Revisar
        </a>
        <a href="{{ route('teacher.documentos-revisados') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8l6 6 10-10"></path>
            </svg>
            Revisados
        </a>
        <a href="{{ route('teacher.formatos') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Formatos
        </a>
    </div>
    

@endsection

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Seguimiento de Estadías</h1>
                    <p class="mt-1 text-sm text-gray-600">Monitorea el progreso y evaluaciones de tus estudiantes</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('teacher.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver al Inicio
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filtros -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-6 py-4">
                <form method="GET" class="flex flex-wrap items-center gap-4">
                    <div class="flex-1 min-w-64">
                        <label for="estudiante" class="block text-sm font-medium text-gray-700 mb-1">Estudiante</label>
                        <select name="estudiante" id="estudiante" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green">
                            <option value="">Todos los estudiantes</option>
                            @foreach($estudiantes as $est)
                                <option value="{{ $est->id }}" {{ request('estudiante') == $est->id ? 'selected' : '' }}>
                                    {{ $est->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1 min-w-48">
                        <label for="estatus" class="block text-sm font-medium text-gray-700 mb-1">Estatus</label>
                        <select name="estatus" id="estatus" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green">
                            <option value="">Todos los estatus</option>
                            <option value="pendiente" {{ request('estatus') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="en_progreso" {{ request('estatus') == 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                            <option value="completada" {{ request('estatus') == 'completada' ? 'selected' : '' }}>Completada</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-uth-green hover:bg-uth-green-dark">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tarjetas de Seguimiento -->
        @if($estudiantes->count() > 0)
            <div class="space-y-6">
                @foreach($estudiantes as $estudiante)
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <!-- Header del Estudiante -->
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 rounded-full bg-uth-green flex items-center justify-center">
                                        <span class="text-white font-medium text-lg">
                                            {{ strtoupper(substr($estudiante->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-medium text-gray-900">{{ $estudiante->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $estudiante->email }}</p>
                                        @if($estudiante->empresa)
                                            <p class="text-sm text-gray-500">{{ $estudiante->empresa->nombre }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">Progreso General</p>
                                        <p class="text-2xl font-bold text-uth-green">{{ $estudiante->progreso_estadia ?? 0 }}%</p>
                                    </div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        @if($estudiante->estatus_estadia == 'en_progreso') bg-green-100 text-green-800
                                        @elseif($estudiante->estatus_estadia == 'pendiente') bg-yellow-100 text-yellow-800
                                        @elseif($estudiante->estatus_estadia == 'completada') bg-blue-100 text-blue-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst(str_replace('_', ' ', $estudiante->estatus_estadia ?? 'Sin asignar')) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Contenido del Seguimiento -->
                        <div class="px-6 py-4">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Información de la Estadía -->
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900 mb-3">Información de la Estadía</h4>
                                    <dl class="space-y-2">
                                        <div class="flex justify-between">
                                            <dt class="text-sm text-gray-600">Fecha de Inicio:</dt>
                                            <dd class="text-sm font-medium text-gray-900">
                                                {{ $estudiante->fecha_inicio_estadia ? $estudiante->fecha_inicio_estadia->format('d/m/Y') : 'No asignada' }}
                                            </dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="text-sm text-gray-600">Fecha de Fin:</dt>
                                            <dd class="text-sm font-medium text-gray-900">
                                                {{ $estudiante->fecha_fin_estadia ? $estudiante->fecha_fin_estadia->format('d/m/Y') : 'No asignada' }}
                                            </dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="text-sm text-gray-600">Duración:</dt>
                                            <dd class="text-sm font-medium text-gray-900">
                                                @if($estudiante->fecha_inicio_estadia && $estudiante->fecha_fin_estadia)
                                                    {{ $estudiante->fecha_inicio_estadia->diffInDays($estudiante->fecha_fin_estadia) }} días
                                                @else
                                                    No definida
                                                @endif
                                            </dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="text-sm text-gray-600">Modalidad:</dt>
                                            <dd class="text-sm font-medium text-gray-900">
                                                {{ $estudiante->modalidad_estadia ?? 'No definida' }}
                                            </dd>
                                        </div>
                                    </dl>
                                </div>

                                <!-- Evaluaciones Recientes -->
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900 mb-3">Evaluaciones Recientes</h4>
                                    @if($estudiante->evaluaciones && $estudiante->evaluaciones->count() > 0)
                                        <div class="space-y-2">
                                            @foreach($estudiante->evaluaciones->take(3) as $evaluacion)
                                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">{{ $evaluacion->titulo }}</p>
                                                        <p class="text-xs text-gray-600">{{ $evaluacion->created_at->format('d/m/Y') }}</p>
                                                    </div>
                                                    <div class="text-right">
                                                        <span class="text-sm font-bold text-uth-green">{{ $evaluacion->calificacion }}/10</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-500 italic">No hay evaluaciones registradas</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Barra de Progreso Detallada -->
                            <div class="mt-6">
                                <div class="flex justify-between items-center mb-2">
                                    <h4 class="text-sm font-medium text-gray-900">Progreso de la Estadía</h4>
                                    <span class="text-sm text-gray-600">{{ $estudiante->progreso_estadia ?? 0 }}% completado</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r from-uth-green to-green-600 h-3 rounded-full transition-all duration-300" 
                                         style="width: {{ $estudiante->progreso_estadia ?? 0 }}%"></div>
                                </div>
                            </div>

                            <!-- Acciones -->
                            <div class="mt-6 flex flex-wrap gap-3">
                                <a href="{{ route('teacher.evaluaciones.crear') }}?estudiante={{ $estudiante->id }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-uth-green hover:bg-uth-green-dark">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Nueva Evaluación
                                </a>
                                <a href="{{ route('teacher.mensajes') }}?estudiante={{ $estudiante->id }}" 
                                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    Enviar Mensaje
                                </a>
                                <a href="{{ route('teacher.programar-citas') }}?estudiante={{ $estudiante->id }}" 
                                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-8 0v10a2 2 0 002 2h4a2 2 0 002-2V7m-8 0V6a2 2 0 012-2h4a2 2 0 012 2v1"></path>
                                    </svg>
                                    Programar Cita
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No hay estudiantes para seguimiento</h3>
                <p class="mt-1 text-sm text-gray-500">No se encontraron estudiantes con los filtros aplicados.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Scripts específicos para el seguimiento
    console.log('Vista Seguimiento cargada');
</script>
@endpush