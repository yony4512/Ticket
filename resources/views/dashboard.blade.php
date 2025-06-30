@php
    use App\Models\Event;
    use Illuminate\Support\Str;
@endphp

<x-app-layout>
    <x-slot name="header">
        {{-- Título eliminado --}}
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-8">
                <!-- Welcome Section -->
                <div class="glass-effect rounded-xl p-6 lg:p-8 shadow-lg border border-gray-200">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex items-center space-x-4 mb-4 lg:mb-0">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-user text-white text-2xl"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl lg:text-3xl font-bold bg-gradient-to-r from-gray-900 via-blue-800 to-indigo-800 bg-clip-text text-transparent">
                                    ¡Bienvenido, {{ Auth::user()->name }}!
                                </h1>
                                <p class="text-gray-600 mt-1">Gestiona tus eventos y entradas desde tu panel personal</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Miembro desde</p>
                            <p class="text-lg font-semibold text-gray-900">{{ Auth::user()->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Mis Eventos</p>
                                <p class="text-3xl font-bold text-gray-900">{{ Auth::user()->events()->count() }}</p>
                            </div>
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-calendar text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('events.my-events') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Ver mis eventos <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>

                    <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Entradas Activas</p>
                                <p class="text-3xl font-bold text-gray-900">{{ Auth::user()->active_tickets_count }}</p>
                            </div>
                            <div class="w-12 h-12 bg-gradient-to-br from-green-600 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-ticket-alt text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('tickets.index') }}" class="text-green-600 hover:text-green-800 text-sm font-medium">
                                Ver mis entradas <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>

                    <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Gastado</p>
                                <p class="text-3xl font-bold text-gray-900">S/. {{ number_format(Auth::user()->total_spent, 2) }}</p>
                            </div>
                            <div class="w-12 h-12 bg-gradient-to-br from-yellow-600 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-dollar-sign text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-yellow-600 text-sm font-medium">
                                <i class="fas fa-chart-line mr-1"></i> Historial completo
                            </span>
                        </div>
                    </div>

                    <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Eventos Próximos</p>
                                <p class="text-3xl font-bold text-gray-900">{{ Auth::user()->tickets()->whereHas('event', function($q) { $q->upcoming(); })->count() }}</p>
                            </div>
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-users text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('events.index') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                                Explorar eventos <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="glass-effect rounded-xl p-6 lg:p-8 shadow-lg border border-gray-200">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg">
                            <i class="fas fa-bolt text-white text-sm"></i>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Acciones Rápidas</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @if(!Auth::user()->hasRole('admin'))
                            <a href="{{ route('events.create') }}" 
                               class="group relative bg-gradient-to-r from-blue-600 to-indigo-600 p-6 rounded-xl text-white hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                <div class="flex items-center">
                                    <i class="fas fa-plus-circle text-2xl mr-3"></i>
                                    <div>
                                        <p class="font-semibold">Crear Evento</p>
                                        <p class="text-sm opacity-90">Nuevo evento</p>
                                    </div>
                                </div>
                            </a>
                        @endif

                        <a href="{{ route('events.my-events') }}" 
                           class="group relative bg-gradient-to-r from-green-600 to-emerald-600 p-6 rounded-xl text-white hover:from-green-700 hover:to-emerald-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt text-2xl mr-3"></i>
                                <div>
                                    <p class="font-semibold">Mis Eventos</p>
                                    <p class="text-sm opacity-90">Gestionar eventos</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('tickets.index') }}" 
                           class="group relative bg-gradient-to-r from-purple-600 to-indigo-600 p-6 rounded-xl text-white hover:from-purple-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <div class="flex items-center">
                                <i class="fas fa-ticket-alt text-2xl mr-3"></i>
                                <div>
                                    <p class="font-semibold">Mis Tickets</p>
                                    <p class="text-sm opacity-90">Ver compras</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('messages.index') }}" 
                           class="group relative bg-gradient-to-r from-purple-600 to-pink-600 p-6 rounded-xl text-white hover:from-purple-700 hover:to-pink-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <div class="flex items-center">
                                <i class="fas fa-envelope text-2xl mr-3"></i>
                                <div>
                                    <p class="font-semibold">Mensajes</p>
                                    <p class="text-sm opacity-90">Contactar admin</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Mis eventos recientes -->
                    <div class="glass-effect rounded-xl shadow-lg border border-gray-200">
                        <div class="p-6 lg:p-8">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg">
                                    <i class="fas fa-calendar text-white text-sm"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">Mis Eventos Recientes</h3>
                            </div>
                            
                            @php
                                $myEvents = Auth::user()->events()->latest()->take(5)->get();
                            @endphp
                            
                            @if($myEvents->isEmpty())
                                <div class="text-center py-8">
                                    <div class="w-16 h-16 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-calendar-plus text-gray-400 text-xl"></i>
                                    </div>
                                    <p class="text-gray-600 mb-4">No has creado eventos aún.</p>
                                    <a href="{{ route('events.create') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                                        <i class="fas fa-plus mr-2"></i>
                                        Crear mi primer evento
                                    </a>
                                </div>
                            @else
                                <div class="space-y-4">
                                    @foreach($myEvents as $event)
                                        <div class="flex items-center justify-between p-4 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200">
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900">{{ $event->title }}</h4>
                                                <p class="text-sm text-gray-600">{{ $event->formatted_date }}</p>
                                            </div>
                                            <div class="flex items-center space-x-3">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                                    {{ \App\Models\Event::categories()[$event->category] }}
                                                </span>
                                                <a href="{{ route('events.show', $event) }}" 
                                                   class="text-blue-600 hover:text-blue-800 font-medium">
                                                    Ver
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-6">
                                    <a href="{{ route('events.my-events') }}" 
                                       class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                                        Ver todos mis eventos
                                        <i class="fas fa-arrow-right ml-2"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Mis entradas recientes -->
                    <div class="glass-effect rounded-xl shadow-lg border border-gray-200">
                        <div class="p-6 lg:p-8">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-8 h-8 bg-gradient-to-br from-green-600 to-emerald-600 rounded-lg flex items-center justify-center shadow-lg">
                                    <i class="fas fa-ticket-alt text-white text-sm"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">Mis Entradas Recientes</h3>
                            </div>
                            
                            @php
                                $myTickets = Auth::user()->tickets()->with('event')->latest()->take(5)->get();
                            @endphp
                            
                            @if($myTickets->isEmpty())
                                <div class="text-center py-8">
                                    <div class="w-16 h-16 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-ticket-alt text-gray-400 text-xl"></i>
                                    </div>
                                    <p class="text-gray-600 mb-4">No tienes entradas aún.</p>
                                    <a href="{{ route('events.index') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                                        <i class="fas fa-search mr-2"></i>
                                        Explorar eventos
                                    </a>
                                </div>
                            @else
                                <div class="space-y-4">
                                    @foreach($myTickets as $ticket)
                                        <div class="flex items-center justify-between p-4 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200">
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900">{{ $ticket->event->title }}</h4>
                                                <p class="text-sm text-gray-600">{{ $ticket->event->formatted_date }}</p>
                                            </div>
                                            <div class="flex items-center space-x-3">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                    {{ $ticket->quantity }} entradas
                                                </span>
                                                <a href="{{ route('tickets.show', $ticket) }}" 
                                                   class="text-green-600 hover:text-green-800 font-medium">
                                                    Ver
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-6">
                                    <a href="{{ route('tickets.index') }}" 
                                       class="inline-flex items-center text-green-600 hover:text-green-800 font-medium">
                                        Ver todas mis entradas
                                        <i class="fas fa-arrow-right ml-2"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
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


