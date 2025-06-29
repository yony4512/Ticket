<x-app-layout>
    <x-slot name="header">
        {{-- Título eliminado --}}
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
           

            @if(session('success'))
                <div class="glass-effect rounded-xl p-4 shadow-lg border border-green-200 mb-6" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-600 mr-3"></i>
                        <span class="text-green-800 font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if($tickets->isEmpty())
                <div class="glass-effect rounded-xl p-8 shadow-lg border border-gray-200 text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-ticket-alt text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No tienes entradas aún</h3>
                    <p class="text-gray-600 mb-6">Explora eventos y compra tus primeras entradas para comenzar.</p>
                    <a href="{{ route('events.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                        <i class="fas fa-search mr-2"></i>
                        Explorar Eventos
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($tickets as $ticket)
                        <div class="glass-effect rounded-xl overflow-hidden shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            @if($ticket->event->image_path)
                                <img src="{{ $ticket->event->image_url }}" alt="{{ $ticket->event->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center">
                                    <i class="fas fa-calendar text-white text-4xl"></i>
                                </div>
                            @endif
                            
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-{{ $ticket->status_color }}-100 text-{{ $ticket->status_color }}-800">
                                        {{ $ticket->status_label }}
                                    </span>
                                    <span class="text-lg font-bold text-green-600">S/. {{ number_format($ticket->total_price, 2) }}</span>
                                </div>
                                
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $ticket->event->title }}</h3>
                                <p class="text-gray-600 mb-4">{{ $ticket->event->formatted_date }}</p>
                                
                                <div class="flex items-center text-sm text-gray-500 mb-4">
                                    <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>
                                    <span>{{ $ticket->event->location }}</span>
                                </div>
                                
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-sm text-gray-600">
                                        <i class="fas fa-ticket-alt mr-1"></i>
                                        {{ $ticket->quantity }} {{ Str::plural('entrada', $ticket->quantity) }}
                                    </span>
                                    <span class="text-sm text-gray-500">
                                        Comprado: {{ $ticket->purchased_at->format('d/m/Y') }}
                                    </span>
                                </div>
                                
                                <div class="flex space-x-2">
                                    <a href="{{ route('tickets.show', $ticket) }}" 
                                       class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200">
                                        Ver Detalles
                                    </a>
                                    <a href="{{ route('tickets.download', $ticket) }}" 
                                       class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200"
                                       title="Descargar entrada">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-8">
                    {{ $tickets->links() }}
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
</style> 