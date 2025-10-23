@extends('layouts.app')

@section('title', 'Documentos Revisados - Dashboard Profesor')
@section('page-title', 'Documentos Revisados')

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
        <a href="{{ route('teacher.seguimiento') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1">
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
        <a href="{{ route('teacher.documentos-revisados') }}" class="flex items-center px-4 py-3 text-uth-green bg-uth-green/10 rounded-lg mb-1">
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
        <a href="{{ route('teacher.seguimiento') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1">
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
        <a href="{{ route('teacher.documentos-revisados') }}" class="flex items-center px-4 py-3 text-uth-green bg-uth-green/10 rounded-lg mb-1">
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
                    <h1 class="text-3xl font-bold text-gray-900">Documentos Revisados</h1>
                    <p class="mt-1 text-sm text-gray-600">Historial de documentos aprobados y rechazados</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-1"></span>
                            {{ $documentos->where('estado', 'aprobado')->count() }} Aprobados
                        </span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            <span class="w-2 h-2 bg-red-400 rounded-full mr-1"></span>
                            {{ $documentos->where('estado', 'rechazado')->count() }} Rechazados
                        </span>
                    </div>
                    <a href="{{ route('teacher.documentos-por-revisar') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-uth-green hover:bg-uth-green-dark">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V9a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Documentos Pendientes
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Estadísticas Rápidas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Revisados</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $documentos->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Aprobados</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $documentos->where('estado', 'aprobado')->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Rechazados</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $documentos->where('estado', 'rechazado')->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Tasa Aprobación</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    @if($documentos->count() > 0)
                                        {{ round(($documentos->where('estado', 'aprobado')->count() / $documentos->count()) * 100, 1) }}%
                                    @else
                                        0%
                                    @endif
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="px-6 py-4">
                <form method="GET" class="flex flex-wrap items-center gap-4">
                    <div class="flex-1 min-w-64">
                        <label for="search" class="sr-only">Buscar documentos</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-uth-green focus:border-uth-green"
                                   placeholder="Buscar por título, estudiante o tipo...">
                        </div>
                    </div>
                    
                    <div>
                        <select name="estado" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green">
                            <option value="">Todos los estados</option>
                            <option value="aprobado" {{ request('estado') == 'aprobado' ? 'selected' : '' }}>Aprobados</option>
                            <option value="rechazado" {{ request('estado') == 'rechazado' ? 'selected' : '' }}>Rechazados</option>
                        </select>
                    </div>
                    
                    <div>
                        <select name="tipo" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green">
                            <option value="">Todos los tipos</option>
                            <option value="carta_presentacion" {{ request('tipo') == 'carta_presentacion' ? 'selected' : '' }}>Carta de Presentación</option>
                            <option value="plan_trabajo" {{ request('tipo') == 'plan_trabajo' ? 'selected' : '' }}>Plan de Trabajo</option>
                            <option value="reporte_parcial" {{ request('tipo') == 'reporte_parcial' ? 'selected' : '' }}>Reporte Parcial</option>
                            <option value="reporte_final" {{ request('tipo') == 'reporte_final' ? 'selected' : '' }}>Reporte Final</option>
                        </select>
                    </div>
                    
                    <div>
                        <select name="estudiante" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green">
                            <option value="">Todos los estudiantes</option>
                            @foreach($estudiantes as $estudiante)
                                <option value="{{ $estudiante->id }}" {{ request('estudiante') == $estudiante->id ? 'selected' : '' }}>
                                    {{ $estudiante->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green"
                               placeholder="Desde">
                    </div>
                    
                    <div>
                        <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green"
                               placeholder="Hasta">
                    </div>
                    
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-uth-green hover:bg-uth-green-dark">
                        Filtrar
                    </button>
                    
                    @if(request()->hasAny(['search', 'estado', 'tipo', 'estudiante', 'fecha_desde', 'fecha_hasta']))
                        <a href="{{ route('teacher.documentos-revisados') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Limpiar
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Lista de Documentos -->
        <div class="space-y-4">
            @forelse($documentos as $documento)
                <div class="bg-white rounded-lg shadow hover:shadow-md transition-shadow duration-200">
                    <div class="px-6 py-4">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $documento->titulo }}</h3>
                                    
                                    <!-- Badge de Estado -->
                                    @if($documento->estado == 'aprobado')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            Aprobado
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                            Rechazado
                                        </span>
                                    @endif
                                    
                                    <!-- Badge de Tipo -->
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ ucfirst(str_replace('_', ' ', $documento->tipo)) }}
                                    </span>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm text-gray-600 mb-3">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <strong>Estudiante:</strong> {{ $documento->estudiante->name }}
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 8a2 2 0 100-4 2 2 0 000 4zm0 0v4m0-10V7"></path>
                                        </svg>
                                        <strong>Subido:</strong> {{ $documento->created_at->format('d/m/Y') }}
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <strong>Revisado:</strong> {{ $documento->fecha_revision ? $documento->fecha_revision->format('d/m/Y') : 'N/A' }}
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <strong>Tiempo revisión:</strong> 
                                        @if($documento->fecha_revision)
                                            {{ $documento->created_at->diffInDays($documento->fecha_revision) }} días
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                </div>
                                
                                @if($documento->descripcion)
                                    <p class="text-gray-700 mb-3">{{ Str::limit($documento->descripcion, 150) }}</p>
                                @endif
                                
                                @if($documento->comentarios_profesor)
                                    <div class="{{ $documento->estado == 'aprobado' ? 'bg-green-50 border-l-4 border-green-400' : 'bg-red-50 border-l-4 border-red-400' }} p-3 mb-3">
                                        <p class="text-sm {{ $documento->estado == 'aprobado' ? 'text-green-700' : 'text-red-700' }}">
                                            <strong>Comentarios del profesor:</strong> {{ $documento->comentarios_profesor }}
                                        </p>
                                    </div>
                                @endif
                                
                                @if($documento->comentarios_estudiante)
                                    <div class="bg-blue-50 border-l-4 border-blue-400 p-3 mb-3">
                                        <p class="text-sm text-blue-700">
                                            <strong>Comentarios del estudiante:</strong> {{ $documento->comentarios_estudiante }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex flex-col space-y-2 ml-4">
                                <!-- Botón Ver/Descargar -->
                                <a href="{{ route('teacher.documentos.ver', $documento->id) }}" target="_blank"
                                   class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Ver
                                </a>
                                
                                @if($documento->estado == 'rechazado')
                                    <!-- Botón Reconsiderar -->
                                    <button onclick="reconsiderarDocumento({{ $documento->id }})" 
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        Reconsiderar
                                    </button>
                                @endif
                                
                                <!-- Botón Historial -->
                                <button onclick="verHistorial({{ $documento->id }})" 
                                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Historial
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay documentos revisados</h3>
                    <p class="mt-1 text-sm text-gray-500">Aún no has revisado ningún documento.</p>
                </div>
            @endforelse
        </div>
        
        <!-- Paginación -->
        @if($documentos->hasPages())
            <div class="mt-8">
                {{ $documentos->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal para Reconsiderar Documento -->
<div id="modal-reconsiderar" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-center mx-auto w-12 h-12 rounded-full bg-yellow-100">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 text-center mt-4">Reconsiderar Documento</h3>
            <form id="form-reconsiderar" method="POST">
                @csrf
                @method('PATCH')
                <div class="mt-4">
                    <label for="accion" class="block text-sm font-medium text-gray-700 mb-2">Nueva decisión *</label>
                    <select name="accion" id="accion" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green">
                        <option value="">Seleccionar acción</option>
                        <option value="aprobar">Aprobar</option>
                        <option value="pendiente">Marcar como pendiente</option>
                    </select>
                </div>
                <div class="mt-4">
                    <label for="comentarios-reconsideracion" class="block text-sm font-medium text-gray-700 mb-2">Comentarios</label>
                    <textarea name="comentarios" id="comentarios-reconsideracion" rows="3" 
                              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green"
                              placeholder="Explica el motivo de la reconsideración..."></textarea>
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="cerrarModal('modal-reconsiderar')" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700">
                        Reconsiderar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Ver Historial -->
<div id="modal-historial" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-10 mx-auto p-5 border w-2/3 max-w-4xl shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Historial del Documento</h3>
                <button onclick="cerrarModal('modal-historial')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="historial-content" class="space-y-4 max-h-96 overflow-y-auto">
                <!-- El contenido se cargará dinámicamente -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function reconsiderarDocumento(documentoId) {
        const modal = document.getElementById('modal-reconsiderar');
        const form = document.getElementById('form-reconsiderar');
        form.action = `/teacher/documentos/${documentoId}/reconsiderar`;
        modal.classList.remove('hidden');
    }
    
    function verHistorial(documentoId) {
        const modal = document.getElementById('modal-historial');
        const content = document.getElementById('historial-content');
        
        // Mostrar loading
        content.innerHTML = '<div class="text-center py-4"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-uth-green mx-auto"></div></div>';
        modal.classList.remove('hidden');
        
        // Cargar historial (simulado)
        setTimeout(() => {
            content.innerHTML = `
                <div class="border-l-4 border-blue-400 pl-4">
                    <div class="flex items-center space-x-2 mb-2">
                        <div class="w-3 h-3 bg-blue-400 rounded-full"></div>
                        <span class="text-sm font-medium text-gray-900">Documento subido</span>
                        <span class="text-xs text-gray-500">hace 5 días</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-4">El estudiante subió el documento inicial.</p>
                </div>
                <div class="border-l-4 border-red-400 pl-4">
                    <div class="flex items-center space-x-2 mb-2">
                        <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                        <span class="text-sm font-medium text-gray-900">Documento rechazado</span>
                        <span class="text-xs text-gray-500">hace 2 días</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-4">Rechazado por falta de información en la sección de objetivos.</p>
                </div>
                <div class="border-l-4 border-yellow-400 pl-4">
                    <div class="flex items-center space-x-2 mb-2">
                        <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                        <span class="text-sm font-medium text-gray-900">En reconsideración</span>
                        <span class="text-xs text-gray-500">ahora</span>
                    </div>
                    <p class="text-sm text-gray-600">El documento está siendo reconsiderado.</p>
                </div>
            `;
        }, 1000);
    }
    
    function cerrarModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
    
    // Cerrar modal al hacer clic fuera
    window.onclick = function(event) {
        const modalReconsiderar = document.getElementById('modal-reconsiderar');
        const modalHistorial = document.getElementById('modal-historial');
        
        if (event.target === modalReconsiderar) {
            modalReconsiderar.classList.add('hidden');
        }
        if (event.target === modalHistorial) {
            modalHistorial.classList.add('hidden');
        }
    }
    
    console.log('Vista Documentos Revisados cargada');
</script>
@endpush