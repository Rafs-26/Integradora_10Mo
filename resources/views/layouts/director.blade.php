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
    <div id="offline-banner" style="display:none" class="fixed top-0 left-0 right-0 z-[9999]">
        <div class="bg-yellow-600 text-white text-sm py-2 px-4 text-center">
            Modo sin conexión: algunas funciones pueden estar limitadas.
        </div>
    </div>
    <div id="offline-toast" style="display:none" class="fixed bottom-4 right-4 z-[9999]">
        <div class="bg-yellow-600 text-white text-sm py-3 px-4 rounded-lg shadow-lg" role="alert" aria-live="assertive">
            Sin conexión a Internet. Estás en modo offline.
        </div>
    </div>
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
            
            <!-- User info + Logout -->
            <div class="mt-6 border-t border-gray-200 pt-4 px-3">
                <div class="flex items-center mb-3">
                    <div class="w-9 h-9 bg-uth-green rounded-full flex items-center justify-center mr-3">
                        <span class="text-white text-sm font-semibold">{{ substr(Auth::user()->name ?? Auth::user()->email, 0, 2) }}</span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name ?? 'Usuario' }}</p>
                        <p class="text-xs text-gray-500 truncate">Director</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </nav>
        

    </div>

    <!-- Mobile toggle button -->
    <div class="lg:hidden fixed top-4 left-4 z-50">
        <button @click="sidebarOpen = true" class="text-gray-700 bg-white/90 backdrop-blur px-3 py-2 rounded-md shadow hover:bg-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <!-- Main Content -->
    <div class="lg:ml-64">

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
      function updateOnlineStatus(){
        const banner = document.getElementById('offline-banner');
        const toast = document.getElementById('offline-toast');
        if (navigator.onLine){ banner.style.display = 'none'; if (toast) toast.style.display = 'none'; }
        else { banner.style.display = 'block'; if (toast) toast.style.display = 'block'; }
      }
      window.addEventListener('load', updateOnlineStatus);
      window.addEventListener('online', updateOnlineStatus);
      window.addEventListener('offline', updateOnlineStatus);
    </script>
    
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
