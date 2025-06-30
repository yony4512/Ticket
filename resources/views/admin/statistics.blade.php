@extends('layouts.admin')

@section('title', 'Estadísticas del Sistema')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-slate-900 via-blue-800 to-indigo-800 bg-clip-text text-transparent">
                Estadísticas del Sistema
            </h1>
            <p class="text-gray-600 mt-2">Análisis detallado del rendimiento del sistema</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.statistics.download') }}" 
               class="inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                <i class="fas fa-download mr-2"></i>
                Descargar PDF
            </a>
        </div>
    </div>

    <!-- Estadísticas Generales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Usuarios</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalUsers }}</p>
                    <p class="text-sm text-green-600">+{{ $usersThisMonth }} este mes</p>
                </div>
            </div>
        </div>

        <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-green-600 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-calendar text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Eventos</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalEvents }}</p>
                    <p class="text-sm text-green-600">+{{ $eventsThisMonth }} este mes</p>
                </div>
            </div>
        </div>

        <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-ticket-alt text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Tickets</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalTickets }}</p>
                    <p class="text-sm text-green-600">+{{ $ticketsThisMonth }} este mes</p>
                </div>
            </div>
        </div>

        <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-600 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-dollar-sign text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Ingresos Totales</p>
                    <p class="text-2xl font-bold text-gray-900">${{ number_format($totalRevenue, 2) }}</p>
                    <p class="text-sm text-green-600">+${{ number_format($revenueThisMonth, 2) }} este mes</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos y Análisis -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Eventos por Categoría -->
        <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Eventos por Categoría</h3>
            <div class="space-y-3">
                @foreach($eventsByCategory as $category)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-blue-500 rounded-full mr-3"></div>
                            <span class="text-sm font-medium text-gray-700">
                                {{ \App\Models\Event::categories()[$category->category] ?? $category->category }}
                            </span>
                        </div>
                        <span class="text-sm font-bold text-gray-900">{{ $category->total }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Tickets por Estado -->
        <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Tickets por Estado</h3>
            <div class="space-y-3">
                @foreach($ticketsByStatus as $status)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-{{ $status->status === 'confirmed' ? 'green' : ($status->status === 'pending' ? 'yellow' : 'gray') }}-500 rounded-full mr-3"></div>
                            <span class="text-sm font-medium text-gray-700">{{ ucfirst($status->status) }}</span>
                        </div>
                        <span class="text-sm font-bold text-gray-900">{{ $status->total }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Top Eventos -->
    <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Top 5 Eventos Más Populares</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Evento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Organizador</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tickets Vendidos</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ingresos</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($topEvents as $event)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $event->title }}</div>
                                <div class="text-sm text-gray-500">{{ $event->event_date->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $event->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $event->total_tickets }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($event->total_revenue, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Usuarios Más Activos -->
    <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Usuarios Más Activos</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Eventos Creados</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tickets Comprados</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($topUsers as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                <div class="text-sm text-gray-500">Miembro desde {{ $user->created_at->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->total_events }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->total_tickets }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Ventas Mensuales -->
    <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Ventas Mensuales (Últimos 6 Meses)</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($monthlySales as $sale)
                <div class="text-center p-4 bg-white rounded-lg shadow-sm border border-gray-100">
                    <div class="text-sm font-medium text-gray-600">{{ $sale['month'] }}</div>
                    <div class="text-lg font-bold text-gray-900">${{ number_format($sale['sales'], 2) }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection 