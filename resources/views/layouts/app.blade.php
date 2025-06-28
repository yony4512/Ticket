<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50">
            <!-- Navigation -->
            <nav class="bg-white shadow-lg border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <!-- Logo and Brand -->
                        <div class="flex items-center">
                            <div class="flex-shrink-0 flex items-center">
                                <img src="{{ asset('imagenes/iconoboleto.png') }}" alt="Logo" class="w-10 h-10 mr-3">
                                <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                    Sistema de Eventos
                                </span>
                            </div>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden md:flex items-center space-x-8">
                            <a href="{{ route('home') }}" 
                               class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('home') ? 'text-blue-600 bg-blue-50' : '' }}">
                                <i class="fas fa-home mr-2"></i>
                                Inicio
                            </a>
                            <a href="{{ route('events.index') }}" 
                               class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('events.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                Eventos
                            </a>
                            <a href="{{ route('tickets.index') }}" 
                               class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('tickets.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                                <i class="fas fa-ticket-alt mr-2"></i>
                                Mis Tickets
                            </a>
                            @auth
                                @if(Auth::user()->hasRole('admin'))
                                    <a href="{{ route('admin.dashboard') }}" 
                                       class="text-gray-700 hover:text-purple-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                                        <i class="fas fa-crown mr-2"></i>
                                        Panel Admin
                                    </a>
                                @endif
                            @endauth
                        </div>

                        <!-- User Menu -->
                        <div class="flex items-center space-x-4">
                            @auth
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" 
                                            class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-full flex items-center justify-center">
                                            <span class="text-white text-sm font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                        </div>
                                        <span class="ml-2 text-gray-700 font-medium hidden md:block">{{ Auth::user()->name }}</span>
                                        <i class="fas fa-chevron-down ml-1 text-gray-400"></i>
                                    </button>

                                    <div x-show="open" @click.away="open = false" 
                                         x-transition:enter="transition ease-out duration-100"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-75"
                                         x-transition:leave-start="transform opacity-100 scale-100"
                                         x-transition:leave-end="transform opacity-0 scale-95"
                                         class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                        <a href="{{ route('profile.edit') }}" 
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-user mr-2"></i>
                                            Perfil
                                        </a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" 
                                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <i class="fas fa-sign-out-alt mr-2"></i>
                                                Cerrar Sesión
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                                    <i class="fas fa-sign-in-alt mr-2"></i>
                                    Iniciar Sesión
                                </a>
                                <a href="{{ route('register') }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                    <i class="fas fa-user-plus mr-2"></i>
                                    Registrarse
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="py-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    @isset($header)
                        <div class="mb-8">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $header }}</h1>
                            @isset($subtitle)
                                <p class="text-gray-600">{{ $subtitle }}</p>
                            @endisset
                        </div>
                    @endisset

                    {{ $slot }}
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 mt-16">
                <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                    <div class="text-center">
                        <p class="text-gray-500 text-sm">
                            © {{ date('Y') }} Sistema de Gestión de Eventos. Todos los derechos reservados.
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
