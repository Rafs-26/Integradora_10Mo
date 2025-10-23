@extends('layouts.app')

@section('title', 'Editar Proyecto y Área')
@section('page-title', 'Editar Proyecto y Área')

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
        <a href="{{ route('student.documentos') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Documentos
        </a>
    </div>
    
    <!-- Solicitar Carta de Presentación -->
    <a href="{{ route('student.carta-presentacion') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-2">
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
            <!-- Información Actual -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Información Actual de tu Estadía</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Empresa:</p>
                        <p class="font-medium text-gray-800">{{ $estadia->empresa->nombre ?? 'No asignada' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Estado:</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($estadia->status == 'en_proceso') bg-green-100 text-green-800
                            @elseif($estadia->status == 'documentos_pendientes') bg-yellow-100 text-yellow-800
                            @elseif($estadia->status == 'documentos_completos') bg-blue-100 text-blue-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst(str_replace('_', ' ', $estadia->status)) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Formulario de Edición -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Actualizar Proyecto y Área</h2>
                
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm font-medium text-blue-800 mb-1">Información Importante</h3>
                            <p class="text-sm text-blue-700">
                                Es necesario que especifiques el proyecto y área donde realizarás tu estadía antes de solicitar la carta de presentación. 
                                Esta información aparecerá en tu carta oficial.
                            </p>
                        </div>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="text-sm font-medium text-red-800 mb-1">Errores de validación</h3>
                                <ul class="text-sm text-red-700 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('student.estadia.actualizar-proyecto') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        <div>
                            <label for="proyecto" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre del Proyecto *
                            </label>
                            <input type="text" 
                                   id="proyecto" 
                                   name="proyecto" 
                                   value="{{ old('proyecto', $estadia->proyecto) }}"
                                   maxlength="200"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-uth-green focus:border-transparent"
                                   placeholder="Ej: Desarrollo de Sistema de Gestión de Inventarios">
                            <p class="text-xs text-gray-500 mt-1">Máximo 200 caracteres</p>
                        </div>

                        <div>
                            <label for="area_empresa" class="block text-sm font-medium text-gray-700 mb-2">
                                Área de la Empresa *
                            </label>
                            <input type="text" 
                                   id="area_empresa" 
                                   name="area_empresa" 
                                   value="{{ old('area_empresa', $estadia->area_empresa) }}"
                                   maxlength="100"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-uth-green focus:border-transparent"
                                   placeholder="Ej: Tecnologías de la Información, Recursos Humanos, Desarrollo">
                            <p class="text-xs text-gray-500 mt-1">Máximo 100 caracteres</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between mt-8">
                        <a href="{{ route('student.carta-presentacion') }}" 
                           class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                            Cancelar
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-uth-green text-white rounded-lg hover:bg-uth-green/90 transition-colors">
                            Actualizar Información
                        </button>
                    </div>
                </form>
            </div>
@endsection