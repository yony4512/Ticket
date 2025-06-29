<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Eventos - Sistema de Tickets</title>
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
            border-bottom: 2px solid #059669;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #059669;
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
            background-color: #f0fdf4;
            font-weight: bold;
            color: #166534;
        }
        .status-active {
            color: #059669;
            font-weight: bold;
        }
        .status-inactive {
            color: #dc2626;
            font-weight: bold;
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
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .summary h3 {
            margin: 0 0 10px 0;
            color: #166534;
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
            width: 25%;
            padding: 5px;
            text-align: center;
        }
        .summary-number {
            font-size: 16px;
            font-weight: bold;
            color: #166534;
        }
        .summary-label {
            font-size: 9px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Eventos</h1>
        <p>Sistema de Gestión de Tickets y Eventos</p>
        <p>Generado el: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <div class="summary">
        <h3>Resumen de Eventos</h3>
        <div class="summary-stats">
            <div class="summary-row">
                <div class="summary-cell">
                    <div class="summary-number">{{ $events->count() }}</div>
                    <div class="summary-label">Total Eventos</div>
                </div>
                <div class="summary-cell">
                    <div class="summary-number">{{ $events->where('status', 'active')->count() }}</div>
                    <div class="summary-label">Activos</div>
                </div>
                <div class="summary-cell">
                    <div class="summary-number">{{ $events->where('event_date', '>', now())->count() }}</div>
                    <div class="summary-label">Futuros</div>
                </div>
                <div class="summary-cell">
                    <div class="summary-number">{{ $events->where('event_date', '<', now())->count() }}</div>
                    <div class="summary-label">Pasados</div>
                </div>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Evento</th>
                <th>Organizador</th>
                <th>Categoría</th>
                <th>Fecha</th>
                <th>Ubicación</th>
                <th>Precio</th>
                <th>Estado</th>
                <th>Tickets</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
            <tr>
                <td>
                    <strong>{{ $event->title }}</strong><br>
                    <small>{{ Str::limit($event->description, 50) }}</small>
                </td>
                <td>{{ $event->user->name }}</td>
                <td>{{ ucfirst($event->category) }}</td>
                <td>{{ $event->event_date->format('d/m/Y H:i') }}</td>
                <td>{{ $event->location }}</td>
                <td>S/. {{ number_format($event->price, 2) }}</td>
                <td>
                    <span class="status-{{ $event->status }}">
                        {{ $event->status === 'active' ? 'Activo' : 'Inactivo' }}
                    </span>
                </td>
                <td>
                    {{ $event->tickets->count() }} vendidos<br>
                    <small>Capacidad: {{ $event->capacity ?? 'Ilimitada' }}</small>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 20px; color: #6b7280;">
                    No hay eventos registrados
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Este reporte fue generado automáticamente por el Sistema de Gestión de Tickets</p>
        <p>© {{ date('Y') }} Sistema de Tickets. Todos los derechos reservados.</p>
    </div>
</body>
</html> 