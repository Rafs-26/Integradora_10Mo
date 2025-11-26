{{-- Navigation Component with Session Control and RBAC --}}
@php
    // Get current user and role
    $currentUser = Auth::user();
    $userRole = $currentUser ? $currentUser->getRoleName() : null;
    
    // Define menu items based on roles
    $menuItems = [];
    
    if ($currentUser) {
        switch ($userRole) {
            case 'Administrador':
                $menuItems = [
                    ['name' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'fas fa-tachometer-alt', 'label' => 'Panel Principal'],
                    ['name' => 'Usuarios', 'route' => 'admin.users', 'icon' => 'fas fa-users', 'label' => 'Gestión de Usuarios'],
                    ['name' => 'Configuración', 'route' => 'admin.settings', 'icon' => 'fas fa-cog', 'label' => 'Configuración del Sistema'],
                    ['name' => 'Reportes', 'route' => 'admin.reports', 'icon' => 'fas fa-chart-bar', 'label' => 'Reportes Globales'],
                ];
                break;
                
            case 'Director':
                $menuItems = [
                    ['name' => 'Dashboard', 'route' => 'director.dashboard', 'icon' => 'fas fa-tachometer-alt', 'label' => 'Panel Principal'],
                    ['name' => 'Estadías Activas', 'route' => 'director.estadias-activas', 'icon' => 'fas fa-briefcase', 'label' => 'Estadías Activas'],
                    ['name' => 'Asignaciones', 'route' => 'director.asignaciones', 'icon' => 'fas fa-user-check', 'label' => 'Asignar Tutores'],
                    ['name' => 'Estudiantes', 'route' => 'director.lista-estudiantes', 'icon' => 'fas fa-user-graduate', 'label' => 'Lista de Estudiantes'],
                    ['name' => 'Seguimiento', 'route' => 'director.seguimiento-estudiantes', 'icon' => 'fas fa-chart-line', 'label' => 'Seguimiento Estudiantes'],
                    ['name' => 'Empresas', 'route' => 'director.empresas-colaboradoras', 'icon' => 'fas fa-building', 'label' => 'Empresas Colaboradoras'],
                    ['name' => 'Documentos Pendientes', 'route' => 'director.documentos-pendientes', 'icon' => 'fas fa-file-alt', 'label' => 'Documentos Pendientes'],
                    ['name' => 'Cartas Pendientes', 'route' => 'director.cartas-pendientes', 'icon' => 'fas fa-envelope', 'label' => 'Cartas de Presentación'],
                    ['name' => 'Reportes', 'route' => 'director.reportes', 'icon' => 'fas fa-chart-bar', 'label' => 'Reportes'],
                ];
                break;
                
            case 'Profesor':
                $menuItems = [
                    ['name' => 'Dashboard', 'route' => 'teacher.dashboard', 'icon' => 'fas fa-tachometer-alt', 'label' => 'Panel Principal'],
                    ['name' => 'Mis Estudiantes', 'route' => 'teacher.mis-estudiantes', 'icon' => 'fas fa-user-graduate', 'label' => 'Mis Estudiantes'],
                    ['name' => 'Seguimiento', 'route' => 'teacher.seguimiento', 'icon' => 'fas fa-chart-line', 'label' => 'Seguimiento'],
                    ['name' => 'Documentos por Revisar', 'route' => 'teacher.documentos-por-revisar', 'icon' => 'fas fa-file-alt', 'label' => 'Documentos por Revisar'],
                    ['name' => 'Evaluaciones', 'route' => 'teacher.evaluaciones', 'icon' => 'fas fa-clipboard-check', 'label' => 'Evaluaciones'],
                    ['name' => 'Citas', 'route' => 'teacher.programar-citas', 'icon' => 'fas fa-calendar', 'label' => 'Programar Citas'],
                    ['name' => 'Solicitudes Cartas', 'route' => 'teacher.solicitudes-cartas', 'icon' => 'fas fa-envelope', 'label' => 'Solicitudes de Cartas'],
                    ['name' => 'Reportes', 'route' => 'teacher.reportes', 'icon' => 'fas fa-chart-bar', 'label' => 'Mis Reportes'],
                ];
                break;
                
            case 'Estudiante':
                $menuItems = [
                    ['name' => 'Dashboard', 'route' => 'student.dashboard', 'icon' => 'fas fa-tachometer-alt', 'label' => 'Panel Principal'],
                    ['name' => 'Mi Estadía', 'route' => 'student.mi-estadia', 'icon' => 'fas fa-briefcase', 'label' => 'Mi Estadía'],
                    ['name' => 'Documentos', 'route' => 'student.documentos', 'icon' => 'fas fa-file-alt', 'label' => 'Mis Documentos'],
                    ['name' => 'Citas', 'route' => 'student.citas', 'icon' => 'fas fa-calendar', 'label' => 'Mis Citas'],
                    ['name' => 'Empresas', 'route' => 'student.empresas-catalogo', 'icon' => 'fas fa-building', 'label' => 'Catálogo de Empresas'],
                    ['name' => 'Carta Presentación', 'route' => 'student.carta-presentacion', 'icon' => 'fas fa-envelope', 'label' => 'Carta de Presentación'],
                    ['name' => 'Perfil', 'route' => 'student.perfil', 'icon' => 'fas fa-user', 'label' => 'Mi Perfil'],
                ];
                break;
                
            case 'Biblioteca':
                $menuItems = [
                    ['name' => 'Dashboard', 'route' => 'biblioteca.dashboard', 'icon' => 'fas fa-tachometer-alt', 'label' => 'Panel Principal'],
                    ['name' => 'Memorias Pendientes', 'route' => 'biblioteca.memorias-pendientes', 'icon' => 'fas fa-clock', 'label' => 'Memorias Pendientes'],
                    ['name' => 'Memorias Validadas', 'route' => 'biblioteca.memorias-validadas', 'icon' => 'fas fa-check-circle', 'label' => 'Memorias Validadas'],
                    ['name' => 'Memorias Rechazadas', 'route' => 'biblioteca.memorias-rechazadas', 'icon' => 'fas fa-times-circle', 'label' => 'Memorias Rechazadas'],
                    ['name' => 'Estadísticas', 'route' => 'biblioteca.estadisticas', 'icon' => 'fas fa-chart-bar', 'label' => 'Estadísticas'],
                ];
                break;
                
            default:
                $menuItems = [
                    ['name' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'fas fa-tachometer-alt', 'label' => 'Panel Principal'],
                ];
        }
    }
