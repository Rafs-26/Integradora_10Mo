<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Sistema de Estadías UTH</title>
    
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
    
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #009d82 0%, #00b894 100%);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 157, 130, 0.1), 0 10px 10px -5px rgba(0, 157, 130, 0.04);
        }
    </style>
</head>
<body class="font-inter antialiased bg-gray-100">
    <!-- Header -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('img/logo_uth_2024.png') }}" alt="UTH Logo" class="h-10 w-auto">
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Dashboard - Sistema de Estadías</h1>
                        <p class="text-sm text-uth-green">Universidad Tecnológica de Huejotzingo</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Bienvenido, {{ Auth::user()->name ?? Auth::user()->email }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition duration-300">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="min-h-screen py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Welcome Card -->
            <div class="bg-white rounded-3xl shadow-2xl p-12 text-center card-hover mb-8">
                <div class="mb-6">
                    <div class="w-20 h-20 bg-uth-green rounded-full flex items-center justify-center mx-auto mb-4">
                        <img src="{{ asset('img/logo_uth_2024.png') }}" alt="UTH Logo" class="h-12 w-auto">
                    </div>
                </div>
                
                <h2 class="text-4xl font-bold text-gray-900 mb-4">¡Bienvenido al Dashboard!</h2>
                <p class="text-xl text-gray-600 mb-8">
                    Has iniciado sesión exitosamente en el Sistema de Gestión de Estadías
                </p>
                
                <div class="bg-uth-green/10 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-uth-green mb-2">Información de tu cuenta:</h3>
                    <p class="text-gray-700"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p class="text-gray-700"><strong>Último acceso:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
                </div>
            </div>
            
            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Gestión de Estudiantes -->
                <div class="bg-white rounded-2xl p-8 shadow-lg card-hover">
                    <div class="w-16 h-16 bg-uth-green/10 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-uth-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Gestión de Estudiantes</h3>
                    <p class="text-gray-600 mb-4">Administra perfiles de estudiantes y asignación de estadías.</p>
                    <button class="w-full bg-uth-green hover:bg-uth-green-dark text-white py-2 px-4 rounded-lg transition duration-300">
                        Acceder
                    </button>
                </div>
                
                <!-- Empresas y Proyectos -->
                <div class="bg-white rounded-2xl p-8 shadow-lg card-hover">
                    <div class="w-16 h-16 bg-uth-green/10 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-uth-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Empresas y Proyectos</h3>
                    <p class="text-gray-600 mb-4">Catálogo de empresas colaboradoras y proyectos.</p>
                    <button class="w-full bg-uth-green hover:bg-uth-green-dark text-white py-2 px-4 rounded-lg transition duration-300">
                        Acceder
                    </button>
                </div>
                
                <!-- Reportes -->
                <div class="bg-white rounded-2xl p-8 shadow-lg card-hover">
                    <div class="w-16 h-16 bg-uth-green/10 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-uth-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Reportes y Analytics</h3>
                    <p class="text-gray-600 mb-4">Generación de reportes estadísticos.</p>
                    <button class="w-full bg-uth-green hover:bg-uth-green-dark text-white py-2 px-4 rounded-lg transition duration-300">
                        Acceder
                    </button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>