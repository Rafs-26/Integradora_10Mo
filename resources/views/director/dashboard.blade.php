@extends('layouts.director')

@section('title', 'Dashboard Director - Sistema de Estadías UTH')

@section('content')
    <!-- Welcome Section -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-uth-green to-uth-green-light rounded-2xl p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">¡Bienvenido, Director!</h1>
                    <p class="text-lg opacity-90">Panel de Coordinación de Estadías</p>
                    <p class="text-sm opacity-75 mt-2">Universidad Tecnológica de Huejotzingo</p>
                </div>
                <div class="hidden md:block">
                    <img src="{{ asset('img/logo_uth_2024.png') }}" alt="UTH Logo" class="h-20 w-auto opacity-80">
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Estadías Activas -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Estadías Activas</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['estadias_activas'] }}</p>
                    <p class="text-sm text-green-600 mt-1">En progreso</p>
                </div>
                <div class="w-12 h-12 bg-uth-green/10 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-uth-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Estudiantes Asignados -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Estudiantes</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['estudiantes_asignados'] }}</p>
                    <p class="text-sm text-blue-600 mt-1">Bajo supervisión</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Documentos Pendientes -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Docs. Pendientes</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['documentos_pendientes'] }}</p>
                    <p class="text-sm text-yellow-600 mt-1">Por revisar</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Empresas Colaboradoras -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Empresas</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['empresas_colaboradoras'] }}</p>
                    <p class="text-sm text-purple-600 mt-1">Colaboradoras</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Estadías Recientes -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Estadías Recientes</h3>
                        <a href="#" class="text-sm text-uth-green hover:text-uth-green-dark font-medium">Ver todas</a>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($estadiasRecientes as $estadia)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 bg-uth-green rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold text-sm">
                                        {{ strtoupper(substr($estadia->estudiante->user->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $estadia->estudiante->user->name)[1] ?? '', 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $estadia->estudiante->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $estadia->estudiante->carrera->nombre ?? 'Sin carrera' }} - {{ $estadia->empresa->nombre }}</p>
                                    <p class="text-xs text-gray-400">Iniciada: {{ $estadia->fecha_inicio ? \Carbon\Carbon::parse($estadia->fecha_inicio)->format('d M Y') : 'Sin fecha' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                @if($estadia->status === 'activa')
                                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Activa</span>
                                @elseif($estadia->status === 'pendiente')
                                    <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Pendiente</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">{{ ucfirst($estadia->status) }}</span>
                                @endif
                                <button class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <p class="text-gray-500">No hay estadías recientes</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Content -->
        <div class="space-y-6">
            <!-- Tareas Pendientes -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Tareas Pendientes</h3>
                </div>
                <div class="p-6 space-y-3">
                    <div class="flex items-center space-x-3 p-3 bg-red-50 rounded-lg">
                        <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Revisar documentos</p>
                            <p class="text-xs text-gray-500">12 documentos pendientes</p>
                        </div>
                        <span class="text-xs text-red-600 font-medium">Urgente</span>
                    </div>
                    
                    <div class="flex items-center space-x-3 p-3 bg-yellow-50 rounded-lg">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Asignar supervisores</p>
                            <p class="text-xs text-gray-500">5 estudiantes sin asignar</p>
                        </div>
                        <span class="text-xs text-yellow-600 font-medium">Media</span>
                    </div>
                    
                    <div class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg">
                        <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Generar reportes</p>
                            <p class="text-xs text-gray-500">Reporte mensual</p>
                        </div>
                        <span class="text-xs text-blue-600 font-medium">Baja</span>
                    </div>
                </div>
            </div>

            <!-- Calendario de Eventos -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Próximos Eventos</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-12 h-12 bg-uth-green/10 rounded-lg flex flex-col items-center justify-center">
                            <span class="text-xs text-uth-green font-medium">ENE</span>
                            <span class="text-sm font-bold text-uth-green">25</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Reunión de seguimiento</p>
                            <p class="text-xs text-gray-500">Evaluación de estadías Q1</p>
                            <p class="text-xs text-gray-400">10:00 AM - Sala de juntas</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-3">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex flex-col items-center justify-center">
                            <span class="text-xs text-blue-600 font-medium">ENE</span>
                            <span class="text-sm font-bold text-blue-600">28</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Visita empresarial</p>
                            <p class="text-xs text-gray-500">TechCorp - Supervisión</p>
                            <p class="text-xs text-gray-400">2:00 PM - Oficinas TechCorp</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-3">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex flex-col items-center justify-center">
                            <span class="text-xs text-purple-600 font-medium">FEB</span>
                            <span class="text-sm font-bold text-purple-600">02</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Presentaciones finales</p>
                            <p class="text-xs text-gray-500">Grupo A - Estadías</p>
                            <p class="text-xs text-gray-400">9:00 AM - Auditorio</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Scripts específicos para el dashboard del director
        console.log('Dashboard de Director cargado');
</script>
@endpush