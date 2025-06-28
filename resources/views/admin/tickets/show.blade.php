@extends('layouts.admin')

@section('title', 'Detalle del Ticket')
@section('subtitle', '<p class="text-sm text-gray-600">Información completa del ticket</p>')

@section('content')
<div class="space-y-6">
    <!-- Información del ticket -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Ticket #{{ $ticket->ticket_code }}</h3>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.tickets.index') }}" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Volver
                    </a>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Información del Ticket</h4>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-500">Código</label>
                            <p class="text-sm font-mono text-gray-900">{{ $ticket->ticket_code }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-500">Estado</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $ticket->status_color }}-100 text-{{ $ticket->status_color }}-800">
                                {{ $ticket->status_label }}
                            </span>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-500">Cantidad</label>
                            <p class="text-sm text-gray-900">{{ $ticket->quantity }} tickets</p>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-500">Precio Unitario</label>
                            <p class="text-sm text-gray-900">S/. {{ number_format($ticket->unit_price, 2) }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-500">Total Pagado</label>
                            <p class="text-lg font-semibold text-gray-900">S/. {{ number_format($ticket->total_price, 2) }}</p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Información de Compra</h4>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-500">Fecha de Compra</label>
                            <p class="text-sm text-gray-900">{{ $ticket->purchased_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                        
                        @if($ticket->used_at)
                        <div>
                            <label class="block text-xs font-medium text-gray-500">Fecha de Uso</label>
                            <p class="text-sm text-gray-900">{{ $ticket->used_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                        @endif
                        
                        @if($ticket->cancelled_at)
                        <div>
                            <label class="block text-xs font-medium text-gray-500">Fecha de Cancelación</label>
                            <p class="text-sm text-gray-900">{{ $ticket->cancelled_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                        @endif
                        
                        @if($ticket->notes)
                        <div>
                            <label class="block text-xs font-medium text-gray-500">Notas</label>
                            <p class="text-sm text-gray-900">{{ $ticket->notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Información del comprador -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <h4 class="text-sm font-medium text-gray-700 mb-3">Comprador</h4>
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-gray-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $ticket->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $ticket->user->email }}</p>
                        <p class="text-xs text-gray-400">Miembro desde {{ $ticket->user->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Información del evento -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <h4 class="text-sm font-medium text-gray-700 mb-3">Evento</h4>
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar text-indigo-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $ticket->event->title }}</p>
                        <p class="text-sm text-gray-500">{{ $ticket->event->location }}</p>
                        <p class="text-xs text-gray-400">{{ $ticket->event->formatted_date }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 