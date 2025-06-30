@extends('layouts.admin')

@section('title', 'Gestión de Tickets')

@section('content')
<div class="space-y-4 sm:space-y-6" x-data="ticketActions()">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-slate-900 via-blue-800 to-indigo-800 bg-clip-text text-transparent">
            Gestión de Tickets
        </h1>
            <p class="text-gray-600 mt-2 text-sm sm:text-base">Administra todos los tickets del sistema</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div class="glass-effect rounded-xl p-4 sm:p-6 shadow-lg border border-gray-200 card-hover">
            <div class="flex items-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-700 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-ticket-alt text-white text-lg sm:text-xl"></i>
                </div>
                <div class="ml-3 sm:ml-4">
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Total Tickets</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $tickets->total() }}</p>
                </div>
            </div>
        </div>

        <div class="glass-effect rounded-xl p-4 sm:p-6 shadow-lg border border-gray-200 card-hover">
            <div class="flex items-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-green-600 via-green-700 to-emerald-700 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-check-circle text-white text-lg sm:text-xl"></i>
                </div>
                <div class="ml-3 sm:ml-4">
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Confirmados</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $confirmedTickets }}</p>
                </div>
            </div>
        </div>

        <div class="glass-effect rounded-xl p-4 sm:p-6 shadow-lg border border-gray-200 card-hover">
            <div class="flex items-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-yellow-600 via-yellow-700 to-orange-700 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-clock text-white text-lg sm:text-xl"></i>
                </div>
                <div class="ml-3 sm:ml-4">
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Pendientes</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $pendingTickets }}</p>
                </div>
            </div>
        </div>

        <div class="glass-effect rounded-xl p-4 sm:p-6 shadow-lg border border-gray-200 card-hover">
            <div class="flex items-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-purple-600 via-purple-700 to-indigo-700 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-dollar-sign text-white text-lg sm:text-xl"></i>
                </div>
                <div class="ml-3 sm:ml-4">
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Ingresos</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">S/. {{ number_format($totalRevenue, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="glass-effect rounded-xl p-4 sm:p-6 shadow-lg border border-gray-200">
        <form method="GET" action="{{ route('admin.tickets.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-search mr-2 text-blue-600"></i>
                    Buscar
                </label>
                <input type="text" name="search" id="search" 
                           class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-sm"
                       placeholder="Buscar tickets..."
                       value="{{ request('search') }}">
            </div>
            
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-toggle-on mr-2 text-green-600"></i>
                    Estado
                </label>
                <select name="status" id="status" 
                            class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option value="">Todos los estados</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmado</option>
                    <option value="used" {{ request('status') == 'used' ? 'selected' : '' }}>Usado</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                </select>
            </div>
            
            <div>
                <label for="event" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar mr-2 text-purple-600"></i>
                    Evento
                </label>
                <select name="event" id="event" 
                            class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option value="">Todos los eventos</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}" {{ request('event') == $event->id ? 'selected' : '' }}>
                            {{ $event->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex items-end">
                <button type="submit" 
                            class="w-full px-3 sm:px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-300 text-sm">
                    <i class="fas fa-filter mr-2"></i>
                        <span class="hidden sm:inline">Filtrar</span>
                        <span class="sm:hidden">Buscar</span>
                </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Tickets Table -->
    <div class="glass-effect rounded-xl shadow-lg border border-gray-200">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900">Tickets ({{ $tickets->total() }})</h3>
        </div>

        @if($tickets->isEmpty())
            <div class="p-8 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-ticket-alt text-gray-400 text-2xl"></i>
                </div>
                <p class="text-gray-500 text-base">No se encontraron tickets</p>
                <p class="text-gray-400 text-sm mt-1">Intenta ajustar los filtros de búsqueda</p>
            </div>
        @else
            <!-- Vista de Tarjetas para Móvil y Tablet -->
            <div class="block lg:hidden">
                @foreach($tickets as $ticket)
                    <div class="p-4 sm:p-6 border-b border-gray-200 last:border-b-0">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-700 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-ticket-alt text-white text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-sm font-medium text-gray-900 truncate">{{ $ticket->ticket_code }}</h4>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                        {{ $ticket->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                           ($ticket->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($ticket->status === 'used' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800')) }}">
                                        <i class="fas fa-circle mr-1 text-xs"></i>
                                        {{ ucfirst($ticket->status) }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 mb-2">{{ $ticket->event->title }}</p>
                                <div class="flex items-center space-x-4 text-xs text-gray-500 mb-3">
                                    <span>{{ $ticket->user->name }}</span>
                                    <span>{{ $ticket->quantity }} ticket(s)</span>
                                    <span>S/. {{ number_format($ticket->total_price, 2) }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.tickets.show', $ticket) }}" 
                                       class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-2 py-1 rounded text-xs transition-all duration-200">
                                        <i class="fas fa-eye mr-1"></i>
                                        Ver
                                    </a>
                                    @if($ticket->status === 'confirmed')
                                        <button type="button" 
                                                @click="confirmMarkAsUsed({{ $ticket->id }}, '{{ $ticket->ticket_code }}')"
                                                class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 px-2 py-1 rounded text-xs transition-all duration-200">
                                            <i class="fas fa-check mr-1"></i>
                                            Usar
                                        </button>
                                    @endif
                                    @if($ticket->status === 'pending')
                                        <button type="button" 
                                                @click="confirmCancel({{ $ticket->id }}, '{{ $ticket->ticket_code }}')"
                                                class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-2 py-1 rounded text-xs transition-all duration-200">
                                            <i class="fas fa-times mr-1"></i>
                                            Cancelar
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Vista de Tabla para Desktop -->
            <div class="hidden lg:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ticket
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Evento
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Comprador
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fecha Compra
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Precio
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($tickets as $ticket)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-700 rounded-lg flex items-center justify-center flex-shrink-0 mr-3">
                                        <i class="fas fa-ticket-alt text-white text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $ticket->ticket_code }}</div>
                                        <div class="text-sm text-gray-500">{{ $ticket->quantity }} ticket(s)</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $ticket->event->title }}</div>
                                <div class="text-sm text-gray-500">{{ $ticket->event->event_date->format('d/m/Y H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $ticket->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $ticket->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $ticket->purchased_at->format('d/m/Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $ticket->purchased_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">S/. {{ number_format($ticket->total_price, 2) }}</div>
                                    <div class="text-sm text-gray-500">S/. {{ number_format($ticket->total_price / $ticket->quantity, 2) }} c/u</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $ticket->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                       ($ticket->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($ticket->status === 'used' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800')) }}">
                                    <i class="fas fa-circle mr-1 text-xs"></i>
                                    {{ ucfirst($ticket->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.tickets.show', $ticket) }}" 
                                       class="text-blue-600 hover:text-blue-900 p-2 rounded-lg hover:bg-blue-50 transition-all duration-200">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($ticket->status === 'confirmed')
                                        <button type="button" 
                                                @click="confirmMarkAsUsed({{ $ticket->id }}, '{{ $ticket->ticket_code }}')"
                                                class="text-green-600 hover:text-green-900 p-2 rounded-lg hover:bg-green-50 transition-all duration-200">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @endif
                                    @if($ticket->status === 'pending')
                                        <button type="button" 
                                                @click="confirmCancel({{ $ticket->id }}, '{{ $ticket->ticket_code }}')"
                                                class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-50 transition-all duration-200">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                </tbody>
            </table>
        </div>
        
        @if($tickets->hasPages())
                <div class="px-4 sm:px-6 py-4 border-t border-gray-200">
                {{ $tickets->links() }}
            </div>
            @endif
        @endif
    </div>

    <!-- Modal de Confirmación -->
    <div x-show="showModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeModal()"></div>
            
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-10 sm:w-10"
                             :class="modalType === 'cancel' ? 'bg-red-100' : 'bg-green-100'">
                            <i class="fas" 
                               :class="modalType === 'cancel' ? 'fa-exclamation-triangle text-red-600' : 'fa-check text-green-600'"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" x-text="modalTitle"></h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500" x-text="modalMessage"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form :action="modalAction" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200"
                                :class="modalType === 'cancel' ? 'bg-red-600 hover:bg-red-700 focus:ring-red-500' : 'bg-green-600 hover:bg-green-700 focus:ring-green-500'">
                            <span x-text="modalConfirmText"></span>
                        </button>
                    </form>
                    <button type="button" 
                            @click="closeModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function ticketActions() {
    return {
        showModal: false,
        modalType: '',
        modalTitle: '',
        modalMessage: '',
        modalAction: '',
        modalConfirmText: '',
        
        confirmMarkAsUsed(ticketId, ticketCode) {
            this.modalType = 'mark-as-used';
            this.modalTitle = 'Marcar como Usado';
            this.modalMessage = `¿Estás seguro de que quieres marcar el ticket ${ticketCode} como usado?`;
            this.modalAction = `/admin/tickets/${ticketId}/mark-as-used`;
            this.modalConfirmText = 'Marcar como Usado';
            this.showModal = true;
        },
        
        confirmCancel(ticketId, ticketCode) {
            this.modalType = 'cancel';
            this.modalTitle = 'Cancelar Ticket';
            this.modalMessage = `¿Estás seguro de que quieres cancelar el ticket ${ticketCode}? Esta acción no se puede deshacer.`;
            this.modalAction = `/admin/tickets/${ticketId}/cancel`;
            this.modalConfirmText = 'Cancelar Ticket';
            this.showModal = true;
        },
        
        closeModal() {
            this.showModal = false;
        }
    }
}
</script>
@endsection 