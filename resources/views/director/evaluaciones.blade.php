@extends('layouts.director')

@section('title', 'Evaluaciones')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Evaluaciones</h1>
        <p class="text-gray-600 mt-2">Gestiona las evaluaciones de los estudiantes en estadías</p>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Evaluaciones</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $evaluaciones->total() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Aprobadas</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $evaluaciones->where('calificacion', '>=', 70)->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Promedio</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $evaluaciones->count() > 0 ? round($evaluaciones->avg('calificacion'), 1) : 0 }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Este Mes</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $evaluaciones->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar estudiante</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green"
                           placeholder="Nombre o matrícula...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Evaluador</label>
                    <input type="text" name="evaluador" value="{{ request('evaluador') }}" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green"
                           placeholder="Nombre del profesor...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Calificación mínima</label>
                    <select name="calificacion" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green">
                        <option value="">Todas</option>
                        <option value="90" {{ request('calificacion') == '90' ? 'selected' : '' }}>90+</option>
                        <option value="80" {{ request('calificacion') == '80' ? 'selected' : '' }}>80+</option>
                        <option value="70" {{ request('calificacion') == '70' ? 'selected' : '' }}>70+</option>
                        <option value="60" {{ request('calificacion') == '60' ? 'selected' : '' }}>60+</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-uth-green text-white px-4 py-2 rounded-md hover:bg-uth-green/90 mr-2">
                        Filtrar
                    </button>
                    <a href="{{ route('director.evaluaciones') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de evaluaciones -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            @if($evaluaciones->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Evaluador</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Calificación</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($evaluaciones as $evaluacion)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-uth-green/10 flex items-center justify-center">
                                                <span class="text-sm font-medium text-uth-green">
                                                    {{ substr($evaluacion->estudiante_nombre, 0, 2) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $evaluacion->estudiante_nombre }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $evaluacion->profesor_nombre }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-lg font-semibold 
                                            {{ $evaluacion->calificacion >= 90 ? 'text-green-600' : 
                                               ($evaluacion->calificacion >= 80 ? 'text-blue-600' : 
                                               ($evaluacion->calificacion >= 70 ? 'text-yellow-600' : 'text-red-600')) }}">
                                            {{ $evaluacion->calificacion }}
                                        </span>
                                        <span class="text-sm text-gray-500 ml-1">/100</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($evaluacion->created_at)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $evaluacion->calificacion >= 70 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $evaluacion->calificacion >= 70 ? 'Aprobada' : 'Reprobada' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button class="text-uth-green hover:text-uth-green/80 mr-3">
                                        Ver detalles
                                    </button>
                                    <button class="text-blue-600 hover:text-blue-900">
                                        Descargar
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="mt-6">
                    {{ $evaluaciones->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay evaluaciones</h3>
                    <p class="mt-1 text-sm text-gray-500">No se encontraron evaluaciones con los filtros aplicados.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection