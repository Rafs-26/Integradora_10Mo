@extends('layouts.app')

@section('title', 'Crear Evaluación - Dashboard Profesor')
@section('page-title', 'Crear Evaluación')

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
        <a href="{{ route('teacher.evaluaciones') }}" class="flex items-center px-4 py-3 text-uth-green bg-uth-green/10 rounded-lg mb-1">
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
        <a href="{{ route('teacher.documentos-revisados') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1">
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
                    <h1 class="text-3xl font-bold text-gray-900">Crear Nueva Evaluación</h1>
                    <p class="mt-1 text-sm text-gray-600">Registra una nueva evaluación para tus estudiantes</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('teacher.evaluaciones') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver a Evaluaciones
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form method="POST" action="{{ route('teacher.evaluaciones.store') }}" class="space-y-8">
            @csrf
            
            <!-- Información Básica -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Información Básica</h3>
                    <p class="mt-1 text-sm text-gray-600">Datos generales de la evaluación</p>
                </div>
                <div class="px-6 py-4 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="estudiante_id" class="block text-sm font-medium text-gray-700 mb-2">Estudiante *</label>
                            <select name="estudiante_id" id="estudiante_id" required 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green">
                                <option value="">Seleccionar estudiante</option>
                                @foreach($estudiantes as $estudiante)
                                    <option value="{{ $estudiante->id }}" {{ request('estudiante') == $estudiante->id ? 'selected' : '' }}>
                                        {{ $estudiante->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('estudiante_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="tipo" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Evaluación *</label>
                            <select name="tipo" id="tipo" required 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green">
                                <option value="">Seleccionar tipo</option>
                                <option value="seguimiento">Evaluación de Seguimiento</option>
                                <option value="parcial">Evaluación Parcial</option>
                                <option value="final">Evaluación Final</option>
                            </select>
                            @error('tipo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div>
                        <label for="titulo" class="block text-sm font-medium text-gray-700 mb-2">Título de la Evaluación *</label>
                        <input type="text" name="titulo" id="titulo" required value="{{ old('titulo') }}"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green"
                               placeholder="Ej: Evaluación Parcial - Primer Mes">
                        @error('titulo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                        <textarea name="descripcion" id="descripcion" rows="3" 
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green"
                                  placeholder="Describe los objetivos y alcance de esta evaluación...">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Criterios de Evaluación -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Criterios de Evaluación</h3>
                    <p class="mt-1 text-sm text-gray-600">Define los criterios específicos para esta evaluación</p>
                </div>
                <div class="px-6 py-4">
                    <div id="criterios-container" class="space-y-4">
                        <!-- Criterios predefinidos -->
                        <div class="criterio-item grid grid-cols-1 md:grid-cols-3 gap-4 p-4 border border-gray-200 rounded-lg">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Criterio</label>
                                <input type="text" name="criterios[0][nombre]" value="Desempeño Técnico" 
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Calificación (0-10)</label>
                                <input type="number" name="criterios[0][calificacion]" min="0" max="10" step="0.1" 
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green">
                            </div>
                        </div>
                        
                        <div class="criterio-item grid grid-cols-1 md:grid-cols-3 gap-4 p-4 border border-gray-200 rounded-lg">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Criterio</label>
                                <input type="text" name="criterios[1][nombre]" value="Actitud y Profesionalismo" 
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Calificación (0-10)</label>
                                <input type="number" name="criterios[1][calificacion]" min="0" max="10" step="0.1" 
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green">
                            </div>
                        </div>
                        
                        <div class="criterio-item grid grid-cols-1 md:grid-cols-3 gap-4 p-4 border border-gray-200 rounded-lg">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Criterio</label>
                                <input type="text" name="criterios[2][nombre]" value="Cumplimiento de Objetivos" 
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Calificación (0-10)</label>
                                <input type="number" name="criterios[2][calificacion]" min="0" max="10" step="0.1" 
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 flex justify-between items-center">
                        <button type="button" id="agregar-criterio" 
                                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Agregar Criterio
                        </button>
                        
                        <div class="text-right">
                            <p class="text-sm text-gray-600">Calificación Final:</p>
                            <p id="calificacion-final" class="text-2xl font-bold text-uth-green">0.0</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calificación y Comentarios -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Calificación Final y Comentarios</h3>
                    <p class="mt-1 text-sm text-gray-600">Calificación general y observaciones</p>
                </div>
                <div class="px-6 py-4 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="calificacion" class="block text-sm font-medium text-gray-700 mb-2">Calificación Final (0-10) *</label>
                            <input type="number" name="calificacion" id="calificacion" min="0" max="10" step="0.1" required 
                                   value="{{ old('calificacion') }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green">
                            @error('calificacion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="fecha_evaluacion" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Evaluación</label>
                            <input type="date" name="fecha_evaluacion" id="fecha_evaluacion" 
                                   value="{{ old('fecha_evaluacion', date('Y-m-d')) }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green">
                            @error('fecha_evaluacion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div>
                        <label for="comentarios" class="block text-sm font-medium text-gray-700 mb-2">Comentarios y Observaciones</label>
                        <textarea name="comentarios" id="comentarios" rows="4" 
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green"
                                  placeholder="Proporciona retroalimentación detallada sobre el desempeño del estudiante...">{{ old('comentarios') }}</textarea>
                        @error('comentarios')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="recomendaciones" class="block text-sm font-medium text-gray-700 mb-2">Recomendaciones para Mejora</label>
                        <textarea name="recomendaciones" id="recomendaciones" rows="3" 
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green"
                                  placeholder="Sugiere áreas de mejora y acciones específicas...">{{ old('recomendaciones') }}</textarea>
                        @error('recomendaciones')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('teacher.evaluaciones') }}" 
                   class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Cancelar
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-uth-green hover:bg-uth-green-dark">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Guardar Evaluación
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let criterioIndex = 3;
    
    document.getElementById('agregar-criterio').addEventListener('click', function() {
        const container = document.getElementById('criterios-container');
        const newCriterio = document.createElement('div');
        newCriterio.className = 'criterio-item grid grid-cols-1 md:grid-cols-3 gap-4 p-4 border border-gray-200 rounded-lg';
        newCriterio.innerHTML = `
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Criterio</label>
                <input type="text" name="criterios[${criterioIndex}][nombre]" 
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green"
                       placeholder="Nombre del criterio">
            </div>
            <div class="flex items-end">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Calificación (0-10)</label>
                    <input type="number" name="criterios[${criterioIndex}][calificacion]" min="0" max="10" step="0.1" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green">
                </div>
                <button type="button" onclick="eliminarCriterio(this)" 
                        class="ml-2 p-2 text-red-600 hover:text-red-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
        `;
        container.appendChild(newCriterio);
        criterioIndex++;
        actualizarCalificacionFinal();
    });
    
    function eliminarCriterio(button) {
        button.closest('.criterio-item').remove();
        actualizarCalificacionFinal();
    }
    
    function actualizarCalificacionFinal() {
        const inputs = document.querySelectorAll('input[name*="[calificacion]"]');
        let suma = 0;
        let count = 0;
        
        inputs.forEach(input => {
            if (input.value && !isNaN(input.value)) {
                suma += parseFloat(input.value);
                count++;
            }
        });
        
        const promedio = count > 0 ? (suma / count).toFixed(1) : '0.0';
        document.getElementById('calificacion-final').textContent = promedio;
        document.getElementById('calificacion').value = promedio;
    }
    
    // Actualizar calificación final cuando cambien los criterios
    document.addEventListener('input', function(e) {
        if (e.target.name && e.target.name.includes('[calificacion]')) {
            actualizarCalificacionFinal();
        }
    });
    
    console.log('Vista Crear Evaluación cargada');
</script>
@endpush