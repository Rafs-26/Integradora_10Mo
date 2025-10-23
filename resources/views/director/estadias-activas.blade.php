@extends('layouts.director')

@section('title', 'Estadías Activas')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Estadías Activas</h1>
        <p class="text-gray-600">Supervisa todas las estadías en curso y su progreso</p>
    </div>

    <!-- Estadísticas Rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
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
                    <p class="text-sm font-medium text-gray-500">Total Activas</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_activas'] }}</p>
                </div>
            </div>
        </div>

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
                    <p class="text-sm font-medium text-gray-500">Por Vencer</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['por_vencer'] }}</p>
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
                    <p class="text-sm font-medium text-gray-500">Progreso Promedio</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['progreso_promedio'] }}%</p>
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
                    <p class="text-sm font-medium text-gray-500">Con Problemas</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['con_problemas'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Filtros</h2>
        <form method="GET" action="{{ route('director.estadias-activas') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label for="empresa" class="block text-sm font-medium text-gray-700 mb-2">Empresa</label>
                <select name="empresa" id="empresa" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-uth-green focus:border-transparent">
                    <option value="">Todas las empresas</option>
                    @foreach($empresas as $empresa)
                        <option value="{{ $empresa->id }}" {{ request('empresa') == $empresa->id ? 'selected' : '' }}>
                            {{ $empresa->nombre }}
                        </option>
                    @endforeach
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
                <label for="profesor" class="block text-sm font-medium text-gray-700 mb-2">Profesor</label>
                <select name="profesor" id="profesor" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-uth-green focus:border-transparent">
                    <option value="">Todos los profesores</option>
                    @foreach($profesores as $profesor)
                        <option value="{{ $profesor->id }}" {{ request('profesor') == $profesor->id ? 'selected' : '' }}>
                            {{ $profesor->user->name }}
                        </option>
                    @endforeach
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

    <!-- Lista de Estadías Activas -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Estadías Activas ({{ $estadias->total() }})</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empresa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profesor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fechas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progreso</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($estadias as $estadia)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-uth-green flex items-center justify-center">
                                            <span class="text-sm font-medium text-white">
                                                {{ substr($estadia->estudiante->nombre, 0, 1) }}{{ substr($estadia->estudiante->apellido_paterno, 0, 1) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $estadia->estudiante->nombre }} {{ $estadia->estudiante->apellido_paterno }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $estadia->estudiante->matricula }} - {{ $estadia->estudiante->carrera->nombre ?? 'Sin carrera' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $estadia->empresa->nombre }}</div>
                                <div class="text-sm text-gray-500">{{ $estadia->empresa->sector ?? 'Sector no especificado' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $estadia->estudiante->profesor->user->name ?? 'Sin asignar' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div>Inicio: {{ $estadia->fecha_inicio ? $estadia->fecha_inicio->format('d/m/Y') : 'No definida' }}</div>
                                <div>Fin: {{ $estadia->fecha_fin ? $estadia->fecha_fin->format('d/m/Y') : 'No definida' }}</div>
                                @if($estadia->fecha_fin)
                                    @php
                                        $diasRestantes = now()->diffInDays($estadia->fecha_fin, false);
                                    @endphp
                                    <div class="text-xs {{ $diasRestantes < 30 ? 'text-red-600' : 'text-gray-500' }}">
                                        {{ $diasRestantes > 0 ? $diasRestantes . ' días restantes' : 'Vencida' }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $progreso = $estadia->porcentaje_progreso ?? 0;
                                    $colorClass = $progreso >= 75 ? 'bg-green-500' : ($progreso >= 50 ? 'bg-yellow-500' : 'bg-red-500');
                                @endphp
                                <div class="flex items-center">
                                    <div class="w-full bg-gray-200 rounded-full h-2 mr-2">
                                        <div class="{{ $colorClass }} h-2 rounded-full" style="width: {{ $progreso }}%"></div>
                                    </div>
                                    <span class="text-sm text-gray-900">{{ $progreso }}%</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $estadoClasses = [
                                        'activa' => 'bg-green-100 text-green-800',
                                        'pendiente' => 'bg-yellow-100 text-yellow-800',
                                        'completada' => 'bg-blue-100 text-blue-800',
                                        'cancelada' => 'bg-red-100 text-red-800'
                                    ];
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $estadoClasses[$estadia->estado] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($estadia->estado) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('director.seguimiento-estudiantes', $estadia->estudiante->id) }}" class="text-uth-green hover:text-uth-green-dark">
                                        Ver Detalles
                                    </a>
                                    <button onclick="actualizarProgreso({{ $estadia->id }})" class="text-blue-600 hover:text-blue-900">
                                        Actualizar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                No se encontraron estadías activas con los filtros aplicados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Paginación -->
        @if($estadias->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $estadias->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal para Actualizar Progreso -->
<div id="modalActualizarProgreso" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Actualizar Progreso</h3>
            </div>
            <form id="formActualizarProgreso" method="POST">
                @csrf
                @method('PUT')
                <div class="px-6 py-4">
                    <label for="progreso" class="block text-sm font-medium text-gray-700 mb-2">Progreso (%)</label>
                    <input type="number" name="progreso" id="progreso" min="0" max="100" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-uth-green focus:border-transparent" required>
                    
                    <label for="comentarios" class="block text-sm font-medium text-gray-700 mb-2 mt-4">Comentarios (opcional)</label>
                    <textarea name="comentarios" id="comentarios" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-uth-green focus:border-transparent" placeholder="Observaciones sobre el progreso..."></textarea>
                </div>
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <button type="button" onclick="cerrarModalProgreso()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-uth-green rounded-md hover:bg-uth-green-dark">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function actualizarProgreso(estadiaId) {
    const modal = document.getElementById('modalActualizarProgreso');
    const form = document.getElementById('formActualizarProgreso');
    form.action = `/director/estadias/${estadiaId}/progreso`;
    modal.classList.remove('hidden');
}

function cerrarModalProgreso() {
    const modal = document.getElementById('modalActualizarProgreso');
    modal.classList.add('hidden');
    document.getElementById('formActualizarProgreso').reset();
}

// Cerrar modal al hacer clic fuera
document.getElementById('modalActualizarProgreso').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalProgreso();
    }
});
</script>
@endsection