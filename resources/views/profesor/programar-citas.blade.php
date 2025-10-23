@extends('layouts.app')

@section('title', 'Programar Citas - Dashboard Profesor')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Programar Citas</h1>
                    <p class="mt-1 text-sm text-gray-600">Gestiona citas y reuniones con estudiantes</p>
                </div>
                <div class="flex items-center space-x-4">
                    <button onclick="nuevaCita()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-uth-green hover:bg-uth-green-dark">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Nueva Cita
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1M8 7h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Citas Este Mes</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $citas_mes ?? 0 }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Completadas</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $citas_completadas ?? 0 }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Pendientes</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $citas_pendientes ?? 0 }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Canceladas</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $citas_canceladas ?? 0 }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Calendario -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900">Calendario de Citas</h3>
                            <div class="flex items-center space-x-2">
                                <button onclick="cambiarMes(-1)" class="p-2 text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </button>
                                <span class="text-lg font-medium text-gray-900" id="mes-actual">{{ date('F Y') }}</span>
                                <button onclick="cambiarMes(1)" class="p-2 text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div id="calendario" class="grid grid-cols-7 gap-1">
                            <!-- Días de la semana -->
                            <div class="text-center text-sm font-medium text-gray-500 py-2">Dom</div>
                            <div class="text-center text-sm font-medium text-gray-500 py-2">Lun</div>
                            <div class="text-center text-sm font-medium text-gray-500 py-2">Mar</div>
                            <div class="text-center text-sm font-medium text-gray-500 py-2">Mié</div>
                            <div class="text-center text-sm font-medium text-gray-500 py-2">Jue</div>
                            <div class="text-center text-sm font-medium text-gray-500 py-2">Vie</div>
                            <div class="text-center text-sm font-medium text-gray-500 py-2">Sáb</div>
                            
                            <!-- Días del mes se generarán dinámicamente -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de Citas -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900">Próximas Citas</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ count($proximas_citas ?? []) }}
                            </span>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-200 max-h-96 overflow-y-auto">
                        @forelse($proximas_citas ?? [] as $cita)
                            <div class="px-6 py-4 hover:bg-gray-50">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-2">
                                            <div class="w-2 h-2 rounded-full {{ $cita['estado'] == 'programada' ? 'bg-blue-400' : ($cita['estado'] == 'completada' ? 'bg-green-400' : 'bg-red-400') }}"></div>
                                            <h4 class="text-sm font-medium text-gray-900">{{ $cita['titulo'] }}</h4>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-1">{{ $cita['estudiante_nombre'] }}</p>
                                        <div class="flex items-center text-xs text-gray-500 space-x-4">
                                            <span class="flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1M8 7h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2"></path>
                                                </svg>
                                                {{ $cita['fecha'] }}
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $cita['hora'] }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex flex-col space-y-1">
                                        <button onclick="verCita({{ $cita['id'] }})" class="text-xs text-blue-600 hover:text-blue-800">
                                            Ver
                                        </button>
                                        @if($cita['estado'] == 'programada')
                                            <button onclick="editarCita({{ $cita['id'] }})" class="text-xs text-gray-600 hover:text-gray-800">
                                                Editar
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-8 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1M8 7h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2"></path>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">No hay citas programadas</p>
                                <button onclick="nuevaCita()" class="mt-2 text-sm text-uth-green hover:text-uth-green-dark">
                                    Programar primera cita
                                </button>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Horarios Disponibles -->
                <div class="bg-white rounded-lg shadow mt-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Horarios Disponibles</h3>
                        <p class="text-sm text-gray-600">Configura tus horarios de atención</p>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Lunes - Viernes</span>
                                <span class="text-gray-900 font-medium">9:00 AM - 5:00 PM</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Duración por cita</span>
                                <span class="text-gray-900 font-medium">30 minutos</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Descanso entre citas</span>
                                <span class="text-gray-900 font-medium">15 minutos</span>
                            </div>
                        </div>
                        <button onclick="configurarHorarios()" class="mt-4 w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Configurar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Nueva Cita -->
