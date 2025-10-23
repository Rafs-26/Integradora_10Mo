@extends('layouts.app')

@section('title', 'Mis Citas - Sistema de Estadías UTH')
@section('page-title', 'Mis Citas')

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
            Carta de Presentación
        </a>
        <a href="{{ route('student.perfil') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            Mi Perfil
        </a>
    </div>
@endsection

@section('content')
<div class="p-6">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Agendar Nueva Cita -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900 mb-2">Agendar Nueva Cita</h2>
            <p class="text-gray-600">Solicita una cita con tu supervisor académico o empresarial</p>
        </div>
        <div class="p-6">
            <form action="{{ route('student.citas.agendar') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="tipo_cita" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Cita</label>
                        <select name="tipo_cita" id="tipo_cita" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-uth-green focus:border-uth-green">
                            <option value="">Seleccionar tipo</option>
                            <option value="asesoria_academica">Asesoría Académica</option>
                            <option value="supervision_empresarial">Supervisión Empresarial</option>
                            <option value="revision_documentos">Revisión de Documentos</option>
                            <option value="seguimiento_estadia">Seguimiento de Estadía</option>
                            <option value="evaluacion">Evaluación</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tutor Asignado</label>
                        @if($tutorAsignado)
                            <div class="w-full px-3 py-2 border border-gray-200 rounded-lg bg-gray-50">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-uth-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $tutorAsignado->user->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $tutorAsignado->departamento ?? 'Departamento no especificado' }}</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="w-full px-3 py-2 border border-red-200 rounded-lg bg-red-50">
                                <p class="text-red-600 text-sm">No tienes un tutor asignado. Contacta al administrador.</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="fecha_solicitada" class="block text-sm font-medium text-gray-700 mb-2">Fecha Solicitada</label>
                        <input type="date" name="fecha_solicitada" id="fecha_solicitada" required min="{{ date('Y-m-d') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-uth-green focus:border-uth-green">
                    </div>
                    <div>
                        <label for="hora_solicitada" class="block text-sm font-medium text-gray-700 mb-2">Hora Solicitada</label>
                        <input type="time" name="hora_solicitada" id="hora_solicitada" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-uth-green focus:border-uth-green">
                    </div>
                </div>
                <div>
                    <label for="motivo" class="block text-sm font-medium text-gray-700 mb-2">Motivo de la Cita</label>
                    <textarea name="motivo" id="motivo" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-uth-green focus:border-uth-green" placeholder="Describe el motivo de tu cita..."></textarea>
                </div>
                <div>
                    <label for="modalidad" class="block text-sm font-medium text-gray-700 mb-2">Modalidad</label>
                    <div class="flex space-x-4">
                        <label class="flex items-center">
                            <input type="radio" name="modalidad" value="presencial" class="text-uth-green focus:ring-uth-green" checked>
                            <span class="ml-2 text-sm text-gray-700">Presencial</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="modalidad" value="virtual" class="text-uth-green focus:ring-uth-green">
                            <span class="ml-2 text-sm text-gray-700">Virtual</span>
                        </label>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-uth-green text-white text-sm font-medium rounded-lg hover:bg-uth-green/90 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-8 0v10a2 2 0 002 2h4a2 2 0 002-2V7m-8 0V6a2 2 0 012-2h4a2 2 0 012 2v1"></path>
                        </svg>
                        Solicitar Cita
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Próximas Citas -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900 mb-2">Próximas Citas</h2>
            <p class="text-gray-600">Citas confirmadas y pendientes</p>
        </div>
        <div class="p-6">
            @php
                            $proximasCitas = $citas->where('fecha', '>=', now())->where('status', '!=', 'cancelada')->sortBy('fecha');
            @endphp
            @if($proximasCitas->count() > 0)
                <div class="space-y-4">
                    @foreach($proximasCitas as $cita)
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-uth-green transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <div class="w-3 h-3 rounded-full mr-3 
                                    @if($cita->status == 'confirmada') bg-green-400
                                    @elseif($cita->status == 'programada') bg-yellow-400
                                    @else bg-gray-400 @endif"></div>
                                        <h3 class="text-lg font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $cita->titulo)) }}</h3>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($cita->status == 'confirmada') bg-green-100 text-green-800
                                    @elseif($cita->status == 'programada') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($cita->status) }}
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-8 0v10a2 2 0 002 2h4a2 2 0 002-2V7m-8 0V6a2 2 0 012-2h4a2 2 0 012 2v1"></path>
                                            </svg>
                                            {{ $cita->fecha->format('d/m/Y') }} {{ $cita->hora_inicio }}
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            {{ $cita->tutor->user->name ?? 'Sin asignar' }}
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ ucfirst($cita->modalidad) }}
                                        </div>
                                    </div>
                                    @if($cita->motivo)
                                        <p class="mt-2 text-sm text-gray-600">{{ $cita->motivo }}</p>
                                    @endif
                                    @if($cita->observaciones)
                                        <div class="mt-2 p-2 bg-blue-50 rounded text-sm text-blue-800">
                                            <strong>Observaciones:</strong> {{ $cita->observaciones }}
                                        </div>
                                    @endif
                                </div>
                                @if($cita->status == 'programada')
                                    <div class="ml-4">
                                        <form action="{{ route('student.citas.cancelar', $cita->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm" onclick="return confirm('¿Estás seguro de cancelar esta cita?')">
                                                Cancelar
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-8 0v10a2 2 0 002 2h4a2 2 0 002-2V7m-8 0V6a2 2 0 012-2h4a2 2 0 012 2v1"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No tienes citas próximas</h3>
                    <p class="text-gray-600">Agenda una nueva cita usando el formulario de arriba.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Historial de Citas -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900 mb-2">Historial de Citas</h2>
            <p class="text-gray-600">Todas tus citas anteriores</p>
        </div>
        <div class="overflow-x-auto">
            @php
                            $historialCitas = $citas->where('fecha', '<', now())->sortByDesc('fecha');
            @endphp
            @if($historialCitas->count() > 0)
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Supervisor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Modalidad</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($historialCitas as $cita)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $cita->fecha->format('d/m/Y') }} {{ $cita->hora_inicio }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ ucfirst(str_replace('_', ' ', $cita->titulo)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $cita->tutor->user->name ?? 'Sin asignar' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($cita->status == 'completada') bg-green-100 text-green-800
                                    @elseif($cita->status == 'cancelada') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($cita->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ ucfirst($cita->modalidad) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-8 0v10a2 2 0 002 2h4a2 2 0 002-2V7m-8 0V6a2 2 0 012-2h4a2 2 0 012 2v1"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No tienes historial de citas</h3>
                    <p class="text-gray-600">Tus citas completadas aparecerán aquí.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection