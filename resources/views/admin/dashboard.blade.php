@extends('layouts.admin')

@php use App\Models\Event; use Illuminate\Support\Str; @endphp

@section('title', 'Dashboard')


@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="text-center lg:text-left">
        <h1 class="text-3xl lg:text-4xl font-bold bg-gradient-to-r from-slate-900 via-blue-800 to-indigo-800 bg-clip-text text-transparent">
            Panel de Administración
        </h1>
        <p class="text-gray-600 mt-2 lg:mt-3 text-base lg:text-lg">Bienvenido al centro de control del sistema</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
        <!-- Total Users -->
        <div class="glass-effect rounded-xl p-6 lg:p-8 shadow-lg border border-gray-200 card-hover">
            <div class="flex items-center">
                <div class="w-12 h-12 lg:w-16 lg:h-16 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-700 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-users text-white text-lg lg:text-2xl"></i>
                </div>
                <div class="ml-4 lg:ml-6">
                    <p class="text-sm font-medium text-gray-600">Total Usuarios</p>
                    <p class="text-2xl lg:text-3xl font-bold text-gray-900">{{ $totalUsers }}</p>
                </div>
            </div>
            <div class="mt-4 lg:mt-6">
                <span class="text-sm text-green-600 flex items-center">
                    <i class="fas fa-arrow-up mr-2"></i>
                    +12% este mes
                </span>
            </div>
        </div>

        <!-- Total Events -->
        <div class="glass-effect rounded-xl p-6 lg:p-8 shadow-lg border border-gray-200 card-hover">
            <div class="flex items-center">
                <div class="w-12 h-12 lg:w-16 lg:h-16 bg-gradient-to-br from-green-600 via-green-700 to-emerald-700 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-calendar-alt text-white text-lg lg:text-2xl"></i>
                </div>
                <div class="ml-4 lg:ml-6">
                    <p class="text-sm font-medium text-gray-600">Total Eventos</p>
                    <p class="text-2xl lg:text-3xl font-bold text-gray-900">{{ $totalEvents }}</p>
                </div>
            </div>
            <div class="mt-4 lg:mt-6">
                <span class="text-sm text-green-600 flex items-center">
                    <i class="fas fa-arrow-up mr-2"></i>
                    +8% este mes
                </span>
            </div>
        </div>

        <!-- Total Tickets -->
        <div class="glass-effect rounded-xl p-6 lg:p-8 shadow-lg border border-gray-200 card-hover">
            <div class="flex items-center">
                <div class="w-12 h-12 lg:w-16 lg:h-16 bg-gradient-to-br from-purple-600 via-purple-700 to-indigo-700 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-ticket-alt text-white text-lg lg:text-2xl"></i>
                </div>
                <div class="ml-4 lg:ml-6">
                    <p class="text-sm font-medium text-gray-600">Total Tickets</p>
                    <p class="text-2xl lg:text-3xl font-bold text-gray-900">{{ $totalTickets }}</p>
                </div>
            </div>
            <div class="mt-4 lg:mt-6">
                <span class="text-sm text-green-600 flex items-center">
                    <i class="fas fa-arrow-up mr-2"></i>
                    +15% este mes
                </span>
            </div>
        </div>

        <!-- Revenue -->
        <div class="glass-effect rounded-xl p-6 lg:p-8 shadow-lg border border-gray-200 card-hover">
            <div class="flex items-center">
                <div class="w-12 h-12 lg:w-16 lg:h-16 bg-gradient-to-br from-yellow-600 via-orange-600 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-dollar-sign text-white text-lg lg:text-2xl"></i>
                </div>
                <div class="ml-4 lg:ml-6">
                    <p class="text-sm font-medium text-gray-600">Ingresos</p>
                    <p class="text-2xl lg:text-3xl font-bold text-gray-900">${{ number_format($totalRevenue, 2) }}</p>
                </div>
            </div>
            <div class="mt-4 lg:mt-6">
                <span class="text-sm text-green-600 flex items-center">
                    <i class="fas fa-arrow-up mr-2"></i>
                    +23% este mes
                </span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="glass-effect rounded-xl p-6 lg:p-8 shadow-lg border border-gray-200">
        <div class="flex items-center space-x-3 mb-4 lg:mb-6">
            <div class="w-8 h-8 lg:w-10 lg:h-10 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-700 rounded-xl flex items-center justify-center">
                <i class="fas fa-bolt text-white text-sm lg:text-lg"></i>
            </div>
            <h2 class="text-xl lg:text-2xl font-bold text-gray-900">Acciones Rápidas</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
            <a href="{{ route('admin.events.create') }}" 
               class="flex items-center p-4 lg:p-6 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                <i class="fas fa-plus mr-3 lg:mr-4 text-lg lg:text-2xl"></i>
                <span class="font-semibold text-base lg:text-lg">Crear Evento</span>
            </a>
            
            <a href="{{ route('admin.users.index') }}" 
               class="flex items-center p-4 lg:p-6 bg-green-600 hover:bg-green-700 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                <i class="fas fa-user-plus mr-3 lg:mr-4 text-lg lg:text-2xl"></i>
                <span class="font-semibold text-base lg:text-lg">Gestionar Usuarios</span>
            </a>
            
            <a href="{{ route('admin.messages.index') }}" 
               class="flex items-center p-4 lg:p-6 bg-purple-600 hover:bg-purple-700 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                <i class="fas fa-envelope mr-3 lg:mr-4 text-lg lg:text-2xl"></i>
                <span class="font-semibold text-base lg:text-lg">Ver Mensajes</span>
            </a>
            
            <a href="{{ route('admin.reports') }}" 
               class="flex items-center p-4 lg:p-6 bg-orange-600 hover:bg-orange-700 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                <i class="fas fa-chart-bar mr-3 lg:mr-4 text-lg lg:text-2xl"></i>
                <span class="font-semibold text-base lg:text-lg">Ver Reportes</span>
            </a>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
        <!-- Recent Events -->
        <div class="glass-effect rounded-xl p-6 lg:p-8 shadow-lg border border-gray-200">
            <div class="flex items-center justify-between mb-4 lg:mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 lg:w-10 lg:h-10 bg-gradient-to-br from-green-600 via-green-700 to-emerald-700 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar text-white text-sm lg:text-lg"></i>
                    </div>
                    <h2 class="text-xl lg:text-2xl font-bold text-gray-900">Eventos Recientes</h2>
                </div>
                <a href="{{ route('admin.events.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium hover:bg-blue-50 px-2 lg:px-3 py-1 lg:py-2 rounded-lg transition-all duration-200">
                    Ver todos
                </a>
            </div>
            <div class="space-y-3 lg:space-y-4">
                @forelse($recentEvents as $event)
                <div class="flex items-center p-3 lg:p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all duration-200">
                    <div class="w-10 h-10 lg:w-12 lg:h-12 bg-gradient-to-br from-green-600 via-green-700 to-emerald-700 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-calendar text-white text-sm"></i>
                    </div>
                    <div class="ml-3 lg:ml-4 flex-1">
                        <p class="text-sm font-semibold text-gray-900">{{ $event->title }}</p>
                        <p class="text-xs text-gray-500">{{ $event->event_date->format('d/m/Y H:i') }}</p>
                    </div>
                    <span class="text-xs px-2 lg:px-3 py-1 rounded-full font-medium {{ $event->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $event->status === 'active' ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>
                @empty
                <div class="text-center py-6 lg:py-8">
                    <div class="w-12 h-12 lg:w-16 lg:h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 lg:mb-4">
                        <i class="fas fa-calendar-times text-gray-400 text-xl lg:text-2xl"></i>
                    </div>
                    <p class="text-gray-500">No hay eventos recientes</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Tickets -->
        <div class="glass-effect rounded-xl p-6 lg:p-8 shadow-lg border border-gray-200">
            <div class="flex items-center justify-between mb-4 lg:mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 lg:w-10 lg:h-10 bg-gradient-to-br from-purple-600 via-purple-700 to-indigo-700 rounded-xl flex items-center justify-center">
                        <i class="fas fa-ticket-alt text-white text-sm lg:text-lg"></i>
                    </div>
                    <h2 class="text-xl lg:text-2xl font-bold text-gray-900">Tickets Recientes</h2>
                </div>
                <a href="{{ route('admin.tickets.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium hover:bg-blue-50 px-2 lg:px-3 py-1 lg:py-2 rounded-lg transition-all duration-200">
                    Ver todos
                </a>
            </div>
            <div class="space-y-3 lg:space-y-4">
                @forelse($recentTickets as $ticket)
                <div class="flex items-center p-3 lg:p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all duration-200">
                    <div class="w-10 h-10 lg:w-12 lg:h-12 bg-gradient-to-br from-purple-600 via-purple-700 to-indigo-700 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-ticket-alt text-white text-sm"></i>
                    </div>
                    <div class="ml-3 lg:ml-4 flex-1">
                        <p class="text-sm font-semibold text-gray-900">{{ $ticket->event->title }}</p>
                        <p class="text-xs text-gray-500">{{ $ticket->user->name }} - {{ $ticket->purchased_at->format('d/m/Y') }}</p>
                    </div>
                    <span class="text-xs px-2 lg:px-3 py-1 rounded-full font-medium 
                        {{ $ticket->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                           ($ticket->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                        {{ ucfirst($ticket->status) }}
                    </span>
                </div>
                @empty
                <div class="text-center py-6 lg:py-8">
                    <div class="w-12 h-12 lg:w-16 lg:h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 lg:mb-4">
                        <i class="fas fa-ticket-alt text-gray-400 text-xl lg:text-2xl"></i>
                    </div>
                    <p class="text-gray-500">No hay tickets recientes</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- System Status -->
    <div class="glass-effect rounded-xl p-6 lg:p-8 shadow-lg border border-gray-200">
        <div class="flex items-center space-x-3 mb-4 lg:mb-6">
            <div class="w-8 h-8 lg:w-10 lg:h-10 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-700 rounded-xl flex items-center justify-center">
                <i class="fas fa-server text-white text-sm lg:text-lg"></i>
            </div>
            <h2 class="text-xl lg:text-2xl font-bold text-gray-900">Estado del Sistema</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-6 lg:gap-8">
            <div class="text-center p-4 lg:p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="w-16 h-16 lg:w-20 lg:h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-3 lg:mb-4">
                    <i class="fas fa-server text-white text-2xl lg:text-3xl"></i>
                </div>
                <h3 class="text-base lg:text-lg font-semibold text-gray-900 mb-1 lg:mb-2">Servidor</h3>
                <div class="flex items-center justify-center">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                    <p class="text-sm text-green-600 font-medium">Operativo</p>
                </div>
            </div>
            
            <div class="text-center p-4 lg:p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="w-16 h-16 lg:w-20 lg:h-20 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-3 lg:mb-4">
                    <i class="fas fa-database text-white text-2xl lg:text-3xl"></i>
                </div>
                <h3 class="text-base lg:text-lg font-semibold text-gray-900 mb-1 lg:mb-2">Base de Datos</h3>
                <div class="flex items-center justify-center">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                    <p class="text-sm text-green-600 font-medium">Conectada</p>
                </div>
            </div>
            
            <div class="text-center p-4 lg:p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="w-16 h-16 lg:w-20 lg:h-20 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-3 lg:mb-4">
                    <i class="fas fa-shield-alt text-white text-2xl lg:text-3xl"></i>
                </div>
                <h3 class="text-base lg:text-lg font-semibold text-gray-900 mb-1 lg:mb-2">Seguridad</h3>
                <div class="flex items-center justify-center">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                    <p class="text-sm text-green-600 font-medium">Protegido</p>
                </div>
            </div>

            <div class="text-center p-4 lg:p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="w-16 h-16 lg:w-20 lg:h-20 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-3 lg:mb-4">
                    <i class="fas fa-wifi text-white text-2xl lg:text-3xl"></i>
                </div>
                <h3 class="text-base lg:text-lg font-semibold text-gray-900 mb-1 lg:mb-2">Red</h3>
                <div class="flex items-center justify-center">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                    <p class="text-sm text-green-600 font-medium">Estable</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 