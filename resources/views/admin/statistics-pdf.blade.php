<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Estadísticas del Sistema - {{ now()->format('d/m/Y') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #2563eb;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            color: #666;
            margin: 5px 0 0 0;
        }
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .stats-row {
            display: table-row;
        }
        .stats-cell {
            display: table-cell;
            width: 25%;
            padding: 15px;
            text-align: center;
            border: 1px solid #e5e7eb;
            background-color: #f9fafb;
        }
        .stats-cell h3 {
            margin: 0 0 10px 0;
            color: #374151;
            font-size: 14px;
        }
        .stats-cell .number {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
        }
        .stats-cell .change {
            font-size: 12px;
            color: #059669;
            margin-top: 5px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            color: #2563eb;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #e5e7eb;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f3f4f6;
            font-weight: bold;
            color: #374151;
        }
        .category-item, .status-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .category-item:last-child, .status-item:last-child {
            border-bottom: none;
        }
        .sales-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 15px;
        }
        .sales-item {
            text-align: center;
            padding: 15px;
            border: 1px solid #e5e7eb;
            background-color: #f9fafb;
        }
        .sales-month {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 5px;
        }
        .sales-amount {
            font-size: 18px;
            font-weight: bold;
            color: #2563eb;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #6b7280;
            font-size: 12px;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Estadísticas del Sistema</h1>
        <p>Reporte generado el {{ now()->format('d/m/Y H:i') }}</p>
        <p>Wasi Tickets - Sistema de Gestión de Eventos</p>
    </div>

    <!-- Estadísticas Generales -->
    <div class="stats-grid">
        <div class="stats-row">
            <div class="stats-cell">
                <h3>Total Usuarios</h3>
                <div class="number">{{ $totalUsers }}</div>
                <div class="change">+{{ $usersThisMonth }} este mes</div>
            </div>
            <div class="stats-cell">
                <h3>Total Eventos</h3>
                <div class="number">{{ $totalEvents }}</div>
                <div class="change">+{{ $eventsThisMonth }} este mes</div>
            </div>
            <div class="stats-cell">
                <h3>Total Tickets</h3>
                <div class="number">{{ $totalTickets }}</div>
                <div class="change">+{{ $ticketsThisMonth }} este mes</div>
            </div>
            <div class="stats-cell">
                <h3>Ingresos Totales</h3>
                <div class="number">${{ number_format($totalRevenue, 2) }}</div>
                <div class="change">+${{ number_format($revenueThisMonth, 2) }} este mes</div>
            </div>
        </div>
    </div>

    <!-- Eventos por Categoría -->
    <div class="section">
        <h2>Eventos por Categoría</h2>
        @foreach($eventsByCategory as $category)
            <div class="category-item">
                <span>{{ Event::categories()[$category->category] ?? $category->category }}</span>
                <strong>{{ $category->total }}</strong>
            </div>
        @endforeach
    </div>

    <!-- Tickets por Estado -->
    <div class="section">
        <h2>Tickets por Estado</h2>
        @foreach($ticketsByStatus as $status)
            <div class="status-item">
                <span>{{ ucfirst($status->status) }}</span>
                <strong>{{ $status->total }}</strong>
            </div>
        @endforeach
    </div>

    <!-- Top Eventos -->
    <div class="section">
        <h2>Top 5 Eventos Más Populares</h2>
        <table>
            <thead>
                <tr>
                    <th>Evento</th>
                    <th>Organizador</th>
                    <th>Tickets Vendidos</th>
                    <th>Ingresos</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topEvents as $event)
                    <tr>
                        <td>
                            <strong>{{ $event->title }}</strong><br>
                            <small>{{ $event->event_date->format('d/m/Y') }}</small>
                        </td>
                        <td>{{ $event->user->name }}</td>
                        <td>{{ $event->total_tickets }}</td>
                        <td>${{ number_format($event->total_revenue, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Usuarios Más Activos -->
    <div class="section">
        <h2>Usuarios Más Activos</h2>
        <table>
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Eventos Creados</th>
                    <th>Tickets Comprados</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topUsers as $user)
                    <tr>
                        <td>
                            <strong>{{ $user->name }}</strong><br>
                            <small>Miembro desde {{ $user->created_at->format('d/m/Y') }}</small>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->total_events }}</td>
                        <td>{{ $user->total_tickets }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Ventas Mensuales -->
    <div class="section">
        <h2>Ventas Mensuales (Últimos 6 Meses)</h2>
        <div class="sales-grid">
            @foreach($monthlySales as $sale)
                <div class="sales-item">
                    <div class="sales-month">{{ $sale['month'] }}</div>
                    <div class="sales-amount">${{ number_format($sale['sales'], 2) }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="footer">
        <p>Este reporte fue generado automáticamente por el sistema Wasi Tickets</p>
        <p>Para más información, contacte al administrador del sistema</p>
    </div>
</body>
</html> 