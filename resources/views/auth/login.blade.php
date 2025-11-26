<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#009d82">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Estadías UTH">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/logo_uth_2024.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/logo_uth_2024.png') }}">
    
    <title>Iniciar Sesión - Sistema de Estadías UTH</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
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
        
        .input-focus:focus {
            border-color: #009d82;
            box-shadow: 0 0 0 3px rgba(0, 157, 130, 0.1);
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
                
                <div class="flex items-center space-x-4">
                    <a href="{{ url('/') }}" class="text-uth-green hover:text-uth-green-dark font-medium transition duration-300">
                        ← Volver al inicio
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4">
        <div class="max-w-md w-full">
            <!-- Login Card -->
            <div class="bg-white rounded-3xl shadow-2xl p-12 text-center card-hover">
                <!-- Logo -->
                <div class="mb-8 animate-float">
                    <div class="w-20 h-20 bg-uth-green rounded-full flex items-center justify-center mx-auto mb-4">
                        <img src="{{ asset('img/logo_uth_2024.png') }}" alt="UTH Logo" class="h-12 w-auto">
                    </div>
                </div>
                
                <!-- Title -->
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Iniciar Sesión</h2>
                    <p class="text-gray-600">Accede a tu cuenta del Sistema de Estadías</p>
                </div>
                
                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Email Field -->
                    <div class="text-left">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Correo Electrónico
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            placeholder="usuario@uth.edu.mx"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none input-focus transition duration-300 @error('email') border-red-500 @enderror"
                            required
                        >
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Password Field -->
                    <div class="text-left">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Contraseña
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                placeholder="Máximo 8 caracteres"
                                class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:outline-none input-focus transition duration-300 @error('password') border-red-500 @enderror"
                                required
                            >
                            <button type="button" id="togglePassword" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-800 hover:text-black transition duration-200">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Remember Me -->
                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-uth-green focus:ring-uth-green">
                            <span class="ml-2 text-gray-600">Recordarme</span>
                        </label>
                    </div>
                    
                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full bg-uth-green hover:bg-uth-green-dark text-white font-semibold py-4 px-8 rounded-xl transition duration-300 transform hover:scale-105 shadow-lg"
                    >
                        Iniciar Sesión
                    </button>
                </form>
                
                <!-- Security Note -->
                <div class="mt-8 p-4 bg-gray-50 rounded-xl">
                    <p class="text-xs text-gray-500">
                        🔒 Tu información está protegida con encriptación de nivel empresarial
                    </p>
                </div>
                
                <!-- Requirements Info -->
                <div class="mt-6 text-left">
                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Requisitos de acceso:</h4>
                    <ul class="text-xs text-gray-600 space-y-1">
                        <li>• Correo institucional: @uth.edu.mx</li>
                        <li>• Contraseña: 8-15 caracteres</li>
                        <li>• Debe incluir: letras, números y símbolos</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Funcionalidad para mostrar/ocultar contraseña
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    </script>

    <!-- Service Worker Registration -->
    <script>
        // Register service worker
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('{{ asset("sw.js") }}')
                    .then(registration => {
                        console.log('ServiceWorker registrado correctamente:', registration.scope);
                        
                        // Check for updates
                        registration.addEventListener('updatefound', () => {
                            const newWorker = registration.installing;
                            newWorker.addEventListener('statechange', () => {
                                if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                    // Activar inmediatamente la nueva versión del SW
                                    registration.waiting && registration.waiting.postMessage({ type: 'SKIP_WAITING' });
                                    window.location.reload();
                                }
                            });
                        });
                        // Recargar en cambio de controlador
                        navigator.serviceWorker.addEventListener('controllerchange', () => {
                            window.location.reload();
                        });
                    })
                    .catch(error => {
                        console.log('Error al registrar ServiceWorker:', error);
                    });
            });
        }

        // Handle app install prompt
        let deferredPrompt;
        const installButton = document.createElement('button');
        installButton.textContent = 'Instalar Aplicación';
        installButton.className = 'fixed bottom-4 right-4 bg-uth-green text-white px-4 py-2 rounded-lg shadow-lg hover:bg-uth-green-dark transition-colors z-50';
        installButton.style.display = 'none';
        document.body.appendChild(installButton);

        window.addEventListener('beforeinstallprompt', (e) => {
            // Prevent the mini-infobar from appearing on mobile
            e.preventDefault();
            // Stash the event so it can be triggered later.
            deferredPrompt = e;
            // Update UI to notify the user they can install the PWA
            installButton.style.display = 'block';
        });

        installButton.addEventListener('click', async () => {
            // Hide the install button
            installButton.style.display = 'none';
            // Show the install prompt
            deferredPrompt.prompt();
            // Wait for the user to respond to the prompt
            const { outcome } = await deferredPrompt.userChoice;
            console.log(`User response to the install prompt: ${outcome}`);
            // We've used the prompt, and can't use it again, throw it away
            deferredPrompt = null;
        });

        window.addEventListener('appinstalled', () => {
            console.log('PWA was installed');
            installButton.style.display = 'none';
        });
    </script>
</body>
</html>
