@extends('layouts.app')

@section('title', 'Empresas - Sistema de Estadías UTH')
@section('page-title', 'Empresas Disponibles')

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
    
    <!-- Descargar Formatos Empresas -->
    <a href="{{ route('student.empresas') }}" class="flex items-center px-4 py-3 text-uth-green bg-uth-green/10 rounded-lg mb-2">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        Descargar Formatos Empresas
    </a>

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

    <!-- Filtros de Búsqueda -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900 mb-2">Buscar Empresas</h2>
            <p class="text-gray-600">Encuentra empresas que ofrecen estadías en tu área</p>
        </div>
        <div class="p-6">
            <form method="GET" action="{{ route('student.empresas') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="buscar" class="block text-sm font-medium text-gray-700 mb-2">Nombre de Empresa</label>
                        <input type="text" name="buscar" id="buscar" value="{{ request('buscar') }}" placeholder="Buscar por nombre..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-uth-green focus:border-uth-green">
                    </div>
                    <div>
                        <label for="sector" class="block text-sm font-medium text-gray-700 mb-2">Sector</label>
                        <select name="sector" id="sector" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-uth-green focus:border-uth-green">
                            <option value="">Todos los sectores</option>
                            <option value="tecnologia" {{ request('sector') == 'tecnologia' ? 'selected' : '' }}>Tecnología</option>
                            <option value="manufactura" {{ request('sector') == 'manufactura' ? 'selected' : '' }}>Manufactura</option>
                            <option value="servicios" {{ request('sector') == 'servicios' ? 'selected' : '' }}>Servicios</option>
                            <option value="salud" {{ request('sector') == 'salud' ? 'selected' : '' }}>Salud</option>
                            <option value="educacion" {{ request('sector') == 'educacion' ? 'selected' : '' }}>Educación</option>
                            <option value="gobierno" {{ request('sector') == 'gobierno' ? 'selected' : '' }}>Gobierno</option>
                            <option value="otro" {{ request('sector') == 'otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>
                    <div>
                        <label for="ubicacion" class="block text-sm font-medium text-gray-700 mb-2">Ubicación</label>
                        <input type="text" name="ubicacion" id="ubicacion" value="{{ request('ubicacion') }}" placeholder="Ciudad, estado..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-uth-green focus:border-uth-green">
                    </div>
                </div>
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('student.empresas') }}" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Limpiar</a>
                    <button type="submit" class="px-4 py-2 bg-uth-green text-white rounded-lg hover:bg-uth-green/90 transition-colors">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Buscar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de Empresas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @forelse($empresas as $empresa)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <div class="w-12 h-12 bg-uth-green/10 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-uth-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $empresa->nombre }}</h3>
                                    <p class="text-sm text-gray-600">{{ ucfirst($empresa->sector) }}</p>
                                </div>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($empresa->estado == 'activa') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($empresa->estado) }}
                        </span>
                    </div>
                        
                        <div class="space-y-3 mb-4">
                            @if($empresa->descripcion)
                                <p class="text-sm text-gray-600">{{ Str::limit($empresa->descripcion, 150) }}</p>
                            @endif
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-gray-600">
                                @if($empresa->direccion)
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ Str::limit($empresa->direccion, 30) }}
                                    </div>
                                @endif
                                @if($empresa->telefono)
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                        {{ $empresa->telefono }}
                                    </div>
                                @endif
                                @if($empresa->email)
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $empresa->email }}
                                    </div>
                                @endif
                                @if($empresa->sitio_web)
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9m0 9c-5 0-9-4-9-9s4-9 9-9"></path>
                                        </svg>
                                        <a href="{{ $empresa->sitio_web }}" target="_blank" class="text-uth-green hover:text-uth-green/80">Sitio Web</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        @if($empresa->requisitos)
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Requisitos:</h4>
                                <p class="text-sm text-gray-600">{{ Str::limit($empresa->requisitos, 100) }}</p>
                            </div>
                        @endif
                        
                        @if($empresa->beneficios)
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Beneficios:</h4>
                                <p class="text-sm text-gray-600">{{ Str::limit($empresa->beneficios, 100) }}</p>
                            </div>
                        @endif
                        
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <div class="text-sm text-gray-500">
                                @php
                                    $estadiasActivas = $empresa->estadias()->whereIn('status', ['en_proceso', 'documentos_pendientes', 'documentos_completos', 'validacion_biblioteca'])->count();
                                @endphp
                                {{ $estadiasActivas }} estadía(s) activa(s)
                            </div>
                            
                            @if($empresa->estado == 'activa')
                            <button onclick="mostrarModalPostulacion({{ $empresa->id }}, '{{ $empresa->nombre }}')"
                                class="inline-flex items-center px-4 py-2 bg-uth-green text-white text-sm font-medium rounded-lg hover:bg-uth-green/90 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Postularme
                            </button>
                        @else
                            <span class="text-sm text-gray-500">No disponible</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-2">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No se encontraron empresas</h3>
                    <p class="text-gray-600">Intenta ajustar tus filtros de búsqueda o contacta al coordinador de estadías.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Paginación -->
    @if($empresas->hasPages())
        <div class="mt-6">
            {{ $empresas->links() }}
        </div>
    @endif
</div>

<!-- Modal de Postulación -->
<div id="modalPostulacion" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Postularme a <span id="nombreEmpresa"></span></h3>
                    <button onclick="cerrarModalPostulacion()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <form id="formPostulacion" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="carta_presentacion" class="block text-sm font-medium text-gray-700 mb-2">Carta de Presentación</label>
                        <textarea id="carta_presentacion" name="carta_presentacion" rows="6" required maxlength="1000"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-uth-green focus:border-uth-green"
                            placeholder="Describe por qué te interesa esta empresa y qué puedes aportar... (máximo 1000 caracteres)"></textarea>
                        <div class="text-right text-xs text-gray-500 mt-1">
                            <span id="contadorCaracteres">0</span>/1000 caracteres
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="acepta_terminos" required class="rounded border-gray-300 text-uth-green focus:ring-uth-green">
                            <span class="ml-2 text-sm text-gray-700">Acepto los términos y condiciones de la postulación</span>
                        </label>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="cerrarModalPostulacion()" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 bg-uth-green text-white rounded-lg hover:bg-uth-green/90 transition-colors">
                            Enviar Postulación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function mostrarModalPostulacion(empresaId, nombreEmpresa) {
    document.getElementById('nombreEmpresa').textContent = nombreEmpresa;
    document.getElementById('formPostulacion').action = `{{ route('student.empresas') }}/${empresaId}/postular`;
    document.getElementById('modalPostulacion').classList.remove('hidden');
}

function cerrarModalPostulacion() {
    document.getElementById('modalPostulacion').classList.add('hidden');
    document.getElementById('formPostulacion').reset();
    document.getElementById('contadorCaracteres').textContent = '0';
}

// Contador de caracteres
document.getElementById('carta_presentacion').addEventListener('input', function() {
    const contador = document.getElementById('contadorCaracteres');
    contador.textContent = this.value.length;
    
    if (this.value.length > 1000) {
        contador.classList.add('text-red-500');
    } else {
        contador.classList.remove('text-red-500');
    }
});

// Cerrar modal al hacer clic fuera
document.getElementById('modalPostulacion').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalPostulacion();
    }
});

// Cerrar modal con Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarModalPostulacion();
    }
});
</script>
@endsection