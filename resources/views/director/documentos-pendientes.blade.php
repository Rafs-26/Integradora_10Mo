@extends('layouts.director')

@section('title', 'Documentos Pendientes')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Documentos Pendientes de Revisión</h1>
        <p class="text-gray-600">Revisa y aprueba los documentos enviados por los estudiantes</p>
    </div>

    <!-- Estadísticas Rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Total Pendientes</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_pendientes'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Urgentes</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['urgentes'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Aprobados Hoy</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['aprobados_hoy'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Tiempo Promedio</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['tiempo_promedio'] }}h</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Filtros</h2>
        <form method="GET" action="{{ route('director.documentos-pendientes') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label for="tipo_documento" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Documento</label>
                <select name="tipo_documento" id="tipo_documento" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-uth-green focus:border-transparent">
                    <option value="">Todos los tipos</option>
                    <option value="carta_presentacion" {{ request('tipo_documento') == 'carta_presentacion' ? 'selected' : '' }}>Carta de Presentación</option>
                    <option value="reporte_parcial" {{ request('tipo_documento') == 'reporte_parcial' ? 'selected' : '' }}>Reporte Parcial</option>
                    <option value="reporte_final" {{ request('tipo_documento') == 'reporte_final' ? 'selected' : '' }}>Reporte Final</option>
                    <option value="evaluacion_empresa" {{ request('tipo_documento') == 'evaluacion_empresa' ? 'selected' : '' }}>Evaluación de Empresa</option>
                    <option value="otros" {{ request('tipo_documento') == 'otros' ? 'selected' : '' }}>Otros</option>
                </select>
            </div>
            <div>
                <label for="carrera" class="block text-sm font-medium text-gray-700 mb-2">Carrera</label>
                <select name="carrera" id="carrera" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-uth-green focus:border-transparent">
                    <option value="">Todas las carreras</option>
                    @foreach($carreras as $carrera)
                        <option value="{{ $carrera->id }}" {{ request('carrera') == $carrera->id ? 'selected' : '' }}>
                            {{ $carrera->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="prioridad" class="block text-sm font-medium text-gray-700 mb-2">Prioridad</label>
                <select name="prioridad" id="prioridad" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-uth-green focus:border-transparent">
                    <option value="">Todas las prioridades</option>
                    <option value="alta" {{ request('prioridad') == 'alta' ? 'selected' : '' }}>Alta</option>
                    <option value="media" {{ request('prioridad') == 'media' ? 'selected' : '' }}>Media</option>
                    <option value="baja" {{ request('prioridad') == 'baja' ? 'selected' : '' }}>Baja</option>
                </select>
            </div>
            <div>
                <label for="buscar" class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                <input type="text" name="buscar" id="buscar" value="{{ request('buscar') }}" placeholder="Nombre del estudiante" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-uth-green focus:border-transparent">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-uth-green text-white px-4 py-2 rounded-md hover:bg-uth-green-dark transition-colors">
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Lista de Documentos Pendientes -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Documentos Pendientes ({{ $documentos->total() }})</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Documento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Envío</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioridad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($documentos as $documento)
                        <tr class="hover:bg-gray-50 {{ $documento->prioridad == 'alta' ? 'bg-red-50' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $documento->nombre }}</div>
                                        <div class="text-sm text-gray-500">{{ $documento->descripcion ?? 'Sin descripción' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <div class="h-8 w-8 rounded-full bg-uth-green flex items-center justify-center">
                                            <span class="text-xs font-medium text-white">
                                                {{ substr($documento->estudiante->nombre, 0, 1) }}{{ substr($documento->estudiante->apellido_paterno, 0, 1) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $documento->estudiante->nombre }} {{ $documento->estudiante->apellido_paterno }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $documento->estudiante->matricula }} - {{ $documento->estudiante->carrera->nombre ?? 'Sin carrera' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $tipoClasses = [
                                        'carta_presentacion' => 'bg-blue-100 text-blue-800',
                                        'reporte_parcial' => 'bg-yellow-100 text-yellow-800',
                                        'reporte_final' => 'bg-green-100 text-green-800',
                                        'evaluacion_empresa' => 'bg-purple-100 text-purple-800',
                                        'otros' => 'bg-gray-100 text-gray-800'
                                    ];
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $tipoClasses[$documento->tipo] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst(str_replace('_', ' ', $documento->tipo)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div>{{ $documento->created_at->format('d/m/Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $documento->created_at->format('H:i') }}</div>
                                @php
                                    $diasPendiente = $documento->created_at->diffInDays(now());
                                @endphp
                                <div class="text-xs {{ $diasPendiente > 3 ? 'text-red-600' : 'text-gray-500' }}">
                                    {{ $diasPendiente }} días pendiente
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $prioridadClasses = [
                                        'alta' => 'bg-red-100 text-red-800',
                                        'media' => 'bg-yellow-100 text-yellow-800',
                                        'baja' => 'bg-green-100 text-green-800'
                                    ];
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $prioridadClasses[$documento->prioridad] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($documento->prioridad) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('director.ver-documento', $documento->id) }}" class="text-uth-green hover:text-uth-green-dark">
                                        Ver
                                    </a>
                                    <button onclick="aprobarDocumento({{ $documento->id }})" class="text-green-600 hover:text-green-900">
                                        Aprobar
                                    </button>
                                    <button onclick="rechazarDocumento({{ $documento->id }})" class="text-red-600 hover:text-red-900">
                                        Rechazar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No hay documentos pendientes de revisión.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Paginación -->
        @if($documentos->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $documentos->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal para Aprobar Documento -->
<div id="modalAprobar" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Aprobar Documento</h3>
            </div>
            <form id="formAprobar" method="POST">
                @csrf
                @method('PUT')
                <div class="px-6 py-4">
                    <label for="comentarios_aprobacion" class="block text-sm font-medium text-gray-700 mb-2">Comentarios (opcional)</label>
                    <textarea name="comentarios" id="comentarios_aprobacion" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-uth-green focus:border-transparent" placeholder="Comentarios sobre la aprobación..."></textarea>
                </div>
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <button type="button" onclick="cerrarModalAprobar()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">
                        Aprobar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Rechazar Documento -->
<div id="modalRechazar" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Rechazar Documento</h3>
            </div>
            <form id="formRechazar" method="POST">
                @csrf
                @method('PUT')
                <div class="px-6 py-4">
                    <label for="motivo_rechazo" class="block text-sm font-medium text-gray-700 mb-2">Motivo del rechazo *</label>
                    <textarea name="comentarios" id="motivo_rechazo" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-uth-green focus:border-transparent" placeholder="Explique el motivo del rechazo..." required></textarea>
                </div>
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <button type="button" onclick="cerrarModalRechazar()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">
                        Rechazar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function aprobarDocumento(documentoId) {
    const modal = document.getElementById('modalAprobar');
    const form = document.getElementById('formAprobar');
    form.action = `/director/documentos/${documentoId}/aprobar`;
    modal.classList.remove('hidden');
}

function rechazarDocumento(documentoId) {
    const modal = document.getElementById('modalRechazar');
    const form = document.getElementById('formRechazar');
    form.action = `/director/documentos/${documentoId}/rechazar`;
    modal.classList.remove('hidden');
}

function cerrarModalAprobar() {
    const modal = document.getElementById('modalAprobar');
    modal.classList.add('hidden');
    document.getElementById('formAprobar').reset();
}

function cerrarModalRechazar() {
    const modal = document.getElementById('modalRechazar');
    modal.classList.add('hidden');
    document.getElementById('formRechazar').reset();
}

// Cerrar modales al hacer clic fuera
document.getElementById('modalAprobar').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalAprobar();
    }
});

document.getElementById('modalRechazar').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalRechazar();
    }
});
</script>
@endsection