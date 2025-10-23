<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Estadías - UTH</title>
    
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
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .text-shadow {
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="font-inter antialiased">
    <!-- Header -->
    <nav class="bg-white shadow-lg relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('img/logo_uth_2024.png') }}" alt="UTH Logo" class="h-10 w-auto">
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Sistema de Estadías</h1>
                        <p class="text-sm text-uth-green">Universidad Tecnológica de Huejotzingo</p>
                    </div>
                </div>
                

            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4">
        <div class="max-w-2xl w-full">
            <!-- Main Card -->
            <div class="bg-white rounded-3xl shadow-2xl p-16 text-center card-hover">
                <!-- Logo -->
                <div class="mb-6 animate-float">
                    <div class="w-20 h-20 bg-uth-green rounded-full flex items-center justify-center mx-auto mb-4">
                        <img src="{{ asset('img/logo_uth_2024.png') }}" alt="UTH Logo" class="h-12 w-auto">
                    </div>
                </div>
                
                <!-- Title -->
                <h1 class="text-2xl font-bold text-uth-green mb-2">
                    Universidad Tecnológica
                </h1>
                <h2 class="text-xl font-semibold text-uth-green mb-6">
                    de Huejotzingo
                </h2>
                
                <p class="text-sm text-gray-600 mb-8">
                    Universidad Tecnológica de Huejotzingo - Sistema de Gestión de Estadías
                </p>
                
                <!-- Features Icons -->
                <div class="grid grid-cols-3 gap-4 mb-8">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-uth-green/10 rounded-xl flex items-center justify-center mx-auto mb-2">
                            <svg class="w-6 h-6 text-uth-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <p class="text-xs text-gray-600 font-medium">Gestión Integral</p>
                        <p class="text-xs text-gray-500">Administra estudiantes, tutores y directores en un solo lugar</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-12 h-12 bg-uth-green/10 rounded-xl flex items-center justify-center mx-auto mb-2">
                            <svg class="w-6 h-6 text-uth-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <p class="text-xs text-gray-600 font-medium">Empresas Aliadas</p>
                        <p class="text-xs text-gray-500">Conecta con empresas para oportunidades de estadías</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-12 h-12 bg-uth-green/10 rounded-xl flex items-center justify-center mx-auto mb-2">
                            <svg class="w-6 h-6 text-uth-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <p class="text-xs text-gray-600 font-medium">Documentación</p>
                        <p class="text-xs text-gray-500">Gestiona y revisa documentos de manera eficiente</p>
                    </div>
                </div>
                
                <!-- Welcome Message -->
                <h3 class="text-lg font-semibold text-gray-800 mb-2">¡Bienvenido al Sistema!</h3>
                <p class="text-sm text-gray-600 mb-6">Accede a tu cuenta para comenzar a gestionar tus estadías</p>
                
                <!-- Action Buttons -->
                <div class="space-y-4">
                    <a href="{{ route('login') }}" class="block w-full bg-uth-green hover:bg-uth-green-dark text-white font-semibold py-4 px-8 rounded-xl transition duration-300 transform hover:scale-105 shadow-lg text-center">
                        Iniciar Sesión
                    </a>
                </div>
                
                <!-- Security Note -->
                <div class="mt-6 flex items-center justify-center text-xs text-gray-500">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    Sistema seguro y confiable para la gestión académica
                </div>
            </div>
        </div>
    </div>


</body>
</html>
