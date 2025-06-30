<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Top Eventos por Ventas - Sistema de Tickets</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.3;
            color: #333;
            margin: 0;
            padding: 15px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #ea580c;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #ea580c;
            margin: 0;
            font-size: 20px;
        }
        .header p {
            color: #666;
            margin: 3px 0 0 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 10px;
        }
        th, td {
            border: 1px solid #e5e7eb;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #fff7ed;
            font-weight: bold;
            color: #c2410c;
        }
        .rank {
            text-align: center;
            font-weight: bold;
            color: #ea580c;
        }
        .rank-1 { background-color: #fef3c7; }
        .rank-2 { background-color: #f3f4f6; }
        .rank-3 { background-color: #fef2f2; }
        .revenue {
            font-weight: bold;
            color: #059669;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #6b7280;
            font-size: 9px;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
        }
        .summary {
            background-color: #fff7ed;
            border: 1px solid #fed7aa;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .summary h3 {
            margin: 0 0 10px 0;
            color: #c2410c;
            font-size: 14px;
        }
        .summary-stats {
            display: table;
            width: 100%;
        }
        .summary-row {
            display: table-row;
        }
        .summary-cell {
            display: table-cell;
            width: 33.33%;
            padding: 5px;
            text-align: center;
        }
        .summary-number {
            font-size: 16px;
            font-weight: bold;
            color: #c2410c;
        }
        .summary-label {
            font-size: 9px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Top 10 Eventos por Ventas</h1>
        <p>Sistema de Gestión de Tickets y Eventos</p>
        <p>Generado el: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <div class="summary">
        <h3>Resumen de Ventas</h3>
        <div class="summary-stats">
            <div class="summary-row">
                <div class="summary-cell">
                    <div class="summary-number">{{ $topEvents->sum('total_tickets') }}</div>
                    <div class="summary-label">Total Tickets Vendidos</div>
                </div>
                <div class="summary-cell">
                    <div class="summary-number">S/. {{ number_format($topEvents->sum('total_revenue'), 2) }}</div>
                    <div class="summary-label">Ingresos Totales</div>
                </div>
                <div class="summary-cell">
                    <div class="summary-number">{{ $topEvents->count() }}</div>
                    <div class="summary-label">Eventos con Ventas</div>
                </div>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 25%;">Evento</th>
                <th style="width: 15%;">Organizador</th>
                <th style="width: 10%;">Categoría</th>
                <th style="width: 12%;">Fecha</th>
                <th style="width: 10%;">Tickets Vendidos</th>
                <th style="width: 12%;">Ingresos</th>
                <th style="width: 11%;">Precio Unitario</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topEvents as $index => $event)
            <tr class="rank-{{ $index < 3 ? $index + 1 : '' }}">
                <td class="rank">{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $event->title }}</strong><br>
                    <small>{{ Str::limit($event->description, 40) }}</small>
                </td>
                <td>{{ $event->user->name }}</td>
                <td>{{ ucfirst($event->category) }}</td>
                <td>{{ $event->event_date->format('d/m/Y') }}</td>
                <td style="text-align: center;">{{ $event->total_tickets ?? 0 }}</td>
                <td class="revenue">S/. {{ number_format($event->total_revenue ?? 0, 2) }}</td>
                <td>S/. {{ number_format($event->price, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 20px; color: #6b7280;">
                    No hay eventos con ventas registradas
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($topEvents->isNotEmpty())
    <div style="margin-top: 20px; padding: 10px; background-color: #f9fafb; border-radius: 4px;">
        <h4 style="margin: 0 0 10px 0; color: #374151; font-size: 12px;">Análisis de Rendimiento</h4>
        <div style="font-size: 10px; color: #6b7280;">
            <p><strong>Evento con más ventas:</strong> {{ $topEvents->first()->title }} ({{ $topEvents->first()->total_tickets ?? 0 }} tickets)</p>
            <p><strong>Evento con más ingresos:</strong> {{ $topEvents->sortByDesc('total_revenue')->first()->title }} (S/. {{ number_format($topEvents->sortByDesc('total_revenue')->first()->total_revenue ?? 0, 2) }})</p>
            <p><strong>Promedio de ventas por evento:</strong> {{ round($topEvents->avg('total_tickets'), 1) }} tickets</p>
            <p><strong>Promedio de ingresos por evento:</strong> S/. {{ number_format($topEvents->avg('total_revenue'), 2) }}</p>
        </div>
    </div>
    @endif

    <div class="footer">
        <p>Este reporte fue generado automáticamente por el Sistema de Gestión de Tickets</p>
        <p>© {{ date('Y') }} Sistema de Tickets. Todos los derechos reservados.</p>
    </div>
</body>
</html> 