<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte General - Sistema de Tickets</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
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
            vertical-align: top;
        }
        .stats-cell h3 {
            margin: 0 0 10px 0;
            color: #2563eb;
            font-size: 14px;
        }
        .stats-number {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
            margin: 5px 0;
        }
        .stats-subtitle {
            font-size: 10px;
            color: #6b7280;
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
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f9fafb;
            font-weight: bold;
            color: #374151;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #6b7280;
            font-size: 10px;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte General del Sistema</h1>
        <p>Sistema de Gestión de Tickets y Eventos</p>
        <p>Generado el: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <div class="stats-grid">
        <div class="stats-row">
            <div class="stats-cell">
                <h3>Total Usuarios</h3>
                <div class="stats-number">{{ $userStats['total'] }}</div>
                <div class="stats-subtitle">+{{ $userStats['this_month'] }} este mes</div>
            </div>
            <div class="stats-cell">
                <h3>Total Eventos</h3>
                <div class="stats-number">{{ $eventStats['total'] }}</div>
                <div class="stats-subtitle">{{ $eventStats['active'] }} activos</div>
            </div>
            <div class="stats-cell">
                <h3>Total Tickets</h3>
                <div class="stats-number">{{ $ticketStats['total'] }}</div>
                <div class="stats-subtitle">{{ $ticketStats['confirmed'] }} confirmados</div>
            </div>
            <div class="stats-cell">
                <h3>Ingresos Totales</h3>
                <div class="stats-number">S/. {{ number_format($ticketStats['total_revenue'], 2) }}</div>
                <div class="stats-subtitle">S/. {{ number_format($ticketStats['monthly_revenue'], 2) }} este mes</div>
            </div>
        </div>
    </div>

    <div class="section">
        <h2>Estado de Tickets</h2>
        <table>
            <thead>
                <tr>
                    <th>Estado</th>
                    <th>Cantidad</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Pendientes</td>
                    <td>{{ $ticketStats['pending'] }}</td>
                    <td>{{ $ticketStats['total'] > 0 ? round(($ticketStats['pending'] / $ticketStats['total']) * 100, 1) : 0 }}%</td>
                </tr>
                <tr>
                    <td>Confirmados</td>
                    <td>{{ $ticketStats['confirmed'] }}</td>
                    <td>{{ $ticketStats['total'] > 0 ? round(($ticketStats['confirmed'] / $ticketStats['total']) * 100, 1) : 0 }}%</td>
                </tr>
                <tr>
                    <td>Usados</td>
                    <td>{{ $ticketStats['used'] }}</td>
                    <td>{{ $ticketStats['total'] > 0 ? round(($ticketStats['used'] / $ticketStats['total']) * 100, 1) : 0 }}%</td>
                </tr>
                <tr>
                    <td>Cancelados</td>
                    <td>{{ $ticketStats['cancelled'] }}</td>
                    <td>{{ $ticketStats['total'] > 0 ? round(($ticketStats['cancelled'] / $ticketStats['total']) * 100, 1) : 0 }}%</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Eventos por Categoría</h2>
        <table>
            <thead>
                <tr>
                    <th>Categoría</th>
                    <th>Cantidad</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($eventStats['by_category'] as $category)
                <tr>
                    <td>{{ ucfirst($category->category) }}</td>
                    <td>{{ $category->total }}</td>
                    <td>{{ $eventStats['total'] > 0 ? round(($category->total / $eventStats['total']) * 100, 1) : 0 }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Este reporte fue generado automáticamente por el Sistema de Gestión de Tickets</p>
        <p>© {{ date('Y') }} Sistema de Tickets. Todos los derechos reservados.</p>
    </div>
</body>
</html> 