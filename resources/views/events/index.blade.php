<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Eventos') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and Filters -->
            <div class="glass-effect rounded-xl p-6 mb-6 shadow-lg border border-gray-200">
                <form method="GET" action="{{ route('events.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-search mr-2 text-blue-600"></i>
                                Buscar
                            </label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                   placeholder="Buscar eventos...">
                        </div>
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-tag mr-2 text-green-600"></i>
                                Categoría
                            </label>
                            <select name="category" id="category" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <option value="">Todas las categorías</option>
                                @foreach($categories as $key => $category)
                                    <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" 
                                    class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                <i class="fas fa-search mr-2"></i>
                                Buscar Eventos
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Events Grid -->
            @if($events->isEmpty())
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-calendar text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">No se encontraron eventos</h3>
                    <p class="text-gray-600 mb-8">Intenta ajustar tus filtros de búsqueda o crear un nuevo evento.</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('events.index') }}" 
                           class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                            <i class="fas fa-refresh mr-2"></i>
                            Ver todos los eventos
                        </a>
                        @auth
                            <a href="{{ route('events.create') }}" 
                               class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                                <i class="fas fa-plus mr-2"></i>
                                Crear Evento
                            </a>
                        @endauth
                    </div>
                </div>
            @else
                <!-- Results Count -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-calendar-check text-blue-600 mr-2"></i>
                        <span class="text-gray-700 font-medium">
                            {{ $events->total() }} evento{{ $events->total() != 1 ? 's' : '' }} encontrado{{ $events->total() != 1 ? 's' : '' }}
                        </span>
                    </div>
                    @auth
                        <a href="{{ route('events.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                            <i class="fas fa-plus mr-2"></i>
                            Crear Evento
                        </a>
                    @endauth
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($events as $event)
                        <div class="glass-effect rounded-xl overflow-hidden shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                            @if($event->image_path)
                                <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center">
                                    <i class="fas fa-calendar text-white text-4xl"></i>
                                </div>
                            @endif
                            
                            <div class="p-6">
                                <div class="mb-4 flex justify-between items-start">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                        <i class="fas fa-tag mr-1"></i>
                                        {{ $categories[$event->category] }}
                                    </span>
                                    
                                    @if($event->isSoldOut())
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Agotado
                                        </span>
                                    @elseif($event->event_date->isPast())
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                            <i class="fas fa-calendar-times mr-1"></i>
                                            Finalizado
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Disponible
                                        </span>
                                    @endif
                                </div>
                                
                                <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $event->title }}</h3>
                                <p class="text-gray-600 mb-4 line-clamp-2">{{ Str::limit($event->description, 120) }}</p>
                                
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="fas fa-map-marker-alt mr-2 text-red-500"></i>
                                        <span>{{ $event->location }}</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="fas fa-calendar mr-2 text-blue-500"></i>
                                        <span>{{ $event->formatted_date }}</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="fas fa-user mr-2 text-green-500"></i>
                                        <span>Organizado por {{ $event->user->name }}</span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-2xl font-bold text-green-600">{{ $event->formatted_price }}</span>
                                    @if($event->capacity)
                                        <span class="text-sm text-gray-500">
                                            <i class="fas fa-users mr-1"></i>
                                            {{ $event->available_capacity }} de {{ $event->capacity }} disponibles
                                        </span>
                                    @endif
                                </div>
                                
                                <a href="{{ route('events.show', $event) }}" 
                                   class="block w-full text-center bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-3 px-4 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 transform hover:-translate-y-1">
                                    <i class="fas fa-eye mr-2"></i>
                                    Ver Detalles
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-8">
                    {{ $events->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

<style>
    .glass-effect {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style> 