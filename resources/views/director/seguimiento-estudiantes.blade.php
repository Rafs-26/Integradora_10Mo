@extends('layouts.director')

@section('title', 'Seguimiento de Estudiantes')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Seguimiento de Estudiante</h1>
                <p class="text-gray-600">Detalles y progreso del estudiante en su estadía</p>
            </div>
            <a href="{{ route('director.lista-estudiantes') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200 transition-colors">
                ← Volver a Lista
            </a>
        </div>
    </div>

    <!-- Información del Estudiante -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center mb-6">
                    <div class="flex-shrink-0 h-16 w-16">
                        <div class="h-16 w-16 rounded-full bg-uth-green flex items-center justify-center">
                            <span class="text-xl font-medium text-white">
                                {{ substr($estudiante->nombre, 0, 1) }}{{ substr($estudiante->apellido_paterno, 0, 1) }}
                            </span>
                        </div>
                    </div>
                    <div class="ml-6">
                        <h2 class="text-2xl font-bold text-gray-900">
                            {{ $estudiante->nombre }} {{ $estudiante->apellido_paterno }} {{ $estudiante->apellido_materno }}
                        </h2>
                        <p class="text-gray-600">{{ $estudiante->matricula }}</p>
                        <p class="text-sm text-gray-500">{{ $estudiante->carrera->nombre ?? 'Carrera no asignada' }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="text-gray-900">{{ $estudiante->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <p class="text-gray-900">{{ $estudiante->telefono ?? 'No registrado' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Estado</label>
                        @php
                            $estadoClasses = [
                                'activo' => 'bg-green-100 text-green-800',
                                'en_estadia' => 'bg-blue-100 text-blue-800',
                                'completado' => 'bg-gray-100 text-gray-800',
                                'suspendido' => 'bg-red-100 text-red-800'
                            ];
                        @endphp
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $estadoClasses[$estudiante->estado] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst(str_replace('_', ' ', $estudiante->estado)) }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Profesor Asignado</label>
                        <p class="text-gray-900">
                            {{ $estudiante->profesor->user->name ?? 'Sin asignar' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas Rápidas -->
        <div class="space-y-4">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Documentos Entregados</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['documentos_entregados'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Progreso</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['progreso'] }}%</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Días Restantes</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['dias_restantes'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información de la Estadía -->
    @if($estudiante->estadia)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Información de la Estadía</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Empresa</label>
                <p class="text-gray-900">{{ $estudiante->estadia->empresa->nombre ?? 'No asignada' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Fecha de Inicio</label>
                <p class="text-gray-900">{{ $estudiante->estadia->fecha_inicio ? $estudiante->estadia->fecha_inicio->format('d/m/Y') : 'No definida' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Fecha de Fin</label>
                <p class="text-gray-900">{{ $estudiante->estadia->fecha_fin ? $estudiante->estadia->fecha_fin->format('d/m/Y') : 'No definida' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Estado de la Estadía</label>
                @php
                    $estadiaClasses = [
                        'activa' => 'bg-green-100 text-green-800',
                        'pendiente' => 'bg-yellow-100 text-yellow-800',
                        'completada' => 'bg-blue-100 text-blue-800',
                        'cancelada' => 'bg-red-100 text-red-800'
                    ];
                @endphp
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $estadiaClasses[$estudiante->estadia->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst(str_replace('_', ' ', $estudiante->estadia->status)) }}
                                </span>
            </div>
        </div>
        @if($estudiante->estadia->observaciones)
        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700">Observaciones</label>
            <p class="text-gray-900 mt-1">{{ $estudiante->estadia->observaciones }}</p>
        </div>
        @endif
    </div>
    @endif

    <!-- Documentos y Evaluaciones -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Documentos -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Documentos</h3>
            </div>
            <div class="p-6">
                @forelse($documentos as $documento)
                    <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $documento->nombre }}</p>
                                <p class="text-xs text-gray-500">{{ $documento->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            @php
                                $statusClasses = [
                                    'pendiente' => 'bg-yellow-100 text-yellow-800',
                                    'aprobado' => 'bg-green-100 text-green-800',
                                    'rechazado' => 'bg-red-100 text-red-800'
                                ];
                            @endphp
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusClasses[$documento->estado] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($documento->estado) }}
                            </span>
                            <a href="{{ route('director.ver-documento', $documento->id) }}" class="text-uth-green hover:text-uth-green-dark text-sm">
                                Ver
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No hay documentos registrados</p>
                @endforelse
            </div>
        </div>

        <!-- Evaluaciones -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Evaluaciones</h3>
            </div>
            <div class="p-6">
                @forelse($evaluaciones as $evaluacion)
                    <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 8l2 2 4-4"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $evaluacion->tipo }}</p>
                                <p class="text-xs text-gray-500">{{ $evaluacion->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if($evaluacion->calificacion)
                                <span class="text-sm font-semibold text-gray-900">{{ $evaluacion->calificacion }}/10</span>
                            @endif
                            <a href="{{ route('director.ver-evaluacion', $evaluacion->id) }}" class="text-uth-green hover:text-uth-green-dark text-sm">
                                Ver
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No hay evaluaciones registradas</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Historial de Actividades -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mt-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Historial de Actividades</h3>
        </div>
        <div class="p-6">
            @forelse($actividades as $actividad)
                <div class="flex items-start space-x-3 pb-4 border-b border-gray-100 last:border-b-0 last:pb-0">
                    <div class="flex-shrink-0">
                        <div class="w-2 h-2 bg-uth-green rounded-full mt-2"></div>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-900">{{ $actividad->descripcion }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $actividad->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">No hay actividades registradas</p>
            @endforelse
        </div>
    </div>
</div>
@endsection