<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Director') - Sistema de Estadías UTH</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'uth-green': '#009d82',
                        'uth-green-light': '#00b894',
                        'uth-green-dark': '#007a63'
                    },
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #009d82 0%, #00b894 100%);
        }
        
        .sidebar-transition {
            transition: all 0.3s ease-in-out;
        }
        
        .notification-badge {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .dropdown-enter {
            opacity: 0;
            transform: translateY(-10px);
        }
        
        .dropdown-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition: all 0.2s ease-out;
        }
        
        .mobile-menu-overlay {
            backdrop-filter: blur(4px);
        }
    </style>
    
    @stack('styles')
</head>
<body class="font-inter antialiased bg-gray-50" x-data="{ sidebarOpen: false, notificationsOpen: false }">
    <!-- Mobile menu overlay -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-40 lg:hidden mobile-menu-overlay"
         @click="sidebarOpen = false"></div>

    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-xl sidebar-transition transform lg:translate-x-0 flex flex-col"
         :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        
        <!-- Logo Section -->
        <div class="flex items-center justify-between h-16 px-6 gradient-bg flex-shrink-0">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('img/logo_uth_2024.png') }}" alt="UTH Logo" class="h-8 w-auto">
                <div class="text-white">
                    <h1 class="text-lg font-bold">UTH</h1>
                    <p class="text-xs opacity-90">Sistema de Estadías</p>
                </div>
            </div>
            <button @click="sidebarOpen = false" class="lg:hidden text-white hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 mt-6 px-3 overflow-y-auto" style="max-height: calc(100vh - 4rem);">
            <div class="space-y-1">
                        <!-- Dashboard -->
                        <a href="{{ route('director.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1 {{ request()->routeIs('director.dashboard') ? 'text-uth-green bg-uth-green/10' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                            </svg>
                            Dashboard
                        </a>

                        <!-- Estudiantes -->
                        <a href="{{ route('director.lista-estudiantes') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1 {{ request()->routeIs('director.lista-estudiantes*') ? 'text-uth-green bg-uth-green/10' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                            </svg>
                            Estudiantes
                        </a>

                        <!-- Asignaciones -->
                        <a href="{{ route('director.asignaciones') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1 {{ request()->routeIs('director.asignaciones*') ? 'text-uth-green bg-uth-green/10' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Asignaciones
                        </a>

                        <!-- Estadías Activas -->
                        <a href="{{ route('director.estadias-activas') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1 {{ request()->routeIs('director.estadias-activas*') ? 'text-uth-green bg-uth-green/10' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Estadías Activas
                        </a>

                        <!-- Cartas Pendientes -->
                        <a href="{{ route('director.cartas-pendientes') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1 {{ request()->routeIs('director.cartas-pendientes*') ? 'text-uth-green bg-uth-green/10' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Cartas Pendientes
                        </a>

                        <!-- Documentos Pendientes -->
                        <a href="{{ route('director.documentos-pendientes') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1 {{ request()->routeIs('director.documentos-pendientes*') ? 'text-uth-green bg-uth-green/10' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Documentos Pendientes
                        </a>

                        <!-- Profesores -->
                        <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profesores
                        </a>

                        <!-- Empresas -->
                        <a href="{{ route('director.empresas-colaboradoras') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1 {{ request()->routeIs('director.empresas-colaboradoras*') ? 'text-uth-green bg-uth-green/10' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Empresas
                        </a>

                        <!-- Reportes -->
                        <a href="{{ route('director.reportes') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-uth-green hover:bg-uth-green/10 rounded-lg mb-1 {{ request()->routeIs('director.reportes*') ? 'text-uth-green bg-uth-green/10' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Reportes
                        </a>


                    </div>
                </nav>
        

    </div>

    <!-- Main Content -->
    <div class="lg:ml-64">
        <!-- Top Navigation Bar -->
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="flex items-center justify-between h-16 px-4 sm:px-6">
                <!-- Mobile menu button -->
                <button @click="sidebarOpen = true" class="lg:hidden text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <!-- Page Title -->
                <div class="flex-1 lg:flex-none">
                    <h1 class="text-xl font-semibold text-gray-900">@yield('page-title', 'Panel Director')</h1>
                </div>

                <!-- Right side items -->
                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <div class="relative" x-data="notificationSystem()">
                        <button @click="toggleNotifications()" 
                                class="relative p-2 text-gray-500 hover:text-uth-green transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M15 17h5l-3-3V9a6 6 0 10-12 0v5l-3 3h13zM13 20a2 2 0 01-4 0"></path>
                            </svg>
                            <!-- Notification badge -->
                            <span x-show="unreadCount > 0" 
                                  x-text="unreadCount" 
                                  class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center notification-badge">
                            </span>
                        </button>
                        
                        <!-- Notifications dropdown -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             @click.away="open = false"
                             class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 z-[9999]">
                            
                            <div class="p-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900">Notificaciones</h3>
                                <p class="text-xs text-gray-500">Director</p>
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
                                         @click="markAsRead(notification)">
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

                    <!-- User menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-uth-green">
                            <div class="w-8 h-8 bg-uth-green rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">
                                    {{ substr(Auth::user()->name ?? Auth::user()->email, 0, 2) }}
                                </span>
                            </div>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- User dropdown -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             @click.away="open = false"
                             class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-xl border border-gray-200 z-[9999] max-h-96 overflow-y-auto">
                            
                            <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-uth-green to-uth-green-light">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-white font-bold text-lg">
                                            {{ substr(Auth::user()->name ?? Auth::user()->email, 0, 2) }}
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-white font-semibold text-sm truncate">{{ Auth::user()->name ?? 'Usuario' }}</p>
                                        <p class="text-white/80 text-xs truncate">{{ Auth::user()->email }}</p>
                                        <p class="text-white/70 text-xs truncate">Director</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="py-2">
                                <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Mi Perfil
                                </a>
                                
                                <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Configuración
                                </a>
                                
                                <div class="border-t border-gray-200 my-2"></div>
                                
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
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
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-4 sm:p-6">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif
            
            @if(session('warning'))
                <div class="mb-4 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-lg">
                    {{ session('warning') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
    
    <script>
        function notificationSystem() {
            return {
                open: false,
                loading: false,
                notifications: [],
                unreadCount: 0,
                userRole: 'Director',
                
                init() {
                    this.loadNotifications();
                    this.loadUnreadCount();
                    // Actualizar notificaciones cada 30 segundos
                    setInterval(() => {
                        this.loadUnreadCount();
                    }, 30000);
                },
                
                toggleNotifications() {
                    this.open = !this.open;
                    if (this.open && this.notifications.length === 0) {
                        this.loadNotifications();
                    }
                },
                
                async loadNotifications() {
                    this.loading = true;
                    try {
                        // Cargar notificaciones específicas del rol
                        const response = await fetch(`/notifications/role/${this.userRole}`, {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        });
                        
                        if (response.ok) {
                            this.notifications = await response.json();
                        } else {
                            console.error('Error loading notifications:', response.statusText);
                        }
                    } catch (error) {
                        console.error('Error loading notifications:', error);
                    } finally {
                        this.loading = false;
                    }
                },
                
                async loadUnreadCount() {
                    try {
                        const response = await fetch('/notifications/count', {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        });
                        
                        if (response.ok) {
                            const data = await response.json();
                            this.unreadCount = data.count;
                        }
                    } catch (error) {
                        console.error('Error loading unread count:', error);
                    }
                },
                
                async markAsRead(notification) {
                    if (notification.id) {
                        try {
                            const response = await fetch(`/notifications/${notification.id}/read`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                }
                            });
                            
                            if (response.ok) {
                                this.loadUnreadCount();
                            }
                        } catch (error) {
                            console.error('Error marking notification as read:', error);
                        }
                    }
                },
                
                loadAllNotifications() {
                    // Aquí se puede implementar una página completa de notificaciones
                    console.log('Loading all notifications for role:', this.userRole);
                    this.open = false;
                },
                
                formatDate(dateString) {
                    if (!dateString) return '';
                    
                    const date = new Date(dateString);
                    const now = new Date();
                    const diffInMinutes = Math.floor((now - date) / (1000 * 60));
                    
                    if (diffInMinutes < 1) {
                        return 'Ahora mismo';
                    } else if (diffInMinutes < 60) {
                        return `Hace ${diffInMinutes} minuto${diffInMinutes > 1 ? 's' : ''}`;
                    } else if (diffInMinutes < 1440) {
                        const hours = Math.floor(diffInMinutes / 60);
                        return `Hace ${hours} hora${hours > 1 ? 's' : ''}`;
                    } else {
                        const days = Math.floor(diffInMinutes / 1440);
                        return `Hace ${days} día${days > 1 ? 's' : ''}`;
                    }
                }
            }
        }
    </script>
</body>
</html>