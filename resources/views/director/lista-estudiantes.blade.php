@extends('layouts.director')

@section('title', 'Lista de Estudiantes')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Lista de Estudiantes</h1>
        <p class="text-gray-600">Gestiona y supervisa todos los estudiantes del programa de estadías</p>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Filtros</h2>
        <form method="GET" action="{{ route('director.lista-estudiantes') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
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
                <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                <select name="estado" id="estado" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-uth-green focus:border-transparent">
                    <option value="">Todos los estados</option>
                    <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="en_estadia" {{ request('estado') == 'en_estadia' ? 'selected' : '' }}>En Estadía</option>
                    <option value="completado" {{ request('estado') == 'completado' ? 'selected' : '' }}>Completado</option>
                    <option value="suspendido" {{ request('estado') == 'suspendido' ? 'selected' : '' }}>Suspendido</option>
                </select>
            </div>
            <div>
                <label for="buscar" class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                <input type="text" name="buscar" id="buscar" value="{{ request('buscar') }}" placeholder="Nombre o matrícula" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-uth-green focus:border-transparent">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-uth-green text-white px-4 py-2 rounded-md hover:bg-uth-green-dark transition-colors">
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Tabla de Estudiantes -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Estudiantes ({{ $estudiantes->total() }})</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Carrera</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empresa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profesor Asignado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($estudiantes as $estudiante)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-uth-green flex items-center justify-center">
                                            <span class="text-sm font-medium text-white">
                                                {{ substr($estudiante->nombre, 0, 1) }}{{ substr($estudiante->apellido_paterno, 0, 1) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $estudiante->nombre }} {{ $estudiante->apellido_paterno }} {{ $estudiante->apellido_materno }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $estudiante->matricula }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $estudiante->carrera->nombre ?? 'No asignada' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
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
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $estudiante->estadia->empresa->nombre ?? 'Sin asignar' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($estudiante->estadia && $estudiante->estadia->profesorSupervisor)
                                    {{ $estudiante->estadia->profesorSupervisor->user->name }}
                                @elseif($estudiante->tutorAsignado)
                                    {{ $estudiante->tutorAsignado->user->name }}
                                @else
                                    <span class="text-gray-500">Sin asignar</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('director.seguimiento-estudiantes', $estudiante->id) }}" class="text-uth-green hover:text-uth-green-dark">
                                        Ver Detalles
                                    </a>
                                    <button onclick="asignarProfesor({{ $estudiante->id }})" class="text-blue-600 hover:text-blue-900">
                                        Asignar Profesor
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No se encontraron estudiantes con los filtros aplicados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Paginación -->
        @if($estudiantes->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $estudiantes->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal para Asignar Profesor -->
<div id="modalAsignarProfesor" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Asignar Profesor</h3>
            </div>
            <form id="formAsignarProfesor" method="POST">
                @csrf
                <div class="px-6 py-4">
                    <label for="profesor_id" class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Profesor</label>
                    <select name="profesor_id" id="profesor_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-uth-green focus:border-transparent" required>
                        <option value="">Seleccione un profesor</option>
                        @foreach($profesores as $profesor)
                            <option value="{{ $profesor->id }}">
                                {{ $profesor->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <button type="button" onclick="cerrarModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-uth-green rounded-md hover:bg-uth-green-dark">
                        Asignar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function asignarProfesor(estudianteId) {
    const modal = document.getElementById('modalAsignarProfesor');
    const form = document.getElementById('formAsignarProfesor');
    form.action = `/director/estudiantes/${estudianteId}/asignar-profesor`;
    modal.classList.remove('hidden');
}

function cerrarModal() {
    const modal = document.getElementById('modalAsignarProfesor');
    modal.classList.add('hidden');
}

// Cerrar modal al hacer clic fuera
document.getElementById('modalAsignarProfesor').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModal();
    }
});
</script>
@endsection