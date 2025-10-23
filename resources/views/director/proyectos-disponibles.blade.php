@extends('layouts.director')

@section('title', 'Proyectos Disponibles')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Proyectos Disponibles</h1>
        <p class="text-gray-600 mt-2">Gestiona los proyectos ofrecidos por las empresas colaboradoras</p>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 00-2 2v2a2 2 0 002 2m0 0h14m-14 0a2 2 0 002 2v2a2 2 0 01-2 2"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Proyectos</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $proyectos->total() }}</p>
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
                    <p class="text-sm font-medium text-gray-600">Disponibles</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $proyectos->where('disponible', true)->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Empresas</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $proyectos->unique('empresa_nombre')->count() }}</p>
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
                    <p class="text-sm font-medium text-gray-600">Nuevos (7 días)</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $proyectos->where('created_at', '>=', now()->subDays(7))->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar proyecto</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green"
                           placeholder="Título o descripción...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Empresa</label>
                    <input type="text" name="empresa" value="{{ request('empresa') }}" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green"
                           placeholder="Nombre de empresa...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                    <select name="disponible" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green">
                        <option value="">Todos</option>
                        <option value="1" {{ request('disponible') == '1' ? 'selected' : '' }}>Disponible</option>
                        <option value="0" {{ request('disponible') == '0' ? 'selected' : '' }}>No disponible</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-uth-green text-white px-4 py-2 rounded-md hover:bg-uth-green/90 mr-2">
                        Filtrar
                    </button>
                    <a href="{{ route('director.proyectos-disponibles') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de proyectos -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            @if($proyectos->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach($proyectos as $proyecto)
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $proyecto->titulo }}</h3>
                                <p class="text-sm text-gray-600 mb-2">{{ $proyecto->empresa_nombre }}</p>
                            </div>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $proyecto->disponible ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $proyecto->disponible ? 'Disponible' : 'No disponible' }}
                            </span>
                        </div>
                        
                        <div class="mb-4">
                            <p class="text-sm text-gray-700 line-clamp-3">{{ $proyecto->descripcion }}</p>
                        </div>
                        
                        <div class="space-y-2 mb-4">
                            @if($proyecto->area_conocimiento)
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                                {{ $proyecto->area_conocimiento }}
                            </div>
                            @endif
                            @if($proyecto->duracion_meses)
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $proyecto->duracion_meses }} meses
                            </div>
                            @endif
                            @if($proyecto->modalidad)
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ ucfirst($proyecto->modalidad) }}
                            </div>
                            @endif
                        </div>
                        
                        @if($proyecto->requisitos)
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Requisitos:</h4>
                            <p class="text-sm text-gray-600">{{ $proyecto->requisitos }}</p>
                        </div>
                        @endif
                        
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <div class="text-sm text-gray-500">
                                Publicado: {{ \Carbon\Carbon::parse($proyecto->created_at)->format('d/m/Y') }}
                            </div>
                            <div class="flex space-x-2">
                                <button class="text-uth-green hover:text-uth-green/80 text-sm font-medium">
                                    Ver detalles
                                </button>
                                @if($proyecto->disponible)
                                <button class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                    Asignar estudiante
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Paginación -->
                <div class="mt-6">
                    {{ $proyectos->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 00-2 2v2a2 2 0 002 2m0 0h14m-14 0a2 2 0 002 2v2a2 2 0 01-2 2"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay proyectos</h3>
                    <p class="mt-1 text-sm text-gray-500">No se encontraron proyectos con los filtros aplicados.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection