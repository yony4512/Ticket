@extends('layouts.admin')

@section('title', 'Gestión de Tickets')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="text-center lg:text-left">
        <h1 class="text-3xl font-bold bg-gradient-to-r from-slate-900 via-blue-800 to-indigo-800 bg-clip-text text-transparent">
            Gestión de Tickets
        </h1>
        <p class="text-gray-600 mt-2">Administra todos los tickets del sistema</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200 card-hover">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-700 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-ticket-alt text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Tickets</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $tickets->total() }}</p>
                </div>
            </div>
        </div>

        <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200 card-hover">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-green-600 via-green-700 to-emerald-700 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-check-circle text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Confirmados</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $confirmedTickets }}</p>
                </div>
            </div>
        </div>

        <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200 card-hover">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-600 via-yellow-700 to-orange-700 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-clock text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pendientes</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pendingTickets }}</p>
                </div>
            </div>
        </div>

        <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200 card-hover">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-600 via-purple-700 to-indigo-700 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-dollar-sign text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Ingresos</p>
                    <p class="text-2xl font-bold text-gray-900">${{ number_format($totalRevenue, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200">
        <form method="GET" action="{{ route('admin.tickets.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-search mr-2 text-blue-600"></i>
                    Buscar
                </label>
                <input type="text" name="search" id="search" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Buscar tickets..."
                       value="{{ request('search') }}">
            </div>
            
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-toggle-on mr-2 text-blue-600"></i>
                    Estado
                </label>
                <select name="status" id="status" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todos los estados</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmado</option>
                    <option value="used" {{ request('status') == 'used' ? 'selected' : '' }}>Usado</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                </select>
            </div>
            
            <div>
                <label for="event" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-calendar mr-2 text-blue-600"></i>
                    Evento
                </label>
                <select name="event" id="event" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
                        class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-300">
                    <i class="fas fa-filter mr-2"></i>
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Tickets Table -->
    <div class="glass-effect rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
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
                    @forelse($tickets as $ticket)
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
                                <div class="text-sm font-medium text-gray-900">${{ number_format($ticket->total_price, 2) }}</div>
                                <div class="text-sm text-gray-500">${{ number_format($ticket->total_price / $ticket->quantity, 2) }} c/u</div>
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
                                        <form method="POST" action="{{ route('admin.tickets.mark-as-used', $ticket) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="text-green-600 hover:text-green-900 p-2 rounded-lg hover:bg-green-50 transition-all duration-200"
                                                    onclick="return confirm('¿Marcar como usado?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    @if(in_array($ticket->status, ['pending', 'confirmed']))
                                        <form method="POST" action="{{ route('admin.tickets.cancel', $ticket) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-50 transition-all duration-200"
                                                    onclick="return confirm('¿Cancelar ticket?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="w-24 h-24 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-ticket-alt text-blue-600 text-3xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No se encontraron tickets</h3>
                                <p class="text-gray-500">No hay tickets que coincidan con los filtros aplicados.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($tickets->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $tickets->links() }}
            </div>
        @endif
    </div>
</div>
@endsection 