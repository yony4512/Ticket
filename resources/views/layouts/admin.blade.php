<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Panel de Administración') - Wasi Tickets</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .sidebar-collapsed {
            width: 4rem;
        }
        .sidebar-expanded {
            width: 16rem;
        }
        .content-transition {
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #3730a3 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .nav-item {
            position: relative;
            overflow: hidden;
        }
        .nav-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s;
        }
        .nav-item:hover::before {
            left: 100%;
        }
        @media (max-width: 1024px) {
            .sidebar-expanded {
                width: 100%;
                position: fixed;
                z-index: 50;
            }
            .content-transition {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen">
    <div class="min-h-screen flex" x-data="{ sidebarOpen: false, sidebarCollapsed: false }">
        <!-- Sidebar -->
        <div class="bg-gradient-to-b from-slate-900 via-blue-900 to-slate-900 text-white sidebar-transition sidebar-expanded min-h-screen flex-shrink-0 fixed z-40 shadow-2xl"
             :class="{ 'sidebar-collapsed': sidebarCollapsed && !sidebarOpen, 'sidebar-expanded': !sidebarCollapsed || sidebarOpen, 'left-0': sidebarOpen, '-left-full': !sidebarOpen && window.innerWidth < 1024 }"
             x-show="sidebarOpen || window.innerWidth >= 1024"
             @keydown.window.escape="sidebarOpen = false"
             @click.away="if(window.innerWidth < 1024) sidebarOpen = false"
             style="top:0; bottom:0; left:0; transition:left 0.3s;">
            
            <!-- Toggle Button -->
            <div class="absolute -right-3 top-6 bg-white rounded-full p-2 shadow-lg cursor-pointer z-50 hover:shadow-xl transition-all duration-300 hover:scale-110"
                 @click="sidebarCollapsed = !sidebarCollapsed; sidebarOpen = false">
                <i class="fas fa-chevron-left text-gray-600 text-sm transition-transform duration-300"
                   :class="{ 'rotate-180': sidebarCollapsed }"></i>
            </div>

            <div class="p-6" :class="{ 'px-3': sidebarCollapsed && !sidebarOpen }">
                <div class="flex items-center space-x-4" :class="{ 'justify-center': sidebarCollapsed && !sidebarOpen }">
                    <div class="w-16 h-16 flex items-center justify-center flex-shrink-0">
                        <img src="{{ asset('imagenes/iconoboleto.png') }}" alt="Icono" class="w-14 h-14">
                    </div>
                    <div x-show="!sidebarCollapsed || sidebarOpen" x-transition class="flex-1">
                        <h1 class="text-xl font-bold bg-gradient-to-r from-white to-blue-200 bg-clip-text text-transparent">Admin Panel</h1>
                        <p class="text-slate-300 text-sm">Wasi Tickets</p>
                    </div>
                </div>
            </div>

            <nav class="mt-8 px-3">
                <div class="mb-6" x-show="!sidebarCollapsed || sidebarOpen" x-transition>
                    <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-3">GESTIÓN</p>
                </div>

                <a href="{{ route('admin.dashboard') }}" 
                   class="nav-item flex items-center px-4 py-3 text-slate-300 hover:bg-gradient-to-r hover:from-blue-800 hover:to-indigo-800 hover:text-white transition-all duration-300 rounded-xl mb-2 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg' : '' }}"
                   :class="{ 'justify-center px-3': sidebarCollapsed && !sidebarOpen }">
                    <i class="fas fa-tachometer-alt w-5 h-5 mr-4 flex-shrink-0" :class="{ 'mr-0': sidebarCollapsed && !sidebarOpen }"></i>
                    <span x-show="!sidebarCollapsed || sidebarOpen" x-transition class="text-sm font-medium">Dashboard</span>
                </a>

                <a href="{{ route('admin.users.index') }}" 
                   class="nav-item flex items-center px-4 py-3 text-slate-300 hover:bg-gradient-to-r hover:from-blue-800 hover:to-indigo-800 hover:text-white transition-all duration-300 rounded-xl mb-2 {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg' : '' }}"
                   :class="{ 'justify-center px-3': sidebarCollapsed && !sidebarOpen }">
                    <i class="fas fa-users w-5 h-5 mr-4 flex-shrink-0" :class="{ 'mr-0': sidebarCollapsed && !sidebarOpen }"></i>
                    <span x-show="!sidebarCollapsed || sidebarOpen" x-transition class="text-sm font-medium">Usuarios</span>
                </a>

                <a href="{{ route('admin.events.index') }}" 
                   class="nav-item flex items-center px-4 py-3 text-slate-300 hover:bg-gradient-to-r hover:from-blue-800 hover:to-indigo-800 hover:text-white transition-all duration-300 rounded-xl mb-2 {{ request()->routeIs('admin.events.*') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg' : '' }}"
                   :class="{ 'justify-center px-3': sidebarCollapsed && !sidebarOpen }">
                    <i class="fas fa-calendar-alt w-5 h-5 mr-4 flex-shrink-0" :class="{ 'mr-0': sidebarCollapsed && !sidebarOpen }"></i>
                    <span x-show="!sidebarCollapsed || sidebarOpen" x-transition class="text-sm font-medium">Eventos</span>
                </a>

                <a href="{{ route('admin.tickets.index') }}" 
                   class="nav-item flex items-center px-4 py-3 text-slate-300 hover:bg-gradient-to-r hover:from-blue-800 hover:to-indigo-800 hover:text-white transition-all duration-300 rounded-xl mb-2 {{ request()->routeIs('admin.tickets.*') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg' : '' }}"
                   :class="{ 'justify-center px-3': sidebarCollapsed && !sidebarOpen }">
                    <i class="fas fa-ticket-alt w-5 h-5 mr-4 flex-shrink-0" :class="{ 'mr-0': sidebarCollapsed && !sidebarOpen }"></i>
                    <span x-show="!sidebarCollapsed || sidebarOpen" x-transition class="text-sm font-medium">Tickets</span>
                </a>

                <div class="mt-8 mb-6" x-show="!sidebarCollapsed || sidebarOpen" x-transition>
                    <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-3">COMUNICACIÓN</p>
                </div>

                <a href="{{ route('admin.messages.index') }}" 
                   class="nav-item flex items-center px-4 py-3 text-slate-300 hover:bg-gradient-to-r hover:from-blue-800 hover:to-indigo-800 hover:text-white transition-all duration-300 rounded-xl mb-2 {{ request()->routeIs('admin.messages.*') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg' : '' }}"
                   :class="{ 'justify-center px-3': sidebarCollapsed && !sidebarOpen }">
                    <i class="fas fa-envelope w-5 h-5 mr-4 flex-shrink-0" :class="{ 'mr-0': sidebarCollapsed && !sidebarOpen }"></i>
                    <span x-show="!sidebarCollapsed || sidebarOpen" x-transition class="text-sm font-medium">Mensajes</span>
                    @if(Auth::user()->unreadMessages()->count() > 0)
                        <span class="ml-auto bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs rounded-full px-2 py-1 animate-pulse" x-show="!sidebarCollapsed || sidebarOpen">
                            {{ Auth::user()->unreadMessages()->count() }}
                        </span>
                    @endif
                </a>

                <div class="mt-8 mb-6" x-show="!sidebarCollapsed || sidebarOpen" x-transition>
                    <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-3">ANÁLISIS</p>
                </div>

                <a href="{{ route('admin.reports') }}" 
                   class="nav-item flex items-center px-4 py-3 text-slate-300 hover:bg-gradient-to-r hover:from-blue-800 hover:to-indigo-800 hover:text-white transition-all duration-300 rounded-xl mb-2 {{ request()->routeIs('admin.reports') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg' : '' }}"
                   :class="{ 'justify-center px-3': sidebarCollapsed && !sidebarOpen }">
                    <i class="fas fa-chart-bar w-5 h-5 mr-4 flex-shrink-0" :class="{ 'mr-0': sidebarCollapsed && !sidebarOpen }"></i>
                    <span x-show="!sidebarCollapsed || sidebarOpen" x-transition class="text-sm font-medium">Reportes</span>
                </a>

                <a href="{{ route('admin.settings') }}" 
                   class="nav-item flex items-center px-4 py-3 text-slate-300 hover:bg-gradient-to-r hover:from-blue-800 hover:to-indigo-800 hover:text-white transition-all duration-300 rounded-xl mb-2 {{ request()->routeIs('admin.settings') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg' : '' }}"
                   :class="{ 'justify-center px-3': sidebarCollapsed && !sidebarOpen }">
                    <i class="fas fa-cog w-5 h-5 mr-4 flex-shrink-0" :class="{ 'mr-0': sidebarCollapsed && !sidebarOpen }"></i>
                    <span x-show="!sidebarCollapsed || sidebarOpen" x-transition class="text-sm font-medium">Configuración</span>
                </a>
            </nav>

            <!-- User Info -->
            <div class="absolute bottom-0 left-0 right-0 p-6 border-t border-slate-700" x-show="!sidebarCollapsed || sidebarOpen" x-transition>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-700 rounded-full flex items-center justify-center flex-shrink-0 shadow-lg overflow-hidden">
                        @if(Auth::user()->profile_photo_path)
                            <img src="{{ Auth::user()->profile_photo_url }}" alt="Perfil" class="w-10 h-10 rounded-full object-cover">
                        @else
                            <i class="fas fa-user text-white text-sm"></i>
                        @endif
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-300">Administrador</p>
                    </div>
                </div>
                <a href="{{ route('home') }}" class="block mt-3 text-xs text-slate-300 hover:text-white transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver al sitio
                </a>
            </div>
        </div>

        <!-- Mobile Overlay -->
        <div x-show="sidebarOpen && window.innerWidth < 1024" @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden transition-opacity duration-300"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col content-transition w-full"
             :class="{ 'lg:ml-16': sidebarCollapsed && !sidebarOpen, 'lg:ml-64': !sidebarCollapsed || sidebarOpen }">
            
            <!-- Top Navigation -->
            <header class="glass-effect shadow-lg border-b border-gray-200 sticky top-0 z-20">
                <div class="flex items-center justify-between px-4 lg:px-6 py-4">
                    <!-- Mobile Menu Button -->
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <div class="flex-1 text-center lg:text-left">
                        <h2 class="text-xl lg:text-2xl font-bold bg-gradient-to-r from-slate-900 via-blue-800 to-indigo-800 bg-clip-text text-transparent">@yield('title', 'Panel de Administración')</h2>
                        @hasSection('subtitle')
                            <div class="mt-1">
                                @yield('subtitle')
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center space-x-2 lg:space-x-4">
                        <!-- Notifications -->
                        <div class="relative" x-data="notifications">
                            <button @click="open = !open" 
                                    class="p-2 lg:p-3 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg lg:rounded-xl transition-all duration-200 relative">
                                <i class="fas fa-bell text-lg lg:text-xl"></i>
                                <span x-show="unreadCount > 0" 
                                      class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 lg:w-6 lg:h-6 flex items-center justify-center animate-pulse">
                                    <span x-text="unreadCount"></span>
                                </span>
                            </button>

                            <!-- Notifications Dropdown -->
                            <div x-show="open" @click.away="open = false" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-80 lg:w-96 bg-white rounded-xl shadow-xl border border-gray-200 py-2 z-50">
                                
                                <!-- Header -->
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-semibold text-gray-900">Notificaciones</h3>
                                        <div class="flex items-center space-x-2">
                                            <button @click="markAllAsRead()" 
                                                    class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-full transition-all duration-200"
                                                    title="Marcar todas como leídas">
                                                <i class="fas fa-check-double text-sm"></i>
                                            </button>
                                            <a href="{{ route('notifications.index') }}" 
                                               class="p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-full transition-all duration-200"
                                               title="Ver todas">
                                                <i class="fas fa-eye text-sm"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Notifications List -->
                                <div class="max-h-96 overflow-y-auto">
                                    <template x-if="notifications && notifications.length > 0">
                                        <div>
                                            <template x-for="notification in notifications" :key="notification.id">
                                                <div class="px-4 py-3 hover:bg-gray-50 cursor-pointer transition-colors"
                                                     :class="{ 'bg-blue-50': !notification.read_at }"
                                                     @click="markAsRead(notification.id)">
                                                    <div class="flex items-start space-x-3">
                                                        <div class="flex-shrink-0">
                                                            <div class="w-8 h-8 rounded-full flex items-center justify-center"
                                                                 :class="{
                                                                     'bg-blue-100 text-blue-600': notification.type === 'ticket_purchased',
                                                                     'bg-green-100 text-green-600': notification.type === 'event_created',
                                                                     'bg-purple-100 text-purple-600': notification.type === 'new_message',
                                                                     'bg-indigo-100 text-indigo-600': notification.type === 'message_reply',
                                                                     'bg-yellow-100 text-yellow-600': notification.type === 'system'
                                                                 }">
                                                                <i class="fas text-sm"
                                                                   :class="{
                                                                       'fa-ticket-alt': notification.type === 'ticket_purchased',
                                                                       'fa-calendar': notification.type === 'event_created',
                                                                       'fa-envelope': notification.type === 'new_message',
                                                                       'fa-reply': notification.type === 'message_reply',
                                                                       'fa-bell': notification.type === 'system'
                                                                   }"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-sm font-medium text-gray-900" x-text="notification.title"></p>
                                                            <p class="text-sm text-gray-600 mt-1" x-text="notification.message"></p>
                                                            <p class="text-xs text-gray-400 mt-2" x-text="formatDate(notification.created_at)"></p>
                                                            
                                                            <!-- Botones de acción para notificaciones de mensajes -->
                                                            <div x-show="notification.type === 'new_message' || notification.type === 'message_reply'" 
                                                                 class="flex items-center space-x-2 mt-2">
                                                                <button @click.stop="replyToMessage(notification)" 
                                                                        class="text-xs text-green-600 hover:text-green-800">
                                                                    Responder
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <div x-show="!notification.read_at" 
                                                                 class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </template>
                                    
                                    <template x-if="!notifications || notifications.length === 0">
                                        <div class="px-4 py-8 text-center">
                                            <i class="fas fa-bell text-gray-300 text-3xl mb-3"></i>
                                            <p class="text-gray-500 text-sm">No hay notificaciones</p>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 lg:space-x-3 p-2 lg:p-3 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg lg:rounded-xl transition-all duration-200">
                                <div class="w-8 h-8 lg:w-10 lg:h-10 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-700 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white text-xs lg:text-sm"></i>
                                </div>
                                <span class="hidden lg:block text-sm font-medium">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 lg:w-56 bg-white rounded-lg lg:rounded-xl shadow-lg lg:shadow-xl border border-gray-200 py-2 z-50">
                                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 lg:py-3 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-user-edit mr-2 lg:mr-3 text-blue-600"></i>
                                    Perfil
                                </a>
                                <a href="{{ route('home') }}" class="flex items-center px-4 py-2 lg:py-3 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-home mr-2 lg:mr-3 text-blue-600"></i>
                                    Ir al sitio
                                </a>
                                <hr class="my-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full text-left px-4 py-2 lg:py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                        <i class="fas fa-sign-out-alt mr-2 lg:mr-3"></i>
                                        Cerrar sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 p-4 lg:p-6 xl:p-8">
                <div class="w-full">
                    @if(session('success'))
                        <div class="mb-6 lg:mb-8 p-4 lg:p-6 bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-lg lg:rounded-xl shadow-lg">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-3 lg:mr-4 text-xl lg:text-2xl"></i>
                                <span class="text-base lg:text-lg">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 lg:mb-8 p-4 lg:p-6 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-lg lg:rounded-xl shadow-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle mr-3 lg:mr-4 text-xl lg:text-2xl"></i>
                                <span class="text-base lg:text-lg">{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Modal de Respuesta -->
    <div x-show="showReplyModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeReplyModal()"></div>
            
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-10 sm:w-10 bg-green-100">
                            <i class="fas fa-reply text-green-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Responder Mensaje</h3>
                            <div class="mt-2">
                                <form @submit.prevent="sendReply()">
                                    <div class="mb-4">
                                        <label for="replySubject" class="block text-sm font-medium text-gray-700 mb-2">
                                            Asunto
                                        </label>
                                        <input type="text" 
                                               id="replySubject" 
                                               x-model="replyForm.subject"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                               required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="replyMessage" class="block text-sm font-medium text-gray-700 mb-2">
                                            Mensaje
                                        </label>
                                        <textarea id="replyMessage" 
                                                  x-model="replyForm.message"
                                                  rows="4"
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                  required></textarea>
                                    </div>
                                    <div class="flex justify-end space-x-3">
                                        <button type="button" 
                                                @click="closeReplyModal()"
                                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                            Cancelar
                                        </button>
                                        <button type="submit" 
                                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                                            Enviar Respuesta
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications JavaScript -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('notifications', () => ({
                open: false,
                notifications: [],
                unreadCount: {{ Auth::user()->unreadNotifications()->count() }},
                showReplyModal: false,
                replyForm: {
                    subject: '',
                    message: '',
                    recipientId: null,
                    originalMessageId: null
                },
                
                init() {
                    this.loadNotifications();
                    this.startPolling();
                },
                
                async loadNotifications() {
                    try {
                        const response = await fetch('{{ route("notifications.recent") }}');
                        const data = await response.json();
                        this.notifications = data.notifications;
                    } catch (error) {
                        console.error('Error loading notifications:', error);
                    }
                },
                
                async markAsRead(notificationId) {
                    try {
                        const response = await fetch(`/notifications/${notificationId}/read`, {
                            method: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json',
                            }
                        });
                        
                        if (response.ok) {
                            // Update notification in list
                            const notification = this.notifications.find(n => n.id === notificationId);
                            if (notification) {
                                notification.read_at = new Date().toISOString();
                            }
                            
                            // Update unread count
                            this.updateUnreadCount();
                        }
                    } catch (error) {
                        console.error('Error marking notification as read:', error);
                    }
                },
                
                async markAllAsRead() {
                    try {
                        const response = await fetch('{{ route("notifications.read-all") }}', {
                            method: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json',
                            }
                        });
                        
                        if (response.ok) {
                            // Mark all notifications as read in the list
                            this.notifications.forEach(notification => {
                                notification.read_at = new Date().toISOString();
                            });
                            
                            // Update unread count
                            this.updateUnreadCount();
                        }
                    } catch (error) {
                        console.error('Error marking all notifications as read:', error);
                    }
                },
                
                async updateUnreadCount() {
                    try {
                        const response = await fetch('{{ route("notifications.unread-count") }}');
                        const data = await response.json();
                        this.unreadCount = data.count;
                    } catch (error) {
                        console.error('Error updating unread count:', error);
                    }
                },
                
                startPolling() {
                    // Update notifications every 30 seconds
                    setInterval(() => {
                        this.loadNotifications();
                        this.updateUnreadCount();
                    }, 30000);
                },
                
                formatDate(dateString) {
                    const date = new Date(dateString);
                    const now = new Date();
                    const diffInMinutes = Math.floor((now - date) / (1000 * 60));
                    
                    if (diffInMinutes < 1) return 'Ahora';
                    if (diffInMinutes < 60) return `Hace ${diffInMinutes} min`;
                    if (diffInMinutes < 1440) return `Hace ${Math.floor(diffInMinutes / 60)}h`;
                    return date.toLocaleDateString('es-ES');
                },
                
                replyToMessage(notification) {
                    // Extraer información del mensaje original
                    const data = notification.data || {};
                    this.replyForm.recipientId = data.sender_id;
                    this.replyForm.originalMessageId = data.message_id;
                    
                    // Pre-llenar el asunto con "Re:"
                    const originalSubject = data.subject || notification.title;
                    this.replyForm.subject = originalSubject.startsWith('Re:') ? originalSubject : `Re: ${originalSubject}`;
                    this.replyForm.message = '';
                    
                    this.showReplyModal = true;
                    this.open = false; // Cerrar el dropdown de notificaciones
                },
                
                closeReplyModal() {
                    this.showReplyModal = false;
                    this.replyForm = {
                        subject: '',
                        message: '',
                        recipientId: null,
                        originalMessageId: null
                    };
                },
                
                async sendReply() {
                    try {
                        const response = await fetch('{{ route("admin.users.send-message") }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                user_id: this.replyForm.recipientId,
                                subject: this.replyForm.subject,
                                message: this.replyForm.message
                            })
                        });
                        
                        if (response.ok) {
                            this.closeReplyModal();
                            // Recargar notificaciones
                            this.loadNotifications();
                            this.updateUnreadCount();
                            
                            // Mostrar mensaje de éxito
                            alert('Respuesta enviada exitosamente');
                        } else {
                            const error = await response.json();
                            alert('Error al enviar la respuesta: ' + (error.message || 'Error desconocido'));
                        }
                    } catch (error) {
                        console.error('Error sending reply:', error);
                        alert('Error al enviar la respuesta');
                    }
                }
            }));
        });
    </script>
</body>
</html> 