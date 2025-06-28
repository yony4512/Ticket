@extends('layouts.admin')

@section('title', 'Gestión de Eventos')
@section('subtitle')
    <div class="flex items-center text-blue-700 text-base font-semibold mb-2">
        <i class="fas fa-calendar-alt mr-2"></i>
        Administra todos los eventos del sistema
    </div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div class="text-center sm:text-left">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-slate-900 via-blue-800 to-indigo-800 bg-clip-text text-transparent">
                Gestión de Eventos
            </h1>
            <p class="text-gray-600 mt-2">Administra todos los eventos del sistema</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.events.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                <i class="fas fa-plus mr-2"></i>
                Crear Evento
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200">
        <form method="GET" action="{{ route('admin.events.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-search mr-2 text-blue-600"></i>
                    Buscar
                </label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Título del evento...">
            </div>
            
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-tags mr-2 text-blue-600"></i>
                    Categoría
                </label>
                <select name="category" id="category" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todas las categorías</option>
                    <option value="concierto" {{ request('category') == 'concierto' ? 'selected' : '' }}>Concierto</option>
                    <option value="conferencia" {{ request('category') == 'conferencia' ? 'selected' : '' }}>Conferencia</option>
                    <option value="deportivo" {{ request('category') == 'deportivo' ? 'selected' : '' }}>Deportivo</option>
                    <option value="cultural" {{ request('category') == 'cultural' ? 'selected' : '' }}>Cultural</option>
                    <option value="teatro" {{ request('category') == 'teatro' ? 'selected' : '' }}>Teatro</option>
                    <option value="otros" {{ request('category') == 'otros' ? 'selected' : '' }}>Otros</option>
                </select>
            </div>
            
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-toggle-on mr-2 text-blue-600"></i>
                    Estado
                </label>
                <select name="status" id="status" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todos los estados</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Activo</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactivo</option>
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

    <!-- Lista de eventos -->
    <div class="glass-effect rounded-xl shadow-lg border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Eventos ({{ $events->total() }})</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Evento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($events as $event)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-600 via-green-700 to-emerald-700 rounded-lg flex items-center justify-center flex-shrink-0 mr-3">
                                        <i class="fas fa-calendar text-white text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $event->title }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($event->description, 50) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    {{ $event->category_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $event->event_date->format('d/m/Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $event->event_date->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $event->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    <i class="fas fa-circle mr-1 text-xs"></i>
                                    {{ $event->status === 'active' ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.events.show', $event) }}" 
                                       class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-2 py-1 rounded-lg transition-all duration-200">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.events.edit', $event) }}" 
                                       class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 px-2 py-1 rounded-lg transition-all duration-200">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.events.destroy', $event) }}" class="inline" 
                                          onsubmit="return confirm('¿Estás seguro de que quieres eliminar este evento?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-2 py-1 rounded-lg transition-all duration-200">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-calendar-times text-gray-400 text-2xl"></i>
                                </div>
                                <p class="text-gray-500 text-lg">No se encontraron eventos</p>
                                <p class="text-gray-400 text-sm mt-1">Intenta ajustar los filtros de búsqueda</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($events->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $events->links() }}
            </div>
        @endif
    </div>
</div>
@endsection 