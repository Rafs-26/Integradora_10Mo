@extends('layouts.app')

@section('title', 'Mensajes - Dashboard Profesor')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Mensajes</h1>
                    <p class="mt-1 text-sm text-gray-600">Gestión de mensajes con estudiantes supervisados</p>
                </div>
                <div class="flex items-center space-x-4">
                    <button onclick="nuevoMensaje()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-uth-green hover:bg-uth-green-dark">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Nuevo Mensaje
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Lista de Conversaciones -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900">Conversaciones</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                {{ $mensajes_no_leidos ?? 0 }}
                            </span>
                        </div>
                        
                        <!-- Buscador -->
                        <div class="mt-4">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" id="buscar-conversacion" 
                                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-uth-green focus:border-uth-green text-sm"
                                       placeholder="Buscar estudiante...">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Lista de estudiantes -->
                    <div class="divide-y divide-gray-200 max-h-96 overflow-y-auto">
                        @forelse($conversaciones ?? [] as $conversacion)
                            <div class="px-6 py-4 hover:bg-gray-50 cursor-pointer conversacion-item {{ $loop->first ? 'bg-blue-50 border-r-4 border-blue-500' : '' }}" 
                                 onclick="seleccionarConversacion({{ $conversacion['estudiante_id'] }}, '{{ $conversacion['estudiante_nombre'] }}')">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-medium text-gray-700">
                                                {{ substr($conversacion['estudiante_nombre'], 0, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $conversacion['estudiante_nombre'] }}
                                            </p>
                                            @if($conversacion['no_leidos'] > 0)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    {{ $conversacion['no_leidos'] }}
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-500 truncate">
                                            {{ Str::limit($conversacion['ultimo_mensaje'], 30) }}
                                        </p>
                                        <p class="text-xs text-gray-400">
                                            {{ $conversacion['fecha_ultimo'] }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-8 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">No hay conversaciones</p>
                                <button onclick="nuevoMensaje()" class="mt-2 text-sm text-uth-green hover:text-uth-green-dark">
                                    Iniciar nueva conversación
                                </button>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Área de Chat -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-lg shadow h-full flex flex-col" style="min-height: 600px;">
                    <!-- Header del Chat -->
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between" id="chat-header">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium text-gray-700" id="chat-avatar">--</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900" id="chat-nombre">Selecciona una conversación</h3>
                                <p class="text-sm text-gray-500" id="chat-estado">--</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button onclick="programarCita()" class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1M8 7h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2"></path>
                                </svg>
                                Programar Cita
                            </button>
                            <button onclick="verPerfil()" class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Ver Perfil
                            </button>
                        </div>
                    </div>

                    <!-- Área de Mensajes -->
                    <div class="flex-1 overflow-y-auto px-6 py-4 space-y-4" id="mensajes-container">
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">Selecciona una conversación para comenzar</p>
                        </div>
                    </div>

                    <!-- Área de Escritura -->
                    <div class="border-t border-gray-200 px-6 py-4" id="area-escritura" style="display: none;">
                        <form id="form-mensaje" onsubmit="enviarMensaje(event)">
                            <div class="flex items-end space-x-3">
                                <div class="flex-1">
                                    <textarea id="mensaje-texto" rows="3" 
                                              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green resize-none"
                                              placeholder="Escribe tu mensaje..." required></textarea>
                                </div>
                                <div class="flex flex-col space-y-2">
                                    <button type="button" onclick="adjuntarArchivo()" 
                                            class="inline-flex items-center p-2 border border-gray-300 rounded-md shadow-sm text-gray-400 hover:text-gray-500 hover:bg-gray-50">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                        </svg>
                                    </button>
                                    <button type="submit" 
                                            class="inline-flex items-center p-2 border border-transparent rounded-md shadow-sm text-white bg-uth-green hover:bg-uth-green-dark">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <input type="file" id="archivo-adjunto" style="display: none;" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Nuevo Mensaje -->
<div id="modal-nuevo-mensaje" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-center mx-auto w-12 h-12 rounded-full bg-blue-100">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 text-center mt-4">Nuevo Mensaje</h3>
            <form id="form-nuevo-mensaje" method="POST" action="{{ route('teacher.mensajes.enviar') }}">
                @csrf
                <div class="mt-4 space-y-4">
                    <div>
                        <label for="estudiante_id" class="block text-sm font-medium text-gray-700 mb-2">Estudiante *</label>
                        <select name="estudiante_id" id="estudiante_id" required 
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green">
                            <option value="">Seleccionar estudiante</option>
                            @foreach($estudiantes ?? [] as $estudiante)
                                <option value="{{ $estudiante->id }}">{{ $estudiante->nombre }} {{ $estudiante->apellidos }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="asunto" class="block text-sm font-medium text-gray-700 mb-2">Asunto *</label>
                        <input type="text" name="asunto" id="asunto" required 
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green"
                               placeholder="Asunto del mensaje">
                    </div>
                    
                    <div>
                        <label for="mensaje" class="block text-sm font-medium text-gray-700 mb-2">Mensaje *</label>
                        <textarea name="mensaje" id="mensaje" rows="4" required 
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green"
                                  placeholder="Escribe tu mensaje aquí..."></textarea>
                    </div>
                    
                    <div>
                        <label for="prioridad" class="block text-sm font-medium text-gray-700 mb-2">Prioridad</label>
                        <select name="prioridad" id="prioridad" 
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green">
                            <option value="normal">Normal</option>
                            <option value="alta">Alta</option>
                            <option value="urgente">Urgente</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="cerrarModal('modal-nuevo-mensaje')" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-uth-green text-white rounded-md hover:bg-uth-green-dark">
                        Enviar Mensaje
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let conversacionActual = null;
    let mensajesInterval = null;
    
    function nuevoMensaje() {
        document.getElementById('modal-nuevo-mensaje').classList.remove('hidden');
    }
    
    function seleccionarConversacion(estudianteId, estudianteNombre) {
        conversacionActual = estudianteId;
        
        // Actualizar header del chat
        document.getElementById('chat-avatar').textContent = estudianteNombre.substring(0, 2);
        document.getElementById('chat-nombre').textContent = estudianteNombre;
        document.getElementById('chat-estado').textContent = 'En línea';
        
        // Mostrar área de escritura
        document.getElementById('area-escritura').style.display = 'block';
        
        // Marcar conversación como activa
        document.querySelectorAll('.conversacion-item').forEach(item => {
            item.classList.remove('bg-blue-50', 'border-r-4', 'border-blue-500');
        });
        event.currentTarget.classList.add('bg-blue-50', 'border-r-4', 'border-blue-500');
        
        // Cargar mensajes
        cargarMensajes(estudianteId);
        
        // Iniciar polling para nuevos mensajes
        if (mensajesInterval) {
            clearInterval(mensajesInterval);
        }
        mensajesInterval = setInterval(() => cargarMensajes(estudianteId), 5000);
    }
    
    function cargarMensajes(estudianteId) {
        fetch(`/teacher/mensajes/${estudianteId}`)
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('mensajes-container');
                container.innerHTML = '';
                
                if (data.mensajes && data.mensajes.length > 0) {
                    data.mensajes.forEach(mensaje => {
                        const mensajeDiv = document.createElement('div');
                        mensajeDiv.className = `flex ${mensaje.es_profesor ? 'justify-end' : 'justify-start'}`;
                        
                        mensajeDiv.innerHTML = `
                            <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg ${
                                mensaje.es_profesor 
                                    ? 'bg-uth-green text-white' 
                                    : 'bg-gray-200 text-gray-900'
                            }">
                                <p class="text-sm">${mensaje.contenido}</p>
                                <p class="text-xs mt-1 ${
                                    mensaje.es_profesor ? 'text-green-100' : 'text-gray-500'
                                }">
                                    ${mensaje.fecha_formateada}
                                </p>
                            </div>
                        `;
                        
                        container.appendChild(mensajeDiv);
                    });
                    
                    // Scroll al final
                    container.scrollTop = container.scrollHeight;
                } else {
                    container.innerHTML = `
                        <div class="text-center py-12">
                            <p class="text-sm text-gray-500">No hay mensajes en esta conversación</p>
                            <p class="text-xs text-gray-400 mt-1">Envía el primer mensaje para comenzar</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error cargando mensajes:', error);
            });
    }
    
    function enviarMensaje(event) {
        event.preventDefault();
        
        if (!conversacionActual) {
            alert('Selecciona una conversación primero');
            return;
        }
        
        const mensaje = document.getElementById('mensaje-texto').value.trim();
        if (!mensaje) {
            return;
        }
        
        const formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        formData.append('estudiante_id', conversacionActual);
        formData.append('mensaje', mensaje);
        
        fetch('/teacher/mensajes/enviar', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('mensaje-texto').value = '';
                cargarMensajes(conversacionActual);
            } else {
                alert('Error al enviar mensaje');
            }
        })
        .catch(error => {
            console.error('Error enviando mensaje:', error);
            alert('Error al enviar mensaje');
        });
    }
    
    function adjuntarArchivo() {
        document.getElementById('archivo-adjunto').click();
    }
    
    function programarCita() {
        if (!conversacionActual) {
            alert('Selecciona una conversación primero');
            return;
        }
        window.location.href = `/teacher/programar-citas?estudiante=${conversacionActual}`;
    }
    
    function verPerfil() {
        if (!conversacionActual) {
            alert('Selecciona una conversación primero');
            return;
        }
        window.location.href = `/teacher/mis-estudiantes/${conversacionActual}`;
    }
    
    function cerrarModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
    
    // Buscador de conversaciones
    document.getElementById('buscar-conversacion').addEventListener('input', function(e) {
        const termino = e.target.value.toLowerCase();
        const conversaciones = document.querySelectorAll('.conversacion-item');
        
        conversaciones.forEach(conversacion => {
            const nombre = conversacion.querySelector('.text-sm.font-medium').textContent.toLowerCase();
            if (nombre.includes(termino)) {
                conversacion.style.display = 'block';
            } else {
                conversacion.style.display = 'none';
            }
        });
    });
    
    // Cerrar modal al hacer clic fuera
    window.onclick = function(event) {
        const modalNuevo = document.getElementById('modal-nuevo-mensaje');
        
        if (event.target === modalNuevo) {
            modalNuevo.classList.add('hidden');
        }
    }
    
    // Auto-resize textarea
    document.getElementById('mensaje-texto').addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
    
    // Enviar mensaje con Enter (Shift+Enter para nueva línea)
    document.getElementById('mensaje-texto').addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            document.getElementById('form-mensaje').dispatchEvent(new Event('submit'));
        }
    });
    
    console.log('Vista Mensajes cargada');
</script>
@endpush