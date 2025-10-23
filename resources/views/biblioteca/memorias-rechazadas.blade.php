@extends('layouts.app')

@section('title', 'Memorias Rechazadas - Sistema de Estadías UTH')
@section('page-title', 'Memorias Rechazadas')

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
        <a href="{{ route('biblioteca.memorias-rechazadas') }}" class="flex items-center px-4 py-3 text-uth-green bg-uth-green/10 rounded-lg mb-1">
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
            <h1 class="text-2xl font-bold text-gray-900">Memorias Rechazadas</h1>
            <p class="text-gray-600 mt-1">Memorias de estadía que requieren correcciones</p>
        </div>
        <div class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">
            {{ $memorias->total() }} memorias rechazadas
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="GET" action="{{ route('biblioteca.memorias-rechazadas') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Buscar estudiante</label>
                <input type="text" name="buscar" value="{{ request('buscar') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-uth-green focus:border-uth-green"
                       placeholder="Nombre o número de control">
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
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de rechazo</label>
                <input type="date" name="fecha" value="{{ request('fecha') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-uth-green focus:border-uth-green">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-uth-green text-white px-4 py-2 rounded-lg hover:bg-uth-green/90 transition-colors">
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Lista de Memorias -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($memorias->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Carrera</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empresa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Rechazo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Archivo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motivo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($memorias as $memoria)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center">
                                            <span class="text-sm font-medium text-red-800">
                                                {{ substr($memoria->estudiante->user->name, 0, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $memoria->estudiante->user->name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $memoria->estudiante->numero_control }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $memoria->estudiante->carrera->nombre ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $memoria->estadia->empresa->nombre ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $memoria->fecha_validacion ? $memoria->fecha_validacion->format('d/m/Y H:i') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center text-sm text-gray-900">
                                    <svg class="w-4 h-4 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ Str::limit($memoria->nombre_archivo, 20) }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="max-w-xs">
                                    <p class="text-sm text-gray-900 truncate" title="{{ $memoria->comentarios_validacion }}">
                                        {{ Str::limit($memoria->comentarios_validacion, 50) }}
                                    </p>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('biblioteca.descargar-memoria', $memoria->id) }}" 
                                       class="text-blue-600 hover:text-blue-500 transition-colors" title="Descargar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </a>
                                    <button onclick="mostrarMotivo('{{ $memoria->id }}', '{{ addslashes($memoria->comentarios_validacion) }}')"
                                            class="text-red-600 hover:text-red-500 transition-colors" title="Ver motivo completo">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>
                                    <!-- Opción para reactivar para nueva revisión -->
                                    <form action="{{ route('biblioteca.reactivar-memoria', $memoria->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="text-green-600 hover:text-green-500 transition-colors" 
                                                title="Reactivar para nueva revisión"
                                                onclick="return confirm('¿Deseas reactivar esta memoria para una nueva revisión?')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $memorias->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No hay memorias rechazadas</h3>
                <p class="mt-1 text-sm text-gray-500">No se encontraron memorias que coincidan con los filtros aplicados.</p>
            </div>
        @endif
    </div>
</div>

<!-- Modal para mostrar motivo completo -->
<div id="modalMotivo" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Motivo del Rechazo</h3>
                <button onclick="cerrarModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <p id="motivoTexto" class="text-gray-700"></p>
            </div>
            <div class="mt-4 text-right">
                <button onclick="cerrarModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function mostrarMotivo(memoriaId, motivo) {
    document.getElementById('motivoTexto').textContent = motivo;
    document.getElementById('modalMotivo').classList.remove('hidden');
}

function cerrarModal() {
    document.getElementById('modalMotivo').classList.add('hidden');
}

// Cerrar modal al hacer clic fuera de él
document.getElementById('modalMotivo').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModal();
    }
});
</script>
@endsection