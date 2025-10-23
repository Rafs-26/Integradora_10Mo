@extends('layouts.app')

@section('title', 'Estadísticas de Validación - Sistema de Estadías UTH')
@section('page-title', 'Estadísticas de Validación')

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
        <a href="{{ route('biblioteca.memorias-pendientes') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1">
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
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Estadísticas de Validación</h1>
            <p class="text-gray-600 mt-1">Análisis detallado del proceso de validación de memorias</p>
        </div>
        <div class="flex items-center space-x-2">
            <button onclick="window.print()" class="bg-uth-green text-white px-4 py-2 rounded-lg hover:bg-uth-green/90 transition-colors">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Imprimir Reporte
            </button>
        </div>
    </div>

    <!-- Filtros de Período -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="GET" action="{{ route('biblioteca.estadisticas') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Inicio</label>
                <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio', now()->subMonth()->format('Y-m-d')) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-uth-green focus:border-uth-green">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Fin</label>
                <input type="date" name="fecha_fin" value="{{ request('fecha_fin', now()->format('Y-m-d')) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-uth-green focus:border-uth-green">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Carrera</label>
                <select name="carrera" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-uth-green focus:border-uth-green">
                    <option value="">Todas las carreras</option>
                    @foreach($carreras as $carrera)
                        <option value="{{ $carrera->id }}" {{ request('carrera') == $carrera->id ? 'selected' : '' }}>
                            {{ $carrera->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-uth-green text-white px-4 py-2 rounded-lg hover:bg-uth-green/90 transition-colors">
                    Generar Estadísticas
                </button>
            </div>
        </form>
    </div>

    <!-- Resumen General -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Memorias</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $estadisticas['total'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Validadas</p>
                    <p class="text-2xl font-bold text-green-600">{{ $estadisticas['validadas'] }}</p>
                    <p class="text-xs text-gray-500">{{ $estadisticas['total'] > 0 ? round(($estadisticas['validadas'] / $estadisticas['total']) * 100, 1) : 0 }}%</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-lg">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Rechazadas</p>
                    <p class="text-2xl font-bold text-red-600">{{ $estadisticas['rechazadas'] }}</p>
                    <p class="text-xs text-gray-500">{{ $estadisticas['total'] > 0 ? round(($estadisticas['rechazadas'] / $estadisticas['total']) * 100, 1) : 0 }}%</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-orange-100 rounded-lg">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pendientes</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $estadisticas['pendientes'] }}</p>
                    <p class="text-xs text-gray-500">{{ $estadisticas['total'] > 0 ? round(($estadisticas['pendientes'] / $estadisticas['total']) * 100, 1) : 0 }}%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico de Tendencias -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Tendencia de Validaciones por Mes</h2>
        <div class="h-64 flex items-end justify-between space-x-2">
            @foreach($tendenciaMensual as $mes => $datos)
            <div class="flex-1 flex flex-col items-center">
                <div class="w-full bg-gray-100 rounded-t" style="height: 200px; position: relative;">
                    @if($datos['total'] > 0)
                        <div class="absolute bottom-0 w-full bg-green-500 rounded-t" 
                             style="height: {{ ($datos['validadas'] / max(array_column($tendenciaMensual, 'total'))) * 100 }}%;"></div>
                        <div class="absolute bottom-0 w-full bg-red-500 rounded-t" 
                             style="height: {{ (($datos['validadas'] + $datos['rechazadas']) / max(array_column($tendenciaMensual, 'total'))) * 100 }}%; opacity: 0.7;"></div>
                    @endif
                </div>
                <div class="mt-2 text-center">
                    <p class="text-xs font-medium text-gray-900">{{ $mes }}</p>
                    <p class="text-xs text-gray-500">{{ $datos['total'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-4 flex justify-center space-x-6">
            <div class="flex items-center">
                <div class="w-3 h-3 bg-green-500 rounded mr-2"></div>
                <span class="text-sm text-gray-600">Validadas</span>
            </div>
            <div class="flex items-center">
                <div class="w-3 h-3 bg-red-500 rounded mr-2"></div>
                <span class="text-sm text-gray-600">Rechazadas</span>
            </div>
        </div>
    </div>

    <!-- Estadísticas por Carrera -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Estadísticas por Carrera</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Carrera</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Validadas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rechazadas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pendientes</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">% Aprobación</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($estadisticasPorCarrera as $carrera => $datos)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $carrera }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $datos['total'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-medium">{{ $datos['validadas'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 font-medium">{{ $datos['rechazadas'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-orange-600 font-medium">{{ $datos['pendientes'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if($datos['total'] > 0)
                                {{ round(($datos['validadas'] / ($datos['validadas'] + $datos['rechazadas'])) * 100, 1) }}%
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tiempo Promedio de Validación -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Tiempo Promedio de Validación</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Memorias Validadas</span>
                    <span class="text-lg font-bold text-green-600">{{ $tiempoPromedio['validadas'] }} días</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Memorias Rechazadas</span>
                    <span class="text-lg font-bold text-red-600">{{ $tiempoPromedio['rechazadas'] }} días</span>
                </div>
                <div class="flex justify-between items-center border-t pt-4">
                    <span class="text-sm font-medium text-gray-900">Promedio General</span>
                    <span class="text-xl font-bold text-uth-green">{{ $tiempoPromedio['general'] }} días</span>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Motivos de Rechazo Más Comunes</h2>
            <div class="space-y-3">
                @foreach($motivosRechazo as $motivo)
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm text-gray-900 truncate">{{ Str::limit($motivo['motivo'], 40) }}</p>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                            <div class="bg-red-500 h-2 rounded-full" style="width: {{ ($motivo['count'] / $motivosRechazo->first()['count']) * 100 }}%"></div>
                        </div>
                    </div>
                    <span class="ml-3 text-sm font-medium text-gray-900">{{ $motivo['count'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection