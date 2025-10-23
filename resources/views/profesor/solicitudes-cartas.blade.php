@extends('layouts.app')

@section('title', 'Solicitudes de Cartas - Sistema de Estadías UTH')
@section('page-title', 'Solicitudes de Cartas de Presentación')

@section('sidebar-menu')
    <!-- Dashboard -->
    <a href="{{ route('teacher.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-2">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
        </svg>
        Inicio
    </a>
    
    <!-- Mis Estudiantes -->
    <div class="mb-4">
        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Supervisión</h3>
        <a href="{{ route('teacher.mis-estudiantes') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            Mis Estudiantes
        </a>
        <a href="{{ route('teacher.solicitudes-cartas') }}" class="flex items-center px-4 py-3 text-uth-green bg-uth-green/10 rounded-lg mb-1">
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
        <a href="{{ route('teacher.evaluaciones') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1">
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
    <!-- Header Section -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-uth-green to-uth-green-light rounded-2xl p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Solicitudes de Cartas de Presentación</h1>
                    <p class="text-lg opacity-90">Gestión de Solicitudes Estudiantiles</p>
                    <p class="text-sm opacity-75 mt-2">Revisa y aprueba las solicitudes de cartas de presentación</p>
                </div>
                <div class="text-right">
                    <div class="bg-white/20 rounded-lg p-4">
                        <div class="text-2xl font-bold">{{ $solicitudes->count() }}</div>
                        <div class="text-sm opacity-90">Pendientes</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Solicitudes Pendientes</h2>
                    <p class="text-sm text-gray-600 mt-1">Revisa y gestiona las solicitudes de tus estudiantes</p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-100 text-amber-800">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $solicitudes->count() }} pendientes
                    </span>
                </div>
            </div>
        </div>
        <div class="p-6">
                            @if($solicitudes->count() > 0)
                                <div class="space-y-6">
                                    @foreach($solicitudes as $solicitud)
                                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 hover:shadow-md transition-shadow duration-200">
                                            <div class="flex items-start justify-between mb-4">
                                                <div class="flex items-center space-x-4">
                                                    <div class="w-12 h-12 bg-uth-green rounded-full flex items-center justify-center text-white font-semibold text-lg">
                                                        {{ substr($solicitud->estudiante->user->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <h3 class="text-lg font-semibold text-gray-900">{{ $solicitud->estudiante->user->name }}</h3>
                                                        <p class="text-sm text-gray-600">{{ $solicitud->estudiante->user->email }}</p>
                                                        <p class="text-sm text-gray-500 mt-1">
                                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                            </svg>
                                                            {{ $solicitud->estadia->empresa->nombre ?? 'Sin empresa asignada' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-100 text-amber-800">
                                                        Pendiente
                                                    </span>
                                                    <p class="text-xs text-gray-500 mt-2">
                                                        {{ $solicitud->fecha_solicitud->format('d/m/Y H:i') }}
                                                    </p>
                                                </div>
                                            </div>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                                <div class="bg-white rounded-lg p-4 border border-gray-100">
                                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Dirigida a:</h4>
                                                    <p class="text-gray-900 font-medium">{{ $solicitud->dirigida_a }}</p>
                                                    @if($solicitud->cargo_destinatario)
                                                        <p class="text-sm text-gray-600">{{ $solicitud->cargo_destinatario }}</p>
                                                    @endif
                                                </div>
                                                <div class="bg-white rounded-lg p-4 border border-gray-100">
                                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Propósito:</h4>
                                                    <p class="text-gray-900 text-sm leading-relaxed">{{ Str::limit($solicitud->proposito, 100) }}</p>
                                                </div>
                                            </div>
                                            
                                            <div class="flex items-center justify-end space-x-3" x-data="{ verModal: false, aprobarModal: false, rechazarModal: false }">
                                                <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-uth-green transition-colors duration-200" @click="verModal = true">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    Ver Detalles
                                                </button>
                                                <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200" @click="aprobarModal = true">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Aprobar
                                                </button>
                                                <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200" @click="rechazarModal = true">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    Rechazar
                                                </button>
                                                
                                                <!-- Modal Ver Solicitud -->
                                                <div x-show="verModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                                                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                                        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="verModal = false"></div>
                                                        <div class="inline-block w-full max-w-2xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                                                            <div class="flex items-center justify-between mb-4">
                                                                <h3 class="text-lg font-semibold text-gray-900">Detalles de la Solicitud</h3>
                                                                <button @click="verModal = false" class="text-gray-400 hover:text-gray-600">
                                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                                                <div>
                                                                    <h6 class="font-semibold text-gray-900 mb-2">Información del Estudiante</h6>
                                                                    <p class="text-sm text-gray-600 mb-1"><strong>Nombre:</strong> {{ $solicitud->estudiante->user->name }}</p>
                                                                    <p class="text-sm text-gray-600 mb-1"><strong>Email:</strong> {{ $solicitud->estudiante->user->email }}</p>
                                                                    <p class="text-sm text-gray-600"><strong>Carrera:</strong> {{ $solicitud->estudiante->carrera->nombre ?? 'No especificada' }}</p>
                                                                </div>
                                                                <div>
                                                                    <h6 class="font-semibold text-gray-900 mb-2">Información de la Empresa</h6>
                                                                    <p class="text-sm text-gray-600 mb-1"><strong>Empresa:</strong> {{ $solicitud->estadia->empresa->nombre ?? 'Sin empresa asignada' }}</p>
                                                                    <p class="text-sm text-gray-600"><strong>Proyecto:</strong> {{ $solicitud->estadia->nombre_proyecto ?? 'No especificado' }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="border-t pt-4">
                                                                <h6 class="font-semibold text-gray-900 mb-2">Detalles de la Carta</h6>
                                                                <p class="text-sm text-gray-600 mb-2"><strong>Dirigida a:</strong> {{ $solicitud->dirigida_a }}</p>
                                                                @if($solicitud->cargo_destinatario)
                                                                    <p class="text-sm text-gray-600 mb-2"><strong>Cargo:</strong> {{ $solicitud->cargo_destinatario }}</p>
                                                                @endif
                                                                <p class="text-sm text-gray-600 mb-2"><strong>Propósito:</strong></p>
                                                                <p class="text-sm text-gray-800 bg-gray-50 p-3 rounded-lg mb-2">{{ $solicitud->proposito }}</p>
                                                                @if($solicitud->observaciones)
                                                                    <p class="text-sm text-gray-600 mb-2"><strong>Observaciones:</strong></p>
                                                                    <p class="text-sm text-gray-800 bg-gray-50 p-3 rounded-lg">{{ $solicitud->observaciones }}</p>
                                                                @endif
                                                            </div>
                                                            <div class="flex justify-end mt-6">
                                                                <button @click="verModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500">Cerrar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Modal Aprobar -->
                                                <div x-show="aprobarModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                                                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                                        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="aprobarModal = false"></div>
                                                        <div class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                                                            <form method="POST" action="{{ route('teacher.solicitudes-cartas.aprobar', $solicitud->id) }}">
                                                                @csrf
                                                                <div class="flex items-center justify-between mb-4">
                                                                    <h3 class="text-lg font-semibold text-gray-900">Aprobar Solicitud</h3>
                                                                    <button type="button" @click="aprobarModal = false" class="text-gray-400 hover:text-gray-600">
                                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                                <div class="mb-4">
                                                                    <p class="text-sm text-gray-600 mb-3">¿Está seguro de que desea aprobar la solicitud de carta de presentación de <strong>{{ $solicitud->estudiante->user->name }}</strong>?</p>
                                                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                                                                        <div class="flex items-center">
                                                                            <svg class="w-5 h-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                                                            </svg>
                                                                            <p class="text-sm text-blue-700">Una vez aprobada, la solicitud será enviada al director para su aprobación final.</p>
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <label for="comentarios" class="block text-sm font-medium text-gray-700 mb-2">Comentarios (opcional):</label>
                                                                        <textarea name="comentarios" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-uth-green focus:border-transparent" placeholder="Agregue comentarios sobre la aprobación..."></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="flex justify-end space-x-3">
                                                                    <button type="button" @click="aprobarModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500">Cancelar</button>
                                                                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">Aprobar Solicitud</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Modal Rechazar -->
                                                <div x-show="rechazarModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                                                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                                        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="rechazarModal = false"></div>
                                                        <div class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                                                            <form method="POST" action="{{ route('teacher.solicitudes-cartas.rechazar', $solicitud->id) }}">
                                                                @csrf
                                                                <div class="flex items-center justify-between mb-4">
                                                                    <h3 class="text-lg font-semibold text-gray-900">Rechazar Solicitud</h3>
                                                                    <button type="button" @click="rechazarModal = false" class="text-gray-400 hover:text-gray-600">
                                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                                <div class="mb-4">
                                                                    <p class="text-sm text-gray-600 mb-3">¿Está seguro de que desea rechazar la solicitud de carta de presentación de <strong>{{ $solicitud->estudiante->user->name }}</strong>?</p>
                                                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                                                                        <div class="flex items-center">
                                                                            <svg class="w-5 h-5 text-yellow-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                                            </svg>
                                                                            <p class="text-sm text-yellow-700">El estudiante será notificado del rechazo.</p>
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <label for="comentarios" class="block text-sm font-medium text-gray-700 mb-2">Motivo del rechazo <span class="text-red-500">*</span>:</label>
                                                                        <textarea name="comentarios" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-uth-green focus:border-transparent" placeholder="Explique el motivo del rechazo..."></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="flex justify-end space-x-3">
                                                                    <button type="button" @click="rechazarModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500">Cancelar</button>
                                                                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">Rechazar Solicitud</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-16">
                                    <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 009.586 13H7"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No hay solicitudes pendientes</h3>
                                    <p class="text-gray-600 max-w-md mx-auto">Todas las solicitudes de cartas de presentación han sido procesadas. Cuando los estudiantes envíen nuevas solicitudes, aparecerán aquí para su revisión.</p>
                                    <div class="mt-8">
                                        <a href="{{ route('teacher.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-uth-green hover:bg-uth-green-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-uth-green transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                            </svg>
                                            Volver al Dashboard
                                        </a>
                                    </div>
                                </div>
                            @endif
        </div>
    </div>


@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
});
</script>
@endsection