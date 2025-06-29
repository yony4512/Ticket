<x-app-layout>
    <x-slot name="header">
        {{-- Título eliminado --}}
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Botón Crear Evento -->
            <div class="mb-4 sm:mb-6 flex justify-end">
                @if(!Auth::user()->hasRole('admin'))
                    <a href="{{ route('events.create') }}" 
                       class="inline-flex items-center px-4 sm:px-6 py-2 sm:py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 text-sm sm:text-base">
                        <i class="fas fa-plus mr-2"></i>
                        <span class="hidden sm:inline">Crear Nuevo Evento</span>
                        <span class="sm:hidden">Crear Evento</span>
                    </a>
                @endif
            </div>

            @if(session('success'))
                <div class="glass-effect rounded-xl p-3 sm:p-4 shadow-lg border border-green-200 mb-4 sm:mb-6" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-600 mr-3"></i>
                        <span class="text-green-800 font-medium text-sm sm:text-base">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if($events->isEmpty())
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calendar-plus text-gray-400 text-xl"></i>
                    </div>
                    <p class="text-gray-600 mb-4">No has creado eventos aún.</p>
                    @if(session('info'))
                        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
                            {{ session('info') }}
                        </div>
                    @endif
                    @if(!Auth::user()->hasRole('admin'))
                        <a href="{{ route('events.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                            <i class="fas fa-plus mr-2"></i>
                            Crear mi primer evento
                        </a>
                    @else
                        <a href="{{ route('events.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                            <i class="fas fa-search mr-2"></i>
                            Explorar Eventos
                        </a>
                    @endif
                </div>
            @else
                <!-- Vista de Tarjetas para Desktop -->
                <div class="hidden md:grid md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                    @foreach($events as $event)
                        <div class="glass-effect rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            @if($event->image_path)
                                <img src="{{ Storage::url($event->image_path) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover rounded-t-xl">
                            @else
                                <div class="w-full h-48 bg-gradient-to-br from-gray-200 to-gray-300 rounded-t-xl flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400 text-4xl"></i>
                                </div>
                            @endif
                            <div class="p-4 sm:p-6">
                                <h3 class="text-lg font-semibold mb-2 text-gray-900">{{ $event->title }}</h3>
                                <p class="text-gray-600 mb-4 text-sm">{{ Str::limit($event->description, 100) }}</p>
                                
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>
                                        {{ $event->location }}
                                    </div>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="fas fa-calendar mr-2 text-green-500"></i>
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y H:i') }}
                                    </div>
                                    <div class="flex items-center text-sm font-semibold text-indigo-600">
                                        <i class="fas fa-dollar-sign mr-2"></i>
                                        S/. {{ number_format($event->price, 2) }}
                                    </div>
                                </div>

                                @if($event->edited_once)
                                    <div class="mb-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            Ya editado
                                        </span>
                                    </div>
                                @endif

                                <div class="flex justify-between items-center">
                                    <a href="{{ route('events.show', $event) }}" 
                                       class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                        Ver detalles <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                    <div class="flex space-x-2">
                                        @if($event->canBeEdited())
                                            <a href="{{ route('events.edit', $event) }}" 
                                               class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition-colors"
                                               title="Editar evento">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @else
                                            <span class="text-gray-400 cursor-not-allowed p-2 rounded-lg" 
                                                  title="Este evento ya fue editado una vez">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        @endif
                                        <button type="button" 
                                                onclick="confirmDelete({{ $event->id }}, '{{ addslashes($event->title) }}')"
                                                class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-colors" 
                                                title="Eliminar evento">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Vista de Lista para Móvil -->
                <div class="md:hidden space-y-4">
                    @foreach($events as $event)
                        <div class="glass-effect rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                            <div class="flex">
                                @if($event->image_path)
                                    <img src="{{ Storage::url($event->image_path) }}" alt="{{ $event->title }}" class="w-24 h-24 object-cover">
                                @else
                                    <div class="w-24 h-24 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400 text-xl"></i>
                                    </div>
                                @endif
                                <div class="flex-1 p-4">
                                    <h3 class="font-semibold text-gray-900 mb-1 text-sm">{{ $event->title }}</h3>
                                    <p class="text-gray-600 text-xs mb-2">{{ Str::limit($event->description, 60) }}</p>
                                    
                                    <div class="space-y-1 mb-3">
                                        <div class="flex items-center text-xs text-gray-500">
                                            <i class="fas fa-map-marker-alt mr-1 text-blue-500"></i>
                                            {{ Str::limit($event->location, 25) }}
                                        </div>
                                        <div class="flex items-center text-xs text-gray-500">
                                            <i class="fas fa-calendar mr-1 text-green-500"></i>
                                            {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }}
                                        </div>
                                        <div class="flex items-center text-xs font-semibold text-indigo-600">
                                            <i class="fas fa-dollar-sign mr-1"></i>
                                            S/. {{ number_format($event->price, 2) }}
                                        </div>
                                    </div>

                                    @if($event->edited_once)
                                        <div class="mb-3">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                                Ya editado
                                            </span>
                                        </div>
                                    @endif

                                    <div class="flex justify-between items-center">
                                        <a href="{{ route('events.show', $event) }}" 
                                           class="text-blue-600 hover:text-blue-800 font-medium text-xs">
                                            Ver detalles
                                        </a>
                                        <div class="flex space-x-1">
                                            @if($event->canBeEdited())
                                                <a href="{{ route('events.edit', $event) }}" 
                                                   class="text-blue-600 hover:text-blue-800 p-1 rounded transition-colors"
                                                   title="Editar evento">
                                                    <i class="fas fa-edit text-sm"></i>
                                                </a>
                                            @else
                                                <span class="text-gray-400 cursor-not-allowed p-1 rounded" 
                                                      title="Este evento ya fue editado una vez">
                                                    <i class="fas fa-edit text-sm"></i>
                                                </span>
                                            @endif
                                            <button type="button" 
                                                    onclick="confirmDelete({{ $event->id }}, '{{ addslashes($event->title) }}')"
                                                    class="text-red-600 hover:text-red-800 p-1 rounded transition-colors" 
                                                    title="Eliminar evento">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 sm:mt-8">
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

    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</x-app-layout> 