@endphp

{{-- Fixed Navigation Bar --}}
<nav class="fixed top-0 left-0 right-0 bg-white shadow-lg z-50 border-b border-gray-200" role="navigation" aria-label="Navegación principal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            {{-- Logo and Brand --}}
            <div class="flex items-center space-x-4">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3" aria-label="Ir al inicio">
                    <img src="{{ asset('img/logo_uth_2024.png') }}" alt="UTH Logo" class="h-8 w-auto">
                    <div class="hidden sm:block">
                        <h1 class="text-lg font-bold text-gray-800">Sistema de Estadías</h1>
                        <p class="text-xs text-uth-green">Universidad Tecnológica de Huejotzingo</p>
                    </div>
                </a>
            </div>

            {{-- Desktop Navigation Menu --}}
            @if($currentUser && $userRole)
                <div class="hidden lg:flex items-center space-x-1">
                    @foreach($menuItems as $item)
                        <a href="{{ route($item['route']) }}" 
                           class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-uth-green hover:bg-gray-50 transition-colors duration-200 {{ request()->routeIs($item['route'] . '*') ? 'text-uth-green bg-gray-100' : '' }}"
                           aria-label="{{ $item['label'] }}"
                           role="menuitem">
                            <i class="{{ $item['icon'] }} mr-1"></i>
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>

                {{-- User Menu --}}
                <div class="flex items-center space-x-4">
                    {{-- Notifications --}}
                    <div class="relative" x-data="notificationSystem()" x-init="init()">
                        <button @click="toggleNotifications()" 
                                class="relative p-2 text-gray-500 hover:text-uth-green transition-colors duration-200"
                                aria-label="Notificaciones"
                                role="button">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M15 17h5l-3-3V9a6 6 0 10-12 0v5l-3 3h13zM13 20a2 2 0 01-4 0"></path>
                            </svg>
                            <span x-show="unreadCount > 0" 
                                  x-text="unreadCount" 
                                  class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center notification-badge"
                                  aria-label="Notificaciones no leídas">
                            </span>
                        </button>
                        
                        {{-- Notifications Dropdown --}}
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             @click.away="open = false"
                             class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 z-50"
                             role="menu"
                             aria-label="Menú de notificaciones">
                            
                            <div class="p-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900">Notificaciones</h3>
                                <p class="text-xs text-gray-500">{{ $userRole }}</p>
                            </div>
                            
                            <div class="max-h-96 overflow-y-auto">
                                <template x-if="loading">
                                    <div class="p-4 text-center">
                                        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-uth-green mx-auto"></div>
                                        <p class="text-sm text-gray-500 mt-2">Cargando notificaciones...</p>
                                    </div>
                                </template>
                                
                                <template x-if="!loading && notifications.length === 0">
                                    <div class="p-4 text-center">
                                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                        </svg>
                                        <p class="text-sm text-gray-500">No hay notificaciones</p>
                                    </div>
                                </template>
                                
                                <template x-for="notification in notifications" :key="notification.id || notification.titulo">
                                    <div class="p-4 border-b border-gray-100 hover:bg-gray-50 cursor-pointer" 
                                         @click="markAsRead(notification)"
                                         role="menuitem">
                                        <div class="flex items-start space-x-3">
                                            <div class="w-2 h-2 rounded-full mt-2" 
                                                 :class="{
                                                     'bg-uth-green': notification.tipo === 'success',
                                                     'bg-yellow-500': notification.tipo === 'warning',
                                                     'bg-red-500': notification.tipo === 'error',
                                                     'bg-blue-500': notification.tipo === 'info'
                                                 }"></div>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900" x-text="notification.titulo"></p>
                                                <p class="text-xs text-gray-500 mt-1" x-text="notification.mensaje"></p>
                                                <p class="text-xs text-gray-400 mt-1" x-text="formatDate(notification.fecha || notification.created_at)"></p>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            
                            <div class="p-3 border-t border-gray-200">
                                <button @click="loadAllNotifications()" class="text-sm text-uth-green hover:text-uth-green-dark font-medium">
                                    Ver todas las notificaciones
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- User Profile Dropdown --}}
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" 
                                class="flex items-center space-x-2 text-gray-700 hover:text-uth-green focus:outline-none focus:ring-2 focus:ring-uth-green focus:ring-offset-2 rounded-md p-1"
                                aria-label="Menú de usuario"
                                role="button">
                            <div class="w-8 h-8 bg-uth-green rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">
                                    {{ substr($currentUser->name ?? $currentUser->email, 0, 2) }}
                                </span>
                            </div>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        {{-- User Dropdown Menu --}}
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-xl border border-gray-200 z-50"
                             role="menu">
                            
                            <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-uth-green to-uth-green-light">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-white font-bold text-lg">
                                            {{ substr($currentUser->name ?? $currentUser->email, 0, 2) }}
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-white font-semibold text-sm truncate">{{ $currentUser->name ?? 'Usuario' }}</p>
                                        <p class="text-white/80 text-xs truncate">{{ $currentUser->email }}</p>
                                        <p class="text-white/70 text-xs truncate">{{ $userRole }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="py-2">
                                {{-- Profile Link --}}
                                @if($userRole === 'Estudiante')
                                    <a href="{{ route('student.perfil') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition-colors" role="menuitem">
                                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Mi Perfil
                                    </a>
                                @elseif($userRole === 'Profesor')
                                    <a href="{{ route('teacher.perfil') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition-colors" role="menuitem">
                                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Mi Perfil
                                    </a>
                                @elseif($userRole === 'Director')
                                    <a href="{{ route('director.perfil') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition-colors" role="menuitem">
                                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Mi Perfil
                                    </a>
                                @elseif($userRole === 'Administrador')
                                    <a href="{{ route('admin.perfil') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition-colors" role="menuitem">
                                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Mi Perfil
                                    </a>
                                @elseif($userRole === 'Biblioteca')
                                    <a href="{{ route('biblioteca.perfil') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition-colors" role="menuitem">
                                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Mi Perfil
                                    </a>
                                @else
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition-colors" role="menuitem">
                                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Mi Perfil
                                    </a>
                                @endif
                                
                                {{-- Settings --}}
                                <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition-colors" role="menuitem">
                                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Configuración
                                </a>
                                
                                {{-- Logout --}}
                                <div class="border-t border-gray-200 my-2"></div>
                                
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors" role="menuitem">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Cerrar Sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- Guest User Menu --}}
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-uth-green px-3 py-2 rounded-md text-sm font-medium">
                        Iniciar Sesión
                    </a>
                </div>
            @endif
        </div>

        {{-- Mobile Menu Button --}}
        <div class="lg:hidden flex items-center">
            @if($currentUser && $userRole)
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="text-gray-500 hover:text-uth-green focus:outline-none focus:ring-2 focus:ring-uth-green rounded-md"
                        aria-label="Menú móvil"
                        aria-expanded="false">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            @endif
        </div>
    </div>

    {{-- Mobile Menu --}}
    @if($currentUser && $userRole)
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="lg:hidden border-t border-gray-200">
            <div class="px-2 pt-2 pb-3 space-y-1">
                @foreach($menuItems as $item)
                    <a href="{{ route($item['route']) }}" 
                       class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-uth-green hover:bg-gray-50 transition-colors duration-200 {{ request()->routeIs($item['route'] . '*') ? 'text-uth-green bg-gray-100' : '' }}"
                       role="menuitem">
                        <i class="{{ $item['icon'] }} mr-2"></i>
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>
            
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="flex items-center px-4 mb-3">
                    <div class="w-10 h-10 bg-uth-green rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold text-sm">
                            {{ substr($currentUser->name ?? $currentUser->email, 0, 2) }}
                        </span>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">{{ $currentUser->name ?? 'Usuario' }}</p>
                        <p class="text-xs text-gray-500">{{ $userRole }}</p>
                    </div>
                </div>
                
                <div class="mt-3 space-y-1 px-2">
                    @if($userRole === 'Estudiante')
                        <a href="{{ route('student.perfil') }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-md" role="menuitem">Mi Perfil</a>
                    @elseif($userRole === 'Profesor')
                        <a href="{{ route('teacher.perfil') }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-md" role="menuitem">Mi Perfil</a>
                    @elseif($userRole === 'Director')
                        <a href="{{ route('director.perfil') }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-md" role="menuitem">Mi Perfil</a>
                    @elseif($userRole === 'Administrador')
                        <a href="{{ route('admin.perfil') }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-md" role="menuitem">Mi Perfil</a>
                    @elseif($userRole === 'Biblioteca')
                        <a href="{{ route('biblioteca.perfil') }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-md" role="menuitem">Mi Perfil</a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md" role="menuitem">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</nav>

{{-- Add spacing for fixed navbar --}}
<div class="h-16"></div>

{{-- Scripts removidos: notificationSystem y navigationSystem definidos globalmente en layout --}}
