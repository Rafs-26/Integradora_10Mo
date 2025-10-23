@extends('layouts.app')

@section('title', 'Mi Perfil - Sistema de Estadías UTH')
@section('page-title', 'Mi Perfil')

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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información Personal -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">Información Personal</h2>
                    <p class="text-gray-600">Actualiza tu información personal y académica</p>
                </div>
                <div class="p-6">
                    <form action="{{ route('student.perfil.actualizar') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Información Básica -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo</label>
                                <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-uth-green focus:border-uth-green">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico</label>
                                <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-uth-green focus:border-uth-green">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        @if($estudiante)
                            <!-- Información Académica -->
                            <div class="border-t border-gray-200 pt-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Información Académica</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="matricula" class="block text-sm font-medium text-gray-700 mb-2">Matrícula</label>
                                        <input type="text" name="matricula" id="matricula" value="{{ old('matricula', $estudiante->matricula) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-uth-green focus:border-uth-green">
                                        @error('matricula')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="carrera_id" class="block text-sm font-medium text-gray-700 mb-2">Carrera</label>
                                        <select name="carrera_id" id="carrera_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-uth-green focus:border-uth-green">
                                            <option value="">Seleccionar carrera</option>
                                            @foreach($carreras as $carrera)
                                                <option value="{{ $carrera->id }}" {{ old('carrera_id', $estudiante->carrera_id) == $carrera->id ? 'selected' : '' }}>
                                                    {{ $carrera->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('carrera_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="semestre" class="block text-sm font-medium text-gray-700 mb-2">Semestre</label>
                                        <select name="semestre" id="semestre" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-uth-green focus:border-uth-green">
                                            <option value="">Seleccionar semestre</option>
                                            @for($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}" {{ old('semestre', $estudiante->semestre) == $i ? 'selected' : '' }}>{{ $i }}° Semestre</option>
                                            @endfor
                                        </select>
                                        @error('semestre')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="promedio" class="block text-sm font-medium text-gray-700 mb-2">Promedio</label>
                                        <input type="number" name="promedio" id="promedio" value="{{ old('promedio', $estudiante->promedio) }}" step="0.01" min="0" max="10" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-uth-green focus:border-uth-green">
                                        @error('promedio')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Información de Contacto -->
                            <div class="border-t border-gray-200 pt-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Información de Contacto</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                                        <input type="tel" name="telefono" id="telefono" value="{{ old('telefono', $estudiante->telefono) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-uth-green focus:border-uth-green">
                                        @error('telefono')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="telefono_emergencia" class="block text-sm font-medium text-gray-700 mb-2">Teléfono de Emergencia</label>
                                        <input type="tel" name="telefono_emergencia" id="telefono_emergencia" value="{{ old('telefono_emergencia', $estudiante->telefono_emergencia) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-uth-green focus:border-uth-green">
                                        @error('telefono_emergencia')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label for="direccion" class="block text-sm font-medium text-gray-700 mb-2">Dirección</label>
                                    <textarea name="direccion" id="direccion" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-uth-green focus:border-uth-green" placeholder="Dirección completa...">{{ old('direccion', $estudiante->direccion) }}</textarea>
                                    @error('direccion')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Información Adicional -->
                            <div class="border-t border-gray-200 pt-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Información Adicional</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Nacimiento</label>
                                        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento', $estudiante->fecha_nacimiento) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-uth-green focus:border-uth-green">
                                        @error('fecha_nacimiento')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="estado_civil" class="block text-sm font-medium text-gray-700 mb-2">Estado Civil</label>
                                        <select name="estado_civil" id="estado_civil" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-uth-green focus:border-uth-green">
                                            <option value="">Seleccionar</option>
                                            <option value="soltero" {{ old('estado_civil', $estudiante->estado_civil) == 'soltero' ? 'selected' : '' }}>Soltero(a)</option>
                                            <option value="casado" {{ old('estado_civil', $estudiante->estado_civil) == 'casado' ? 'selected' : '' }}>Casado(a)</option>
                                            <option value="divorciado" {{ old('estado_civil', $estudiante->estado_civil) == 'divorciado' ? 'selected' : '' }}>Divorciado(a)</option>
                                            <option value="viudo" {{ old('estado_civil', $estudiante->estado_civil) == 'viudo' ? 'selected' : '' }}>Viudo(a)</option>
                                            <option value="union_libre" {{ old('estado_civil', $estudiante->estado_civil) == 'union_libre' ? 'selected' : '' }}>Unión Libre</option>
                                        </select>
                                        @error('estado_civil')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <div class="flex justify-end pt-6 border-t border-gray-200">
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-uth-green text-white text-sm font-medium rounded-lg hover:bg-uth-green/90 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Panel Lateral -->
        <div class="space-y-6">
            <!-- Foto de Perfil -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 text-center">
                    <div class="w-24 h-24 bg-uth-green/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-12 h-12 text-uth-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">{{ auth()->user()->name }}</h3>
                    <p class="text-sm text-gray-600 mb-4">{{ auth()->user()->email }}</p>
                    @if($estudiante)
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><strong>Matrícula:</strong> {{ $estudiante->matricula }}</p>
                            @if($estudiante->carrera)
                                <p><strong>Carrera:</strong> {{ $estudiante->carrera->nombre }}</p>
                            @endif
                            @if($estudiante->semestre)
                                <p><strong>Semestre:</strong> {{ $estudiante->semestre }}°</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Estadísticas Rápidas -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Estadísticas</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Documentos Subidos</span>
                            <span class="text-sm font-medium text-gray-900">{{ $estadisticas['documentos'] ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Citas Programadas</span>
                            <span class="text-sm font-medium text-gray-900">{{ $estadisticas['citas'] ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Estado de Estadía</span>
                            <span class="text-sm font-medium text-uth-green">{{ $estadisticas['estado_estadia'] ?? 'Sin asignar' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Cambiar Contraseña -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Cambiar Contraseña</h3>
                    <form method="POST" action="{{ route('student.perfil.cambiar-password') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña Actual</label>
                            <input type="password" id="current_password" name="current_password" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-uth-green focus:border-uth-green">
                            @error('current_password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">Nueva Contraseña</label>
                            <input type="password" id="new_password" name="new_password" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-uth-green focus:border-uth-green">
                            <small class="text-gray-500 text-xs">8-15 caracteres, debe incluir números, letras y al menos un carácter especial</small>
                            @error('new_password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Nueva Contraseña</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-uth-green focus:border-uth-green">
                            @error('new_password_confirmation')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-uth-green text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                Cambiar Contraseña
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection