<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Casa Entradas') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600">
                           Wasi Tickets
                        </a>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 text-gray-900">
                            Inicio
                        </a>
                        <a href="{{ route('events.index') }}" class="inline-flex items-center px-1 pt-1 text-gray-500 hover:text-gray-900">
                            Eventos
                        </a>
                    </div>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    @auth
                        @if(!Auth::user()->hasRole('admin'))
                            <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                Registrar Evento
                            </a>
                        @endif
                        
                        <!-- Notifications -->
                        <div class="relative ml-3" x-data="notifications">
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
                        
                        <a href="{{ route('messages.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 ml-3">
                            <i class="fas fa-envelope mr-1"></i>
                            Mensajes
                        </a>
                        <div class="ml-3 relative">
                            <a href="{{ route('profile.edit') }}" class="text-gray-500 hover:text-gray-900">
                                {{ Auth::user()->name }}
                            </a>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="ml-3">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-gray-900">
                                Cerrar Sesión
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-900">Iniciar Sesión</a>
                        <a href="{{ route('register') }}" class="ml-4 text-gray-500 hover:text-gray-900">Registrarse</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{ $slot }}
        </div>
    </main>
    <footer class="bg-gradient-to-r from-gray-50 to-gray-100 text-center py-6 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col sm:flex-row items-center justify-between">
                <div class="text-gray-600 text-sm mb-2 sm:mb-0">
                    © {{ date('Y') }} EventSystem. Todos los derechos reservados.
                </div>
                <div class="flex items-center space-x-4 text-xs text-gray-500">
                    <span class="flex items-center">
                        <i class="fas fa-shield-alt mr-1"></i>
                        Sistema Seguro
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-clock mr-1"></i>
                        Disponible 24/7
                    </span>
                </div>
            </div>
        </div>
    </footer>

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
                unreadCount: {{ Auth::check() ? Auth::user()->unreadNotifications()->count() : 0 }},
                showReplyModal: false,
                replyForm: {
                    subject: '',
                    message: '',
                    recipientId: null,
                    originalMessageId: null
                },
                
                init() {
                    if ({{ Auth::check() ? 'true' : 'false' }}) {
                        this.loadNotifications();
                        this.startPolling();
                    }
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
                    
                    const diffInHours = Math.floor(diffInMinutes / 60);
                    if (diffInHours < 24) return `Hace ${diffInHours} h`;
                    
                    const diffInDays = Math.floor(diffInHours / 24);
                    if (diffInDays < 7) return `Hace ${diffInDays} días`;
                    
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
                        const response = await fetch('{{ route("messages.store") }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                subject: this.replyForm.subject,
                                message: this.replyForm.message,
                                to_user_id: this.replyForm.recipientId
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