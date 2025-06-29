@extends('layouts.admin')

@section('title', 'Gestión de Eventos')
@section('subtitle')
    <div class="flex items-center text-blue-700 text-base font-semibold mb-2">
        <i class="fas fa-calendar-alt mr-2"></i>
        Administra todos los eventos del sistema
    </div>
@endsection

@section('content')
<div class="space-y-4 sm:space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div class="text-center sm:text-left">
            <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-slate-900 via-blue-800 to-indigo-800 bg-clip-text text-transparent">
                Gestión de Eventos
            </h1>
            <p class="text-gray-600 mt-2 text-sm sm:text-base">Administra todos los eventos del sistema</p>
        </div>
        <div class="mt-4 sm:mt-0">
            {{-- Botón de crear evento eliminado para administradores --}}
        </div>
    </div>

    <!-- Filtros -->
    <div class="glass-effect rounded-xl p-4 sm:p-6 shadow-lg border border-gray-200">
        <form method="GET" action="{{ route('admin.events.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-search mr-2 text-blue-600"></i>
                        Buscar
                    </label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-sm"
                           placeholder="Buscar eventos...">
                </div>
                
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-tags mr-2 text-green-600"></i>
                        Categoría
                    </label>
                    <select name="category" id="category" 
                            class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <option value="">Todas las categorías</option>
                        @foreach(\App\Models\Event::categories() as $key => $label)
                            <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-toggle-on mr-2 text-blue-600"></i>
                        Estado
                    </label>
                    <select name="status" id="status" 
                            class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <option value="">Todos los estados</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Activo</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactivo</option>
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

    <!-- Lista de eventos -->
    <div class="glass-effect rounded-xl shadow-lg border border-gray-200">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900">Eventos ({{ $events->total() }})</h3>
        </div>
        
        <!-- Vista de Tarjetas para Móvil y Tablet -->
        <div class="block lg:hidden">
            @forelse($events as $event)
                <div class="p-4 sm:p-6 border-b border-gray-200 last:border-b-0">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-600 via-green-700 to-emerald-700 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-calendar text-white text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-sm font-medium text-gray-900 truncate">{{ $event->title }}</h4>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    {{ $event->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    <i class="fas fa-circle mr-1 text-xs"></i>
                                    {{ $event->status === 'active' ? 'Activo' : 'Inactivo' }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 mb-2">{{ Str::limit($event->description, 80) }}</p>
                            <div class="flex items-center space-x-4 text-xs text-gray-500 mb-3">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    {{ $event->category_label }}
                                </span>
                                <span>{{ $event->event_date->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.events.show', $event) }}" 
                                   class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-2 py-1 rounded text-xs transition-all duration-200">
                                    <i class="fas fa-eye mr-1"></i>
                                    Ver
                                </a>
                                <a href="{{ route('admin.events.edit', $event) }}" 
                                   class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 px-2 py-1 rounded text-xs transition-all duration-200">
                                    <i class="fas fa-edit mr-1"></i>
                                    Editar
                                </a>
                                <button type="button" 
                                        onclick="confirmDelete({{ $event->id }}, '{{ addslashes($event->title) }}', true)"
                                        class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-2 py-1 rounded text-xs transition-all duration-200">
                                    <i class="fas fa-trash mr-1"></i>
                                    Eliminar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calendar-times text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-500 text-base">No se encontraron eventos</p>
                    <p class="text-gray-400 text-sm mt-1">Intenta ajustar los filtros de búsqueda</p>
                </div>
            @endforelse
        </div>

        <!-- Vista de Tabla para Desktop -->
        <div class="hidden lg:block overflow-x-auto">
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
                                    <button type="button" 
                                            onclick="confirmDelete({{ $event->id }}, '{{ addslashes($event->title) }}', true)"
                                            class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-2 py-1 rounded-lg transition-all duration-200">
                                        <i class="fas fa-trash"></i>
                                    </button>
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
            <div class="px-4 sm:px-6 py-4 border-t border-gray-200">
                {{ $events->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal de Confirmación de Eliminación -->
<div id="deleteModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; background-color: rgba(0,0,0,0.5);">
    <div style="display: flex; align-items: center; justify-content: center; height: 100%; padding: 20px;">
        <div style="background: white; border-radius: 16px; max-width: 500px; width: 100%; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
            
            <!-- Header -->
            <div style="background: linear-gradient(to right, #dc2626, #ec4899, #dc2626); padding: 24px; border-bottom: 1px solid #fecaca; border-radius: 16px 16px 0 0;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 40px; height: 40px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-exclamation-triangle" style="color: white; font-size: 18px;"></i>
                        </div>
                        <div>
                            <h3 style="color: white; font-size: 20px; font-weight: bold; margin: 0;">Confirmar Eliminación</h3>
                            <p style="color: #fecaca; font-size: 14px; margin: 0;">Acción irreversible</p>
                        </div>
                    </div>
                    <button onclick="closeDeleteModal()" style="color: white; background: none; border: none; font-size: 20px; cursor: pointer;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <!-- Contenido -->
            <div style="padding: 24px; background: linear-gradient(135deg, #fef2f2, #fdf2f8, #fef2f2);">
                <div style="text-align: center; margin-bottom: 24px;">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #fee2e2, #fce7f3); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; border: 1px solid #fecaca;">
                        <i class="fas fa-trash-alt" style="color: #ef4444; font-size: 32px;"></i>
                    </div>
                    <h4 style="color: #991b1b; font-size: 18px; font-weight: 600; margin: 0 0 8px;">¿Eliminar Evento?</h4>
                    <p style="color: #b91c1c; margin: 0 0 16px;">
                        Estás a punto de eliminar el evento:<br>
                        <span id="eventTitle" style="font-weight: 600;"></span>
                    </p>
                    <div style="background: linear-gradient(to right, #fee2e2, #fce7f3); border-radius: 12px; padding: 16px; border: 1px solid #fecaca;">
                        <div style="display: flex; align-items: flex-start; gap: 12px;">
                            <i class="fas fa-exclamation-triangle" style="color: #dc2626; margin-top: 2px;"></i>
                            <div style="text-align: left;">
                                <p style="font-size: 14px; font-weight: 600; color: #991b1b; margin: 0 0 8px;">Esta acción no se puede deshacer</p>
                                <ul style="font-size: 14px; color: #b91c1c; margin: 0; padding-left: 0; list-style: none;">
                                    <li style="margin-bottom: 4px;">• El evento será eliminado permanentemente</li>
                                    <li style="margin-bottom: 4px;">• Se cancelarán todas las entradas vendidas</li>
                                    <li style="margin-bottom: 4px;">• Se reembolsará automáticamente a los compradores</li>
                                    <li>• Se eliminará la imagen asociada</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Botones -->
                <div style="display: flex; gap: 12px;">
                    <button onclick="closeDeleteModal()" style="flex: 1; padding: 12px 16px; background: #4b5563; color: white; border: none; border-radius: 12px; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-times" style="margin-right: 8px;"></i>
                        Cancelar
                    </button>
                    <form id="deleteForm" method="POST" style="flex: 1;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="width: 100%; padding: 12px 16px; background: linear-gradient(to right, #dc2626, #ec4899, #dc2626); color: white; border: none; border-radius: 12px; font-weight: 600; cursor: pointer;">
                            <i class="fas fa-trash-alt" style="margin-right: 8px;"></i>
                            Eliminar Definitivamente
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showDeleteModal(eventId, eventTitle, isAdmin = false) {
        const modal = document.getElementById('deleteModal');
        const titleElement = document.getElementById('eventTitle');
        const form = document.getElementById('deleteForm');
        
        titleElement.textContent = eventTitle;
        
        if (isAdmin) {
            form.action = `/admin/events/${eventId}`;
        } else {
            form.action = `/events/${eventId}`;
        }
        
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
    
    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
    
    function confirmDelete(eventId, eventTitle, isAdmin = false) {
        showDeleteModal(eventId, eventTitle, isAdmin);
    }
    
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeDeleteModal();
        }
    });
    
    document.getElementById('deleteModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeDeleteModal();
        }
    });
</script>

@endsection 