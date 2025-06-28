@extends('layouts.admin')

@section('title', 'Reportes y Estadísticas')


@section('content')
<div class="space-y-6">
    <!-- Estadísticas Generales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Usuarios -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Usuarios</p>
                    <p class="text-3xl font-bold">{{ $userStats['total'] }}</p>
                    <p class="text-blue-100 text-xs mt-1">+{{ $userStats['this_month'] }} este mes</p>
                </div>
                <div class="w-12 h-12 bg-blue-400 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Eventos -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Eventos</p>
                    <p class="text-3xl font-bold">{{ $eventStats['total'] }}</p>
                    <p class="text-green-100 text-xs mt-1">{{ $eventStats['active'] }} activos</p>
                </div>
                <div class="w-12 h-12 bg-green-400 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Tickets -->
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">Total Tickets</p>
                    <p class="text-3xl font-bold">{{ $ticketStats['total'] }}</p>
                    <p class="text-orange-100 text-xs mt-1">{{ $ticketStats['confirmed'] }} confirmados</p>
                </div>
                <div class="w-12 h-12 bg-orange-400 rounded-lg flex items-center justify-center">
                    <i class="fas fa-ticket-alt text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Ingresos -->
        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-100 text-sm font-medium">Ingresos Totales</p>
                    <p class="text-3xl font-bold">S/. {{ number_format($ticketStats['total_revenue'], 2) }}</p>
                    <p class="text-emerald-100 text-xs mt-1">S/. {{ number_format($ticketStats['monthly_revenue'], 2) }} este mes</p>
                </div>
                <div class="w-12 h-12 bg-emerald-400 rounded-lg flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos y Análisis -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Estado de Tickets -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Estado de Tickets</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-yellow-400 rounded-full mr-3"></div>
                            <span class="text-sm text-gray-700">Pendientes</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">{{ $ticketStats['pending'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-green-400 rounded-full mr-3"></div>
                            <span class="text-sm text-gray-700">Confirmados</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">{{ $ticketStats['confirmed'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-blue-400 rounded-full mr-3"></div>
                            <span class="text-sm text-gray-700">Usados</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">{{ $ticketStats['used'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-red-400 rounded-full mr-3"></div>
                            <span class="text-sm text-gray-700">Cancelados</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">{{ $ticketStats['cancelled'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Eventos por Categoría -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Eventos por Categoría</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($eventStats['by_category'] as $category)
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">{{ ucfirst($category->category) }}</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $category->total }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Top Eventos -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Top 10 Eventos por Ventas</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Evento
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tickets Vendidos
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ingresos
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Organizador
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($topEvents as $event)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $event->title }}</div>
                                <div class="text-sm text-gray-500">{{ $event->location }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $event->total_tickets ?? 0 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                S/. {{ number_format($event->total_revenue ?? 0, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $event->user->name }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                No hay eventos con ventas registradas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Actividad Reciente -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Actividad Reciente</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-plus text-blue-600 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-900">Nuevo usuario registrado</p>
                        <p class="text-xs text-gray-500">Hace 2 horas</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-calendar-plus text-green-600 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-900">Nuevo evento creado</p>
                        <p class="text-xs text-gray-500">Hace 4 horas</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-ticket-alt text-orange-600 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-900">Ticket vendido</p>
                        <p class="text-xs text-gray-500">Hace 6 horas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 