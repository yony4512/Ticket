@php
    use App\Models\Event;
@endphp

@extends('layouts.admin')


@section('content')
<div class="space-y-6">
    <!-- Información del usuario -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Información del Usuario</h3>
                <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    <i class="fas fa-edit mr-2"></i>
                    Editar Usuario
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="flex items-center mb-4">
                        <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center">
                            <i class="fas fa-user text-indigo-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-xl font-semibold text-gray-900">{{ $user->name }}</h4>
                            <p class="text-gray-600">{{ $user->email }}</p>
                            @if($user->isAdmin())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 mt-1">
                                    <i class="fas fa-crown mr-1"></i>
                                    Administrador
                                </span>
                            @endif
                            <button type="button" onclick="openMessageModal({{ $user->id }})" class="ml-2 px-2 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs">
                                <i class="fas fa-envelope"></i> Mensaje
                            </button>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Fecha de registro</p>
                            <p class="text-sm text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Última actualización</p>
                            <p class="text-sm text-gray-900">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @if($user->email_verified_at)
                            <div>
                                <p class="text-sm font-medium text-gray-500">Email verificado</p>
                                <p class="text-sm text-gray-900">{{ $user->email_verified_at->format('d/m/Y H:i') }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div>
                    <h5 class="text-sm font-medium text-gray-500 mb-3">Roles asignados</h5>
                    <div class="space-y-2">
                        @foreach($user->roles as $role)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $role->display_name }}</p>
                                    <p class="text-sm text-gray-600">{{ $role->description }}</p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $role->name }}
                                </span>
                            </div>
                        @endforeach
                        @if($user->roles->isEmpty())
                            <p class="text-sm text-gray-500">No tiene roles asignados</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-calendar text-2xl text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Eventos</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_events'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-ticket-alt text-2xl text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Tickets</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_tickets'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-dollar-sign text-2xl text-yellow-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Gastado</p>
                        <p class="text-2xl font-semibold text-gray-900">S/. {{ number_format($stats['total_spent'], 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-clock text-2xl text-purple-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Tickets Activos</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['active_tickets'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Eventos del usuario -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Eventos Creados</h3>
            
            @if($user->events->isEmpty())
                <p class="text-gray-500 text-center py-4">Este usuario no ha creado eventos.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Evento
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Categoría
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha
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
                            @foreach($user->events as $event)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $event->title }}</div>
                                        <div class="text-sm text-gray-500">{{ $event->location }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                            {{ \App\Models\Event::categories()[$event->category] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $event->formatted_date }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $event->formatted_price }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $event->status === 'active' ? 'green' : 'red' }}-100 text-{{ $event->status === 'active' ? 'green' : 'red' }}-800">
                                            {{ ucfirst($event->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.events.show', $event) }}" class="text-indigo-600 hover:text-indigo-900">
                                            Ver
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Tickets del usuario -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tickets Comprados</h3>
            
            @if($user->tickets->isEmpty())
                <p class="text-gray-500 text-center py-4">Este usuario no ha comprado tickets.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Código
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Evento
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Cantidad
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($user->tickets as $ticket)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $ticket->ticket_code }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $ticket->event->title }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $ticket->quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        S/. {{ number_format($ticket->total_price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $ticket->status_color }}-100 text-{{ $ticket->status_color }}-800">
                                            {{ $ticket->status_label }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $ticket->purchased_at->format('d/m/Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@include('components.message-modal')
@endsection 