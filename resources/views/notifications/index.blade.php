<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Notificaciones</h1>
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <div class="glass-effect rounded-xl shadow-lg border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-bell text-blue-600 mr-2"></i> Notificaciones
                </h2>
                <button onclick="markAllAsReadAllPage()" class="p-2 rounded-full bg-blue-50 hover:bg-blue-100 text-blue-600 hover:text-blue-800 transition" title="Marcar todas como leídas">
                    <i class="fas fa-check-double"></i>
                </button>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($notifications as $notification)
                    <div class="flex items-start space-x-4 px-6 py-4 {{ !$notification->read_at ? 'bg-blue-50' : '' }}">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center mt-1"
                             style="background: {{ 
                                $notification->type === 'new_message' ? 'linear-gradient(135deg,#a21caf,#6366f1)' : 
                                ($notification->type === 'message_reply' ? 'linear-gradient(135deg,#3b82f6,#6366f1)' :
                                ($notification->type === 'ticket_purchased' ? 'linear-gradient(135deg,#3b82f6,#6366f1)' : 
                                ($notification->type === 'event_created' ? 'linear-gradient(135deg,#22c55e,#16a34a)' : 
                                'linear-gradient(135deg,#f59e42,#fbbf24)')))
                             }}; color: white;">
                            <i class="fas {{
                                $notification->type === 'new_message' ? 'fa-envelope' :
                                ($notification->type === 'message_reply' ? 'fa-reply' :
                                ($notification->type === 'ticket_purchased' ? 'fa-ticket-alt' :
                                ($notification->type === 'event_created' ? 'fa-calendar' : 'fa-bell')))
                            }} text-lg"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <h3 class="text-base font-semibold text-gray-900">{{ $notification->title }}</h3>
                                @if(!$notification->read_at)
                                    <button onclick="markAsRead({{ $notification->id }}, this)" class="ml-2 p-1 rounded-full bg-blue-100 hover:bg-blue-200 text-blue-600 hover:text-blue-800 transition" title="Marcar como leída">
                                        <i class="fas fa-check"></i>
                                    </button>
                                @endif
                            </div>
                            <p class="text-gray-600 mt-1">{{ $notification->message }}</p>
                            <p class="text-xs text-gray-400 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center text-gray-400">
                        <i class="fas fa-bell text-3xl mb-3"></i>
                        <p>No tienes notificaciones.</p>
                    </div>
                @endforelse
            </div>
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>

    <script>
        function markAsRead(id, btn) {
            fetch(`/notifications/${id}/mark-as-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                    'Content-Type': 'application/json',
                }
            }).then(res => {
                if(res.ok) {
                    btn.closest('div.flex').classList.remove('bg-blue-50');
                    btn.remove();
                }
            });
        }
        
        function markAllAsReadAllPage() {
            fetch(`{{ route('notifications.read-all') }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                    'Content-Type': 'application/json',
                }
            }).then(res => { 
                if(res.ok) location.reload(); 
            });
        }
    </script>
</x-app-layout>