@extends('layouts.app')

@section('title', 'Mi Estadía - Sistema de Estadías UTH')
@section('page-title', 'Mi Estadía')

@section('sidebar-menu')
    <!-- Inicio -->
    <a href="{{ route('student.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-2">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
        </svg>
        Inicio
    </a>
    
    <!-- Mi Estadía -->
    <div class="mb-4">
        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Mi Estadía</h3>
        <a href="{{ route('student.mi-estadia') }}" class="flex items-center px-4 py-3 text-uth-green bg-uth-green/10 rounded-lg mb-1">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            Estado Actual
        </a>
        <a href="{{ route('student.documentos') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1 ml-4">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Documentos
        </a>
    </div>
    
    <!-- Solicitar Carta de Presentación -->
    <a href="{{ route('student.carta-presentacion') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-2">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        Solicitar Carta de Presentación
    </a>
    
    <!-- Formatos Disponibles -->
    <a href="{{ route('student.formatos-disponibles') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-2">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        Formatos Disponibles
    </a>
    
    <!-- Empresas -->
    <a href="{{ route('student.empresas-catalogo') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-2">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
        </svg>
        Empresas
    </a>
    


@endsection

@section('content')
<div class="p-6">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if($estadia)
        <!-- Información de la Estadía -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Información de mi Estadía</h2>
                <p class="text-gray-600">Detalles de tu estadía profesional actual</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Datos Generales</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Empresa</label>
                                <p class="text-sm text-gray-900">{{ $estadia->empresa->nombre ?? 'No asignada' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Proyecto</label>
                                <p class="text-sm text-gray-900">{{ $estadia->proyecto ?? 'No especificado' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Área</label>
                                <p class="text-sm text-gray-900">{{ $estadia->area ?? 'No especificada' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Estado</label>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($estadia->estado == 'activa') bg-green-100 text-green-800
                                    @elseif($estadia->estado == 'completada') bg-blue-100 text-blue-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst($estadia->estado) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Fechas y Progreso</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Fecha de Inicio</label>
                                <p class="text-sm text-gray-900">{{ $estadia->fecha_inicio ? \Carbon\Carbon::parse($estadia->fecha_inicio)->format('d/m/Y') : 'No definida' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Fecha de Fin</label>
                                <p class="text-sm text-gray-900">{{ $estadia->fecha_fin ? \Carbon\Carbon::parse($estadia->fecha_fin)->format('d/m/Y') : 'No definida' }}</p>
                            </div>
                            @if($estadia->fecha_inicio && $estadia->fecha_fin)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Progreso</label>
                                @php
                                    $fechaInicio = \Carbon\Carbon::parse($estadia->fecha_inicio);
                                    $fechaFin = \Carbon\Carbon::parse($estadia->fecha_fin);
                                    $fechaActual = \Carbon\Carbon::now();
                                    
                                    if ($fechaActual->lt($fechaInicio)) {
                                        $progreso = 0;
                                    } elseif ($fechaActual->gt($fechaFin)) {
                                        $progreso = 100;
                                    } else {
                                        $totalDias = $fechaInicio->diffInDays($fechaFin);
                                        $diasTranscurridos = $fechaInicio->diffInDays($fechaActual);
                                        $progreso = $totalDias > 0 ? round(($diasTranscurridos / $totalDias) * 100, 1) : 0;
                                    }
                                @endphp
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-uth-green h-2.5 rounded-full transition-all duration-300" style="width: {{ $progreso }}%"></div>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">{{ $progreso }}% completado</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Supervisor y Contacto -->
        @if($estadia->profesorSupervisor)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Supervisor Académico</h2>
                <p class="text-gray-600">Información de contacto de tu supervisor</p>
            </div>
            <div class="p-6">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-uth-green rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold text-lg">
                            {{ substr($estadia->profesorSupervisor->user->name ?? 'P', 0, 1) }}
                        </span>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">{{ $estadia->profesorSupervisor->user->name ?? 'No asignado' }}</h3>
                            <p class="text-sm text-gray-600">{{ $estadia->profesorSupervisor->user->email ?? '' }}</p>
                            @if($estadia->profesorSupervisor->telefono)
                                <p class="text-sm text-gray-600">Tel: {{ $estadia->profesorSupervisor->telefono }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Tareas Pendientes -->
        @if(count($tareasPendientes) > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Tareas Pendientes</h2>
                <p class="text-gray-600">Acciones que requieren tu atención</p>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    @foreach($tareasPendientes as $tarea)
                    <div class="flex items-center justify-between p-3 rounded-lg border
                        @if($tarea['prioridad'] == 'alta') border-red-200 bg-red-50
                        @elseif($tarea['prioridad'] == 'media') border-yellow-200 bg-yellow-50
                        @else border-blue-200 bg-blue-50 @endif">
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 rounded-full
                                @if($tarea['prioridad'] == 'alta') bg-red-500
                                @elseif($tarea['prioridad'] == 'media') bg-yellow-500
                                @else bg-blue-500 @endif"></div>
                            <p class="text-sm font-medium text-gray-900">{{ $tarea['descripcion'] }}</p>
                        </div>
                        <a href="{{ $tarea['enlace'] }}" class="text-sm text-uth-green hover:text-uth-green/80 font-medium">
                            Ver →
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Próximas Citas -->
        @if(count($proximasCitas) > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Próximas Citas</h2>
                <p class="text-gray-600">Tus citas programadas</p>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($proximasCitas as $cita)
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-uth-green/10 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-uth-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-8 0v10a2 2 0 002 2h4a2 2 0 002-2V7m-8 0V6a2 2 0 012-2h4a2 2 0 012 2v1"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-900">{{ $cita->titulo }}</h3>
                                <p class="text-xs text-gray-600">{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }} a las {{ $cita->hora_inicio }}</p>
                                @if($cita->tutor && $cita->tutor->user)
                                <p class="text-xs text-gray-500">Con: {{ $cita->tutor->user->name }}</p>
                                @endif
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ ucfirst($cita->modalidad) }}
                        </span>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('student.citas') }}" class="text-sm text-uth-green hover:text-uth-green/80 font-medium">
                        Ver todas las citas →
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Documentos Pendientes -->
        @if(count($documentosPendientes) > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Documentos Requeridos</h2>
                <p class="text-gray-600">Documentos que necesitas subir o actualizar</p>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    @foreach($documentosPendientes as $doc)
                    <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $doc['nombre'] }}</p>
                                @if($doc['fecha_limite'])
                                <p class="text-xs text-gray-500">
                                    Fecha límite: {{ \Carbon\Carbon::parse($doc['fecha_limite'])->format('d/m/Y') }}
                                    @if(\Carbon\Carbon::parse($doc['fecha_limite'])->isPast())
                                        <span class="text-red-600 font-medium">(Vencido)</span>
                                    @endif
                                </p>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($doc['estado'] == 'no_subido') bg-gray-100 text-gray-800
                                @elseif($doc['estado'] == 'pendiente') bg-yellow-100 text-yellow-800
                                @elseif($doc['estado'] == 'rechazado') bg-red-100 text-red-800
                                @endif">
                                @if($doc['estado'] == 'no_subido') No subido
                                @elseif($doc['estado'] == 'pendiente') Pendiente
                                @elseif($doc['estado'] == 'rechazado') Rechazado
                                @endif
                            </span>
                            <a href="{{ route('student.documentos') }}" class="text-sm text-uth-green hover:text-uth-green/80 font-medium">
                                Subir
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Actividades Recientes -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Actividades Recientes</h2>
                <p class="text-gray-600">Últimas actividades relacionadas con tu estadía</p>
            </div>
            <div class="p-6">
                @if(count($actividadesRecientes) > 0)
                <div class="space-y-4">
                    @foreach($actividadesRecientes as $actividad)
                    <div class="flex items-start space-x-3">
                        <div class="w-2 h-2 rounded-full mt-2
                            @if($actividad['tipo'] == 'documento') bg-blue-500
                            @elseif($actividad['tipo'] == 'cita') bg-green-500
                            @else bg-gray-500 @endif"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $actividad['descripcion'] }}</p>
                            <p class="text-xs text-gray-500">{{ $actividad['fecha']->format('d/m/Y H:i') }}</p>
                            @if(isset($actividad['estado']))
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium mt-1
                                @if($actividad['estado'] == 'validado' || $actividad['estado'] == 'completada') bg-green-100 text-green-800
                                @elseif($actividad['estado'] == 'pendiente' || $actividad['estado'] == 'programada') bg-yellow-100 text-yellow-800
                                @elseif($actividad['estado'] == 'rechazado' || $actividad['estado'] == 'cancelada') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($actividad['estado']) }}
                            </span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <p class="text-gray-500">No hay actividades recientes</p>
                </div>
                @endif
            </div>
        </div>
    @else
        <!-- No hay estadía asignada -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No tienes una estadía asignada</h3>
                <p class="text-gray-600 mb-6">Aún no se te ha asignado una estadía profesional. Contacta con tu coordinador académico para más información.</p>
                <a href="{{ route('student.empresas') }}" class="inline-flex items-center px-4 py-2 bg-uth-green text-white text-sm font-medium rounded-lg hover:bg-uth-green/90 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Ver Empresas Disponibles
                </a>
            </div>
        </div>
    @endif
</div>
@endsection