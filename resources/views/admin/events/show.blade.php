@extends('layouts.admin')



@section('content')
<div class="space-y-6">
    <!-- Información del evento -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">{{ $event->title }}</h3>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.events.index') }}" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Volver
                    </a>
                    <a href="{{ route('admin.events.edit', $event) }}" class="text-blue-600 hover:text-blue-900">
                        <i class="fas fa-edit mr-1"></i>
                        Editar
                    </a>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Información General</h4>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-500">Título</label>
                            <p class="text-sm text-gray-900">{{ $event->title }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-500">Descripción</label>
                            <p class="text-sm text-gray-900">{{ $event->description }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-500">Ubicación</label>
                            <p class="text-sm text-gray-900">{{ $event->location }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-500">Categoría</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                {{ $event->category_label }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Detalles del Evento</h4>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-500">Fecha y Hora</label>
                            <p class="text-sm text-gray-900">{{ $event->formatted_date }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-500">Precio</label>
                            <p class="text-sm text-gray-900">{{ $event->formatted_price }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-500">Capacidad</label>
                            <p class="text-sm text-gray-900">{{ $event->capacity }} personas</p>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-500">Estado</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $event->status === 'active' ? 'green' : ($event->status === 'inactive' ? 'yellow' : 'red') }}-100 text-{{ $event->status === 'active' ? 'green' : ($event->status === 'inactive' ? 'yellow' : 'red') }}-800">
                                {{ ucfirst($event->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Información del organizador -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <h4 class="text-sm font-medium text-gray-700 mb-3">Organizador</h4>
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-gray-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $event->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $event->user->email }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas de tickets -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Estadísticas de Tickets</h3>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-ticket-alt text-blue-600 text-2xl"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-blue-900">Total Vendidos</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $event->tickets->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-900">Confirmados</p>
                            <p class="text-2xl font-bold text-green-600">{{ $event->tickets->where('status', 'confirmed')->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-yellow-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-yellow-900">Pendientes</p>
                            <p class="text-2xl font-bold text-yellow-600">{{ $event->tickets->where('status', 'pending')->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-red-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-times-circle text-red-600 text-2xl"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-900">Cancelados</p>
                            <p class="text-2xl font-bold text-red-600">{{ $event->tickets->where('status', 'cancelled')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 