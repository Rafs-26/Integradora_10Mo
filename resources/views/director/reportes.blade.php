@extends('layouts.director')

@section('title', 'Reportes y Estadísticas')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Reportes y Estadísticas</h1>
        <p class="text-gray-600 mt-2">Análisis detallado del programa de estadías</p>
    </div>

    <!-- Estadísticas generales -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Estadías</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $estadisticasMensuales->sum('total') }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Carreras</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $estadisticasCarrera->count() }}</p>
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
                    <p class="text-2xl font-semibold text-gray-900">{{ $empresasActivas->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Promedio Mensual</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $estadisticasMensuales->count() > 0 ? round($estadisticasMensuales->avg('total'), 1) : 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Gráfico de estadías por mes -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Estadías por Mes ({{ date('Y') }})</h3>
            <div class="space-y-3">
                @foreach($estadisticasMensuales as $stat)
                <div class="flex items-center">
                    <div class="w-20 text-sm text-gray-600">
                        {{ DateTime::createFromFormat('!m', $stat->mes)->format('M') }}
                    </div>
                    <div class="flex-1 mx-4">
                        <div class="bg-gray-200 rounded-full h-4">
                            <div class="bg-uth-green h-4 rounded-full" 
                                 style="width: {{ $estadisticasMensuales->max('total') > 0 ? ($stat->total / $estadisticasMensuales->max('total')) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="w-12 text-sm font-medium text-gray-900 text-right">
                        {{ $stat->total }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Estadísticas por carrera -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Estadías por Carrera</h3>
            <div class="space-y-3">
                @foreach($estadisticasCarrera->take(8) as $stat)
                <div class="flex items-center">
                    <div class="flex-1">
                        <div class="text-sm font-medium text-gray-900">{{ $stat->nombre }}</div>
                    </div>
                    <div class="flex-1 mx-4">
                        <div class="bg-gray-200 rounded-full h-3">
                            <div class="bg-blue-500 h-3 rounded-full" 
                                 style="width: {{ $estadisticasCarrera->max('total') > 0 ? ($stat->total / $estadisticasCarrera->max('total')) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="w-12 text-sm font-medium text-gray-900 text-right">
                        {{ $stat->total }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Empresas más activas -->
    <div class="mt-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Empresas Más Activas</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empresa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Razón Social</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Estadías</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($empresasActivas as $empresa)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $empresa->nombre }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $empresa->razon_social }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $empresa->estadias_count }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $empresa->status == 'activa' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($empresa->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Generador de Reportes PDF -->
    <div class="mt-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Generar Reportes en PDF</h3>
            <form action="{{ route('director.reportes.generar-pdf') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Tipo de Reporte -->
                <div>
                    <label for="tipo_reporte" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Reporte</label>
                    <select name="tipo_reporte" id="tipo_reporte" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-uth-green focus:border-uth-green">
                        <option value="">Seleccionar tipo de reporte...</option>
                        <option value="estadisticas_generales">Estadísticas Generales</option>
                        <option value="estudiantes_por_carrera">Estudiantes por Carrera</option>
                        <option value="empresas_activas">Empresas Más Activas</option>
                        <option value="documentos_pendientes">Documentos Pendientes</option>
                    </select>
                </div>

                <!-- Rango de Fechas -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 mb-2">Fecha Inicio (Opcional)</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-uth-green focus:border-uth-green">
                        <p class="text-xs text-gray-500 mt-1">Dejar vacío para incluir todos los registros desde el inicio</p>
                    </div>
                    <div>
                        <label for="fecha_fin" class="block text-sm font-medium text-gray-700 mb-2">Fecha Fin (Opcional)</label>
                        <input type="date" name="fecha_fin" id="fecha_fin" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-uth-green focus:border-uth-green">
                        <p class="text-xs text-gray-500 mt-1">Dejar vacío para incluir hasta la fecha actual</p>
                    </div>
                </div>

                <!-- Descripción del reporte seleccionado -->
                <div id="descripcion-reporte" class="hidden">
                    <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-blue-800">Descripción del Reporte</h4>
                                <div class="mt-1 text-sm text-blue-700" id="descripcion-texto"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botón de Generar -->
                <div class="flex justify-end">
                    <button type="submit" 
                            class="bg-red-600 text-white px-6 py-3 rounded-md hover:bg-red-700 flex items-center justify-center font-medium transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Generar Reporte PDF
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript para mostrar descripción del reporte -->
    <script>
        document.getElementById('tipo_reporte').addEventListener('change', function() {
            const descripcionDiv = document.getElementById('descripcion-reporte');
            const descripcionTexto = document.getElementById('descripcion-texto');
            const valor = this.value;
            
            const descripciones = {
                'estadisticas_generales': 'Reporte completo con estadísticas generales del sistema: total de estadías, estudiantes, empresas y documentos pendientes.',
                'estudiantes_por_carrera': 'Distribución detallada de estudiantes organizados por carrera académica con porcentajes y totales.',
                'empresas_activas': 'Listado de las empresas más activas en el programa de estadías, ordenadas por número de estudiantes recibidos.',
                'documentos_pendientes': 'Reporte de todos los documentos que requieren revisión y aprobación, con tiempos de espera.'
            };
            
            if (valor && descripciones[valor]) {
                descripcionTexto.textContent = descripciones[valor];
                descripcionDiv.classList.remove('hidden');
            } else {
                descripcionDiv.classList.add('hidden');
            }
        });
    </script>
</div>
@endsection