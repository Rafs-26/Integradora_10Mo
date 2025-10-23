@extends('layouts.director')

@section('title', 'Documentos Aprobados')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Documentos Aprobados</h1>
        <p class="text-gray-600 mt-2">Historial de documentos aprobados en el sistema de estadías</p>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Aprobados</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $documentos->total() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Este Mes</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $documentos->where('updated_at', '>=', now()->startOfMonth())->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Estudiantes</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $documentos->unique('estudiante_id')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Empresas</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $documentos->unique('estadia.empresa_id')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar documento</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green"
                           placeholder="Nombre del archivo...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estudiante</label>
                    <input type="text" name="estudiante" value="{{ request('estudiante') }}" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green"
                           placeholder="Nombre o matrícula...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de documento</label>
                    <select name="tipo" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green">
                        <option value="">Todos los tipos</option>
                        <option value="carta_presentacion" {{ request('tipo') == 'carta_presentacion' ? 'selected' : '' }}>Carta de Presentación</option>
                        <option value="plan_trabajo" {{ request('tipo') == 'plan_trabajo' ? 'selected' : '' }}>Plan de Trabajo</option>
                        <option value="reporte_parcial" {{ request('tipo') == 'reporte_parcial' ? 'selected' : '' }}>Reporte Parcial</option>
                        <option value="reporte_final" {{ request('tipo') == 'reporte_final' ? 'selected' : '' }}>Reporte Final</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-uth-green text-white px-4 py-2 rounded-md hover:bg-uth-green/90 mr-2">
                        Filtrar
                    </button>
                    <a href="{{ route('director.documentos-aprobados') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de documentos -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            @if($documentos->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Documento</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empresa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Aprobación</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($documentos as $documento)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $documento->nombre_archivo }}</div>
                                            <div class="text-sm text-gray-500">{{ number_format($documento->tamaño_archivo / 1024, 2) }} KB</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div class="h-8 w-8 rounded-full bg-uth-green/10 flex items-center justify-center">
                                                <span class="text-xs font-medium text-uth-green">
                                                    {{ substr($documento->estudiante->user->name, 0, 2) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $documento->estudiante->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $documento->estudiante->matricula }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $documento->estadia->empresa->nombre }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ ucfirst(str_replace('_', ' ', $documento->tipo)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $documento->updated_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button class="text-uth-green hover:text-uth-green/80">
                                            Ver
                                        </button>
                                        <button class="text-blue-600 hover:text-blue-900">
                                            Descargar
                                        </button>
                                        @if($documento->comentarios)
                                        <button class="text-purple-600 hover:text-purple-900" title="Ver comentarios">
                                            Comentarios
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="mt-6">
                    {{ $documentos->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay documentos aprobados</h3>
                    <p class="mt-1 text-sm text-gray-500">No se encontraron documentos aprobados con los filtros aplicados.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection