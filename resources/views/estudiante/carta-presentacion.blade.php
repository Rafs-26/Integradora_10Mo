@extends('layouts.app')

@section('title', 'Solicitar Carta de Presentación')

@section('sidebar-menu')
    <!-- Inicio -->
    <a href="{{ route('student.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-2">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
        </svg>
        Inicio
    </a>
    
    <!-- Mi Estadía -->
    <div class="mb-4">
        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Mi Estadía</h3>
        <a href="{{ route('student.mi-estadia') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            Estado Actual
        </a>
        <a href="{{ route('student.documentos') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1 ml-4">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Documentos
        </a>
    </div>
    
    <!-- Solicitar Carta de Presentación -->
    <a href="{{ route('student.carta-presentacion') }}" class="flex items-center px-4 py-3 text-uth-green bg-uth-green/10 rounded-lg mb-2">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        Solicitar Carta de Presentación
    </a>
    
    <!-- Formatos Disponibles -->
    <a href="{{ route('student.formatos-disponibles') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-2">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        Formatos Disponibles
    </a>
    
    <!-- Empresas -->
    <a href="{{ route('student.empresas-catalogo') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-2">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
        </svg>
        Empresas
    </a>
    


@endsection

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('student.dashboard') }}" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Solicitar Carta de Presentación</h1>
                    <p class="text-gray-600 mt-1">Solicita tu carta de presentación para la empresa</p>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Información de la Estadía -->
        @if($estadia)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Información de tu Estadía</h2>
                <p class="text-gray-600">Datos que se incluirán en la carta de presentación</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Empresa</label>
                        <p class="text-sm text-gray-900">{{ $estadia->empresa->nombre ?? 'No asignada' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Proyecto</label>
                        <p class="text-sm text-gray-900">{{ $estadia->proyecto ?? 'No definido' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Área</label>
                        <p class="text-sm text-gray-900">{{ $estadia->area ?? 'No definida' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Período</label>
                        <p class="text-sm text-gray-900">
                            @if($estadia->fecha_inicio && $estadia->fecha_fin)
                                {{ \Carbon\Carbon::parse($estadia->fecha_inicio)->format('d/m/Y') }} - 
                                {{ \Carbon\Carbon::parse($estadia->fecha_fin)->format('d/m/Y') }}
                            @else
                                Fechas no definidas
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Estado de la Carta de Presentación -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Estado de tu Carta de Presentación</h2>
                <p class="text-gray-600">Progreso del trámite de tu carta</p>
            </div>
            <div class="p-6">
                @if($solicitudCarta)
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-lg font-medium text-gray-900">Progreso del Trámite</h3>
                            <span class="text-sm font-medium text-gray-600">{{ $solicitudCarta->progreso }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3 mb-4">
                            <div class="bg-{{ $solicitudCarta->color_estado }} h-3 rounded-full transition-all duration-300" style="width: {{ $solicitudCarta->progreso }}%"></div>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">Estado actual: <span class="font-semibold text-gray-900">{{ $solicitudCarta->estado_formateado }}</span></p>
                        
                        @if($solicitudCarta->estado === 'generada' && $solicitudCarta->archivo_carta)
                            <div class="flex justify-center">
                                <a href="{{ route('student.carta-presentacion.descargar', $solicitudCarta->id) }}" 
                                   class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" 
                                   target="_blank">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Descargar Carta de Presentación
                                </a>
                            </div>
                        @elseif(in_array($solicitudCarta->estado, ['aprobada_director']))
                            <div class="text-center">
                                @if($solicitudCarta->archivo_firmado)
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                                        <div class="flex items-center justify-center mb-2">
                                            <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-green-800 font-semibold">Carta Firmada Digitalmente</span>
                                        </div>
                                        <p class="text-sm text-green-700">Tu carta ha sido aprobada y firmada digitalmente por el director.</p>
                                        @if($solicitudCarta->comentarios_director)
                                            <p class="text-sm text-green-600 mt-2"><strong>Comentarios del director:</strong> {{ $solicitudCarta->comentarios_director }}</p>
                                        @endif
                                    </div>
                                @endif
                                <a href="{{ route('student.carta-presentacion.descargar', $solicitudCarta->id) }}" 
                                   class="inline-flex items-center px-6 py-3 {{ $solicitudCarta->archivo_firmado ? 'bg-green-600 hover:bg-green-700 focus:ring-green-500' : 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500' }} text-white font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors" 
                                   target="_blank">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    {{ $solicitudCarta->archivo_firmado ? 'Descargar Carta Firmada' : 'Descargar Carta de Presentación' }}
                                </a>
                            </div>
                        @elseif(in_array($solicitudCarta->estado, ['rechazada', 'rechazada_profesor', 'rechazada_director']))
                            <div class="flex justify-center">
                                <button onclick="solicitarNuevaCarta()" 
                                        class="inline-flex items-center px-6 py-3 bg-yellow-600 text-white font-medium rounded-lg hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Solicitar Nueva Carta
                                </button>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Detalles de la solicitud -->
                    <div class="border-t border-gray-200 pt-6">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Detalles de la Solicitud</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Dirigida a</label>
                                <p class="text-sm text-gray-900">{{ $solicitudCarta->dirigida_a }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Cargo del destinatario</label>
                                <p class="text-sm text-gray-900">{{ $solicitudCarta->cargo_destinatario ?? 'No especificado' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de solicitud</label>
                                <p class="text-sm text-gray-900">{{ $solicitudCarta->fecha_solicitud->format('d/m/Y H:i') }}</p>
                            </div>
                            @if($solicitudCarta->fecha_procesada)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de procesamiento</label>
                                <p class="text-sm text-gray-900">{{ $solicitudCarta->fecha_procesada->format('d/m/Y H:i') }}</p>
                            </div>
                            @endif
                        </div>
                        
                        @if($solicitudCarta->comentarios_coordinador)
                        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h5 class="text-sm font-medium text-blue-800 mb-2">Comentarios del coordinador:</h5>
                            <p class="text-sm text-blue-700">{{ $solicitudCarta->comentarios_coordinador }}</p>
                        </div>
                        @endif

                        @if($solicitudCarta->comentarios_director && $solicitudCarta->estado === 'rechazada_director')
                        <div class="mt-6 bg-red-50 border border-red-200 rounded-lg p-4">
                            <h5 class="text-sm font-medium text-red-800 mb-2">Motivo del rechazo (Director):</h5>
                            <p class="text-sm text-red-700">{{ $solicitudCarta->comentarios_director }}</p>
                            <p class="text-xs text-red-600 mt-2">Puedes corregir la información y solicitar de nuevo tu carta.</p>
                        </div>
                        @endif
                        
                        @if($solicitudCarta->comentarios_profesor && $solicitudCarta->estado === 'rechazada_profesor')
                        <div class="mt-6 bg-red-50 border border-red-200 rounded-lg p-4">
                            <h5 class="text-sm font-medium text-red-800 mb-2">Motivo del rechazo (Profesor):</h5>
                            <p class="text-sm text-red-700">{{ $solicitudCarta->comentarios_profesor }}</p>
                        </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No has solicitado una carta de presentación</h3>
                        <p class="text-gray-600 mb-6">Solicita tu carta de presentación para iniciar el proceso de estadías.</p>
                        @if($estadia)
                            <button onclick="solicitarCarta()" 
                                    class="inline-flex items-center px-6 py-3 bg-uth-green text-white font-medium rounded-lg hover:bg-uth-green/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-uth-green">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Solicitar Carta de Presentación
                            </button>
                        @else
                            <p class="text-yellow-600 font-medium">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                Necesitas tener una estadía asignada para solicitar la carta.
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>



        @if(!$estadia)
        <!-- Mensaje si no tiene estadía asignada -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
            <svg class="w-12 h-12 text-yellow-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            <h3 class="text-lg font-medium text-yellow-800 mb-2">No tienes una estadía asignada</h3>
            <p class="text-yellow-700 mb-4">Para solicitar una carta de presentación necesitas tener una estadía asignada.</p>
            <a href="{{ route('student.empresas') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-uth-green rounded-lg hover:bg-uth-green/90">
                Ver empresas disponibles
            </a>
        </div>
        @endif
    </div>
</div>

<script>
// Función para solicitar nueva carta
function solicitarNuevaCarta() {
    if (confirm('¿Estás seguro de que deseas solicitar una nueva carta de presentación?')) {
        // Aquí puedes agregar la lógica para solicitar una nueva carta
        window.location.href = '{{ route("student.carta-presentacion.solicitar") }}';
    }
}

// Función para solicitar carta por primera vez
function solicitarCarta() {
    // Aquí puedes agregar la lógica para solicitar la carta
    window.location.href = '{{ route("student.carta-presentacion.solicitar") }}';
}
</script>
@endsection