<div id="modal-nueva-cita" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-center mx-auto w-12 h-12 rounded-full bg-blue-100">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1M8 7h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 text-center mt-4">Programar Nueva Cita</h3>
            <form id="form-nueva-cita" method="POST" action="{{ route('teacher.citas.crear') }}">
                @csrf
                <div class="mt-4 space-y-4">
                    <div>
                        <label for="estudiante_cita" class="block text-sm font-medium text-gray-700 mb-2">Estudiante *</label>
                        <select name="estudiante_id" id="estudiante_cita" required 
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green">
                            <option value="">Seleccionar estudiante</option>
                            @foreach($estudiantes ?? [] as $estudiante)
                                <option value="{{ $estudiante->id }}" {{ request('estudiante') == $estudiante->id ? 'selected' : '' }}>
                                    {{ $estudiante->nombre }} {{ $estudiante->apellidos }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="titulo_cita" class="block text-sm font-medium text-gray-700 mb-2">Título *</label>
                        <input type="text" name="titulo" id="titulo_cita" required 
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green"
                               placeholder="Ej: Revisión de avances">
                    </div>
                    
                    <div>
                        <label for="fecha_cita" class="block text-sm font-medium text-gray-700 mb-2">Fecha *</label>
                        <input type="date" name="fecha" id="fecha_cita" required 
                               min="{{ date('Y-m-d') }}"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green">
                    </div>
                    
                    <div>
                        <label for="hora_cita" class="block text-sm font-medium text-gray-700 mb-2">Hora *</label>
                        <select name="hora" id="hora_cita" required 
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green">
                            <option value="">Seleccionar hora</option>
                            <option value="09:00">9:00 AM</option>
                            <option value="09:30">9:30 AM</option>
                            <option value="10:00">10:00 AM</option>
                            <option value="10:30">10:30 AM</option>
                            <option value="11:00">11:00 AM</option>
                            <option value="11:30">11:30 AM</option>
                            <option value="12:00">12:00 PM</option>
                            <option value="12:30">12:30 PM</option>
                            <option value="13:00">1:00 PM</option>
                            <option value="13:30">1:30 PM</option>
                            <option value="14:00">2:00 PM</option>
                            <option value="14:30">2:30 PM</option>
                            <option value="15:00">3:00 PM</option>
                            <option value="15:30">3:30 PM</option>
                            <option value="16:00">4:00 PM</option>
                            <option value="16:30">4:30 PM</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="modalidad" class="block text-sm font-medium text-gray-700 mb-2">Modalidad *</label>
                        <select name="modalidad" id="modalidad" required 
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green">
                            <option value="presencial">Presencial</option>
                            <option value="virtual">Virtual</option>
                            <option value="telefonica">Telefónica</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="ubicacion" class="block text-sm font-medium text-gray-700 mb-2">Ubicación/Enlace</label>
                        <input type="text" name="ubicacion" id="ubicacion" 
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green"
                               placeholder="Oficina 201 o enlace de videollamada">
                    </div>
                    
                    <div>
                        <label for="descripcion_cita" class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                        <textarea name="descripcion" id="descripcion_cita" rows="3" 
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green"
                                  placeholder="Temas a tratar en la cita..."></textarea>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="cerrarModal('modal-nueva-cita')" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-uth-green text-white rounded-md hover:bg-uth-green-dark">
                        Programar Cita
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Ver/Editar Cita -->
<div id="modal-ver-cita" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-center mx-auto w-12 h-12 rounded-full bg-green-100">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 text-center mt-4">Detalles de la Cita</h3>
            <div id="contenido-cita" class="mt-4">
                <!-- Contenido se carga dinámicamente -->
            </div>
            
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="cerrarModal('modal-ver-cita')" 
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                    Cerrar
                </button>
                <button id="btn-completar-cita" onclick="completarCita()" 
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 hidden">
                    Marcar como Completada
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let fechaActual = new Date();
    let citaActual = null;
    
    function nuevaCita() {
        document.getElementById('modal-nueva-cita').classList.remove('hidden');
    }
    
    function verCita(citaId) {
        citaActual = citaId;
        
        // Simular carga de datos de la cita
        const contenido = document.getElementById('contenido-cita');
        contenido.innerHTML = `
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Estudiante:</span>
                    <span class="text-sm text-gray-900">Juan Pérez García</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Fecha:</span>
                    <span class="text-sm text-gray-900">15 de Diciembre, 2024</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Hora:</span>
                    <span class="text-sm text-gray-900">10:00 AM</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Modalidad:</span>
                    <span class="text-sm text-gray-900">Presencial</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Ubicación:</span>
                    <span class="text-sm text-gray-900">Oficina 201</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Estado:</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Programada</span>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500">Descripción:</span>
                    <p class="text-sm text-gray-900 mt-1">Revisión de avances del proyecto de estadías y resolución de dudas sobre la documentación pendiente.</p>
                </div>
            </div>
        `;
        
        // Mostrar botón de completar si la cita está programada
        document.getElementById('btn-completar-cita').classList.remove('hidden');
        
        document.getElementById('modal-ver-cita').classList.remove('hidden');
    }
    
    function editarCita(citaId) {
        // Cargar datos de la cita en el formulario de edición
        // Por ahora, simplemente abrir el modal de nueva cita con datos precargados
        nuevaCita();
    }
    
    function completarCita() {
        if (!citaActual) return;
        
        if (confirm('¿Estás seguro de marcar esta cita como completada?')) {
            // Enviar petición para completar la cita
            fetch(`/teacher/citas/${citaActual}/completar`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Cita marcada como completada');
                    location.reload();
                } else {
                    alert('Error al completar la cita');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al completar la cita');
            });
        }
    }
    
    function configurarHorarios() {
        alert('Funcionalidad de configuración de horarios en desarrollo');
    }
    
    function cambiarMes(direccion) {
        fechaActual.setMonth(fechaActual.getMonth() + direccion);
        actualizarCalendario();
    }
    
    function actualizarCalendario() {
        const meses = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];
        
        document.getElementById('mes-actual').textContent = 
            `${meses[fechaActual.getMonth()]} ${fechaActual.getFullYear()}`;
        
        generarDiasCalendario();
    }
    
    function generarDiasCalendario() {
        const calendario = document.getElementById('calendario');
        const diasSemana = calendario.querySelectorAll('div:nth-child(-n+7)');
        
        // Limpiar días anteriores
        const diasAnteriores = calendario.querySelectorAll('div:nth-child(n+8)');
        diasAnteriores.forEach(dia => dia.remove());
        
        const primerDia = new Date(fechaActual.getFullYear(), fechaActual.getMonth(), 1);
        const ultimoDia = new Date(fechaActual.getFullYear(), fechaActual.getMonth() + 1, 0);
        const diasEnMes = ultimoDia.getDate();
        const diaSemanaInicio = primerDia.getDay();
        
        // Días vacíos al inicio
        for (let i = 0; i < diaSemanaInicio; i++) {
            const diaVacio = document.createElement('div');
            diaVacio.className = 'h-12';
            calendario.appendChild(diaVacio);
        }
        
        // Días del mes
        for (let dia = 1; dia <= diasEnMes; dia++) {
            const diaElemento = document.createElement('div');
            diaElemento.className = 'h-12 flex items-center justify-center text-sm cursor-pointer hover:bg-gray-100 rounded-md relative';
            diaElemento.textContent = dia;
            
            // Marcar día actual
            const hoy = new Date();
            if (fechaActual.getFullYear() === hoy.getFullYear() && 
                fechaActual.getMonth() === hoy.getMonth() && 
                dia === hoy.getDate()) {
                diaElemento.classList.add('bg-uth-green', 'text-white', 'font-medium');
            }
            
            // Agregar indicador de citas (simulado)
            if (Math.random() > 0.8) {
                const indicador = document.createElement('div');
                indicador.className = 'absolute bottom-1 left-1/2 transform -translate-x-1/2 w-1 h-1 bg-blue-500 rounded-full';
                diaElemento.appendChild(indicador);
            }
            
            diaElemento.onclick = () => seleccionarFecha(dia);
            calendario.appendChild(diaElemento);
        }
    }
    
    function seleccionarFecha(dia) {
        const fecha = new Date(fechaActual.getFullYear(), fechaActual.getMonth(), dia);
        const fechaFormateada = fecha.toISOString().split('T')[0];
        
        document.getElementById('fecha_cita').value = fechaFormateada;
        nuevaCita();
    }
    
    function cerrarModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
    
    // Cerrar modal al hacer clic fuera
    window.onclick = function(event) {
        const modalNueva = document.getElementById('modal-nueva-cita');
        const modalVer = document.getElementById('modal-ver-cita');
        
        if (event.target === modalNueva) {
            modalNueva.classList.add('hidden');
        }
        if (event.target === modalVer) {
            modalVer.classList.add('hidden');
        }
    }
    
    // Inicializar calendario
    document.addEventListener('DOMContentLoaded', function() {
        actualizarCalendario();
    });
    
    console.log('Vista Programar Citas cargada');
</script>
@endpush