@extends('layouts.director')

@section('title', 'Cartas Pendientes')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Cartas de Presentación Pendientes</h1>
        <p class="text-gray-600 mt-2">Gestiona las solicitudes de cartas de presentación de los estudiantes</p>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pendientes</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $cartas->total() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar estudiante</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green"
                           placeholder="Nombre o matrícula...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Carrera</label>
                    <select name="carrera" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green">
                        <option value="">Todas las carreras</option>
                        <!-- Aquí se cargarían las carreras dinámicamente -->
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-uth-green text-white px-4 py-2 rounded-md hover:bg-uth-green/90 mr-2">
                        Filtrar
                    </button>
                    <a href="{{ route('director.cartas-pendientes') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de cartas -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            @if($cartas->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Carrera</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Solicitud</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($cartas as $carta)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-uth-green/10 flex items-center justify-center">
                                                <span class="text-sm font-medium text-uth-green">
                                                    {{ substr($carta->estudiante->user->name, 0, 2) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $carta->estudiante->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $carta->estudiante->matricula }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $carta->estudiante->carrera->nombre }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $carta->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        {{ ucfirst($carta->estado) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <!-- Generar PDF -->
                                        <a href="{{ route('director.cartas.generar-pdf', $carta->id) }}" 
                                           class="text-blue-600 hover:text-blue-900 inline-flex items-center" 
                                           title="Generar PDF">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            PDF
                                        </a>
                                        
                                        <!-- Firmar y Aprobar -->
                                        <button onclick="openSignModal({{ $carta->id }})" 
                                                class="text-green-600 hover:text-green-900 inline-flex items-center" 
                                                title="Firmar y Aprobar">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Firmar
                                        </button>
                                        
                                        <!-- Rechazar -->
                                        <form method="POST" action="{{ route('director.cartas.rechazar', $carta->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-900 inline-flex items-center" 
                                                    onclick="return confirm('¿Rechazar esta carta de presentación?')" 
                                                    title="Rechazar">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Rechazar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="mt-6">
                    {{ $cartas->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay cartas pendientes</h3>
                    <p class="mt-1 text-sm text-gray-500">No se encontraron cartas de presentación pendientes de aprobación.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal de Firma Digital -->
<div id="signModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Firmar Carta de Presentación</h3>
                <button onclick="closeSignModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="signForm" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Vista previa del PDF -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Vista previa de la carta:</label>
                    <div class="border rounded-lg p-4 bg-gray-50 h-64 overflow-y-auto">
                        <iframe id="pdfPreview" class="w-full h-full" frameborder="0"></iframe>
                    </div>
                </div>
                
                <!-- Área de firma -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Firma digital:</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                        <canvas id="signatureCanvas" width="400" height="150" class="border border-gray-300 mx-auto cursor-crosshair"></canvas>
                        <div class="mt-2">
                            <button type="button" onclick="clearSignature()" class="text-sm text-gray-600 hover:text-gray-800">Limpiar firma</button>
                        </div>
                    </div>
                </div>
                
                <!-- Comentarios opcionales -->
                <div class="mb-6">
                    <label for="comentarios" class="block text-sm font-medium text-gray-700 mb-2">Comentarios (opcional):</label>
                    <textarea id="comentarios" name="comentarios" rows="3" 
                              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-uth-green focus:ring-uth-green"
                              placeholder="Comentarios adicionales..."></textarea>
                </div>
                
                <!-- Botones -->
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeSignModal()" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-uth-green rounded-md hover:bg-uth-green/90">
                        Firmar y Aprobar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentCartaId = null;
let canvas = null;
let ctx = null;
let isDrawing = false;

// Inicializar canvas cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
    canvas = document.getElementById('signatureCanvas');
    ctx = canvas.getContext('2d');
    
    // Configurar canvas para firma
    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseout', stopDrawing);
    
    // Soporte táctil
    canvas.addEventListener('touchstart', handleTouch);
    canvas.addEventListener('touchmove', handleTouch);
    canvas.addEventListener('touchend', stopDrawing);
});

function openSignModal(cartaId) {
    currentCartaId = cartaId;
    document.getElementById('signModal').classList.remove('hidden');
    document.getElementById('signForm').action = `/director/cartas/${cartaId}/firmar`;
    
    // Cargar vista previa del PDF
    document.getElementById('pdfPreview').src = `/director/cartas/${cartaId}/generar-pdf`;
    
    // Limpiar firma anterior
    clearSignature();
}

function closeSignModal() {
    document.getElementById('signModal').classList.add('hidden');
    currentCartaId = null;
}

function startDrawing(e) {
    isDrawing = true;
    const rect = canvas.getBoundingClientRect();
    ctx.beginPath();
    ctx.moveTo(e.clientX - rect.left, e.clientY - rect.top);
}

function draw(e) {
    if (!isDrawing) return;
    
    const rect = canvas.getBoundingClientRect();
    ctx.lineWidth = 2;
    ctx.lineCap = 'round';
    ctx.strokeStyle = '#000';
    ctx.lineTo(e.clientX - rect.left, e.clientY - rect.top);
    ctx.stroke();
}

function stopDrawing() {
    isDrawing = false;
}

function handleTouch(e) {
    e.preventDefault();
    const touch = e.touches[0];
    const mouseEvent = new MouseEvent(e.type === 'touchstart' ? 'mousedown' : 
                                     e.type === 'touchmove' ? 'mousemove' : 'mouseup', {
        clientX: touch.clientX,
        clientY: touch.clientY
    });
    canvas.dispatchEvent(mouseEvent);
}

function clearSignature() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
}

// Enviar formulario con firma
document.getElementById('signForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Convertir firma a imagen
    const signatureData = canvas.toDataURL('image/png');
    
    // Crear FormData
    const formData = new FormData();
    formData.append('_token', document.querySelector('input[name="_token"]').value);
    formData.append('comentarios', document.getElementById('comentarios').value);
    formData.append('firma', signatureData);
    
    // Enviar formulario
    fetch(this.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeSignModal();
            location.reload();
        } else {
            alert('Error al procesar la firma: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al procesar la solicitud');
    });
});
</script>

@endsection