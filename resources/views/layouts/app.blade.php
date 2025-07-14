<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Casa Entradas') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        <link rel="icon" type="image/png" href="{{ asset('imagenes/iconoboleto.png') }}">

        <!-- PWA Manifest -->
        <link rel="manifest" href="{{ asset('manifest.json') }}">
        <meta name="theme-color" content="#3b82f6">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta name="apple-mobile-web-app-title" content="Casa Entradas">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;900&display=swap" rel="stylesheet" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Alpine.js -->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

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
                            <div class="flex items-center">
                                <img src="{{ asset('imagenes/iconoboleto.png') }}" alt="Logo" class="h-8 w-auto mr-3">
                                <span class="text-2xl font-extrabold" style="font-family: 'Montserrat', cursive; background: linear-gradient(90deg, #7c3aed 0%, #2563eb 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: 2px;">Casa Entradas</span>
                            </div>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden md:flex items-center space-x-8">
                            <a href="{{ route('home') }}" 
                               class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('home') ? 'text-blue-600 bg-blue-50' : '' }}">
                                <i class="fas fa-home mr-2"></i>
                                Inicio
                            </a>
                            @auth
                                <a href="{{ route('dashboard') }}" 
                                   class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:from-blue-700 hover:to-indigo-700 px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 shadow-lg hover:shadow-xl {{ request()->routeIs('dashboard') ? 'ring-2 ring-blue-300' : '' }}">
                                    <i class="fas fa-tachometer-alt mr-2"></i>
                                    Mis Eventos
                                </a>
                            @endauth
                            <a href="{{ route('events.index') }}" 
                               class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('events.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                Eventos
                            </a>
                            @auth
                                <a href="{{ route('tickets.index') }}" 
                                   class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('tickets.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                                    <i class="fas fa-ticket-alt mr-2"></i>
                                    Mis Tickets
                                </a>
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
                                <!-- Notifications -->
                                <div class="relative" x-data="notifications">
                                    <button @click="open = !open" class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-all duration-200">
                                        <i class="fas fa-bell text-lg"></i>
                                        <span x-show="unreadCount > 0" 
                                              x-text="unreadCount > 99 ? '99+' : unreadCount"
                                              class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-medium"></span>
                                    </button>

                                    <!-- Notifications Dropdown -->
                                    <div x-show="open" @click.away="open = false" x-transition 
                                         class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                                        <div class="px-4 py-2 border-b border-gray-200 flex items-center justify-between">
                                            <h3 class="text-sm font-semibold text-gray-900">Notificaciones</h3>
                                            <div class="flex items-center space-x-2">
                                                <button @click="markAllAsRead()" class="text-xs text-blue-600 hover:text-blue-800">
                                                    Marcar todas
                                                </button>
                                                <a href="{{ route('notifications.index') }}" class="text-xs text-blue-600 hover:text-blue-800">
                                                    Ver todas
                                                </a>
                                            </div>
                                        </div>
                                        
                                        <!-- Notifications List -->
                                        <div class="max-h-64 overflow-y-auto">
                                            <template x-if="notifications && notifications.length > 0">
                                                <div class="divide-y divide-gray-100">
                                                    <template x-for="notification in notifications" :key="notification.id">
                                                        <div class="px-4 py-3 hover:bg-gray-50 transition-colors"
                                                             :class="{ 'bg-blue-50': !notification.read_at }">
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
                                                                        <button @click="markAsRead(notification.id)" 
                                                                                class="text-xs text-blue-600 hover:text-blue-800">
                                                                            Marcar como leída
                                                                        </button>
                                                                        <button @click="replyToMessage(notification)" 
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
                            {!! $header !!}
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
                        <p class="text-center text-gray-600 text-sm">
                            © {{ date('Y') }} Casa Entradas. Todos los derechos reservados.
                        </p>
                    </div>
                </div>
            </footer>
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
                                                    class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors">
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

        <!-- Alpine.js Notifications Component -->
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('notifications', () => ({
                    open: false,
                    notifications: [],
                    unreadCount: 0,
                    showReplyModal: false,
                    replyForm: {
                        subject: '',
                        message: '',
                        recipient_id: null
                    },

                    init() {
                        this.loadNotifications();
                        // Actualizar cada 30 segundos
                        setInterval(() => this.loadNotifications(), 30000);
                    },

                    async loadNotifications() {
                        try {
                            const response = await fetch('{{ route("notifications.recent") }}');
                            const data = await response.json();
                            this.notifications = data.notifications;
                            this.unreadCount = data.unread_count;
                        } catch (error) {
                            console.error('Error loading notifications:', error);
                        }
                    },

                    async markAsRead(notificationId) {
                        try {
                            const response = await fetch(`/notifications/${notificationId}/mark-as-read`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Content-Type': 'application/json',
                                }
                            });
                            
                            if (response.ok) {
                                this.loadNotifications();
                            }
                        } catch (error) {
                            console.error('Error marking notification as read:', error);
                        }
                    },

                    async markAllAsRead() {
                        try {
                            const response = await fetch('/notifications/mark-all-as-read', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Content-Type': 'application/json',
                                }
                            });
                            
                            if (response.ok) {
                                this.loadNotifications();
                            }
                        } catch (error) {
                            console.error('Error marking all notifications as read:', error);
                        }
                    },

                    replyToMessage(notification) {
                        this.replyForm.subject = `Re: ${notification.title}`;
                        this.replyForm.message = '';
                        this.replyForm.recipient_id = notification.data?.sender_id || notification.data?.user_id;
                        this.showReplyModal = true;
                    },

                    closeReplyModal() {
                        this.showReplyModal = false;
                        this.replyForm = {
                            subject: '',
                            message: '',
                            recipient_id: null
                        };
                    },

                    async sendReply() {
                        try {
                            const response = await fetch('/messages', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify(this.replyForm)
                            });
                            
                            if (response.ok) {
                                this.closeReplyModal();
                                this.loadNotifications();
                                // Mostrar mensaje de éxito
                                alert('Mensaje enviado correctamente');
                            } else {
                                const error = await response.json();
                                alert('Error al enviar mensaje: ' + (error.message || 'Error desconocido'));
                            }
                        } catch (error) {
                            console.error('Error sending reply:', error);
                            alert('Error al enviar mensaje');
                        }
                    },

                    formatDate(dateString) {
                        const date = new Date(dateString);
                        const now = new Date();
                        const diffInHours = (now - date) / (1000 * 60 * 60);
                        
                        if (diffInHours < 1) {
                            return 'Hace unos minutos';
                        } else if (diffInHours < 24) {
                            return `Hace ${Math.floor(diffInHours)} horas`;
                        } else {
                            return date.toLocaleDateString('es-ES');
                        }
                    }
                }));
            });
        </script>
        @stack('scripts')
    </body>
</html>
