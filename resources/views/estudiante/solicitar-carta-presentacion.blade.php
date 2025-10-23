@extends('layouts.app')

@section('title', 'Solicitar Carta de Presentación')
@section('page-title', 'Solicitar Carta de Presentación')

@section('sidebar-menu')
    <a href="{{ route('student.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-2">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
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
            <!-- Información de la Estadía -->
            @if($estadia)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Información de tu Estadía</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Empresa:</p>
                        <p class="font-medium text-gray-800">{{ $estadia->empresa->nombre ?? 'No asignada' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Proyecto:</p>
                        <p class="font-medium text-gray-800">{{ $estadia->proyecto ?? 'No especificado' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Área:</p>
                        <p class="font-medium text-gray-800">{{ $estadia->area_empresa ?? 'No especificada' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Período:</p>
                        <p class="font-medium text-gray-800">
                            @if($estadia->fecha_inicio && $estadia->fecha_fin)
                                {{ \Carbon\Carbon::parse($estadia->fecha_inicio)->format('d/m/Y') }} - 
                                {{ \Carbon\Carbon::parse($estadia->fecha_fin)->format('d/m/Y') }}
                            @else
                                Por definir
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Validación de Información Requerida -->
            @if(!$estadia->proyecto || !$estadia->area_empresa)
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-yellow-800 mb-1">Información Incompleta</h3>
                        <p class="text-sm text-yellow-700 mb-4">
                            Para solicitar tu carta de presentación, es necesario que especifiques el proyecto y área donde realizarás tu estadía.
                        </p>
                        <a href="{{ route('student.estadia.editar-proyecto') }}" 
                           class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white text-sm font-medium rounded-lg hover:bg-yellow-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Completar Información
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Confirmación de Solicitud -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Confirmar Solicitud de Carta de Presentación</h2>
                
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm font-medium text-blue-800 mb-1">Información sobre la Carta de Presentación</h3>
                            <p class="text-sm text-blue-700">
                                La carta de presentación será generada automáticamente con tus datos académicos y será dirigida a la empresa donde realizarás tu estadía profesional. 
                                Una vez solicitada, pasará por un proceso de revisión y aprobación antes de ser generada.
                            </p>
                        </div>
                    </div>
                </div>

                @if($estadia->proyecto && $estadia->area_empresa)
                <form action="{{ route('student.carta-presentacion.procesar') }}" method="POST">
                    @csrf
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-700 mb-2">¿Deseas solicitar tu carta de presentación?</p>
                            <p class="text-sm text-gray-500">Esta acción iniciará el proceso de generación de tu carta de presentación.</p>
                        </div>
                        
                        <div class="flex space-x-3">
                            <a href="{{ route('student.carta-presentacion') }}" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                Cancelar
                            </a>
                            <button type="submit" class="px-6 py-2 bg-uth-green text-white rounded-lg hover:bg-uth-green/90 transition-colors">
                                Solicitar Carta
                            </button>
                        </div>
                    </div>
                </form>
                @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <p class="text-gray-600 mb-4">No puedes solicitar la carta de presentación hasta completar la información del proyecto y área.</p>
                    <a href="{{ route('student.estadia.editar-proyecto') }}" 
                       class="inline-flex items-center px-6 py-2 bg-uth-green text-white rounded-lg hover:bg-uth-green/90 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Completar Información
                    </a>
                </div>
                @endif
            </div>
@endsection