@php
    use App\Models\Event;
    use Illuminate\Support\Str;
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrada - {{ $ticket->event->title }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .ticket {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }
        .content {
            padding: 30px;
        }
        .event-info {
            margin-bottom: 30px;
        }
        .event-info h2 {
            color: #333;
            margin: 0 0 20px 0;
            font-size: 20px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        .info-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .info-item i {
            width: 20px;
            color: #667eea;
        }
        .info-item span {
            color: #666;
            font-size: 14px;
        }
        .ticket-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .ticket-details h3 {
            margin: 0 0 15px 0;
            color: #333;
            font-size: 16px;
        }
        .ticket-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .ticket-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .ticket-item:last-child {
            border-bottom: none;
        }
        .ticket-label {
            font-weight: bold;
            color: #333;
        }
        .ticket-value {
            color: #666;
        }
        .qr-code {
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            background: white;
            border: 2px dashed #ddd;
            border-radius: 8px;
        }
        .qr-code p {
            margin: 10px 0 0 0;
            font-family: monospace;
            font-size: 12px;
            color: #666;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #667eea;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }
        .print-button:hover {
            background: #5a6fd8;
        }
        @media print {
            .print-button {
                display: none;
            }
            body {
                background: white;
            }
            .ticket {
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }
    </style>
</head>
<body>
    <button class="print-button" onclick="window.print()">
        🖨️ Imprimir Entrada
    </button>

    <div class="ticket">
        <div class="header">
            <h1>🎫 Entrada de Evento</h1>
            <p>Wasi Tickets - Cusco</p>
        </div>

        <div class="content">
            <div class="event-info">
                <h2>{{ $ticket->event->title }}</h2>
                
                <div class="info-grid">
                    <div class="info-item">
                        <i>📅</i>
                        <span>{{ $ticket->event->formatted_date }}</span>
                    </div>
                    <div class="info-item">
                        <i>📍</i>
                        <span>{{ $ticket->event->location }}</span>
                    </div>
                    <div class="info-item">
                        <i>👤</i>
                        <span>{{ $ticket->event->user->name }}</span>
                    </div>
                    <div class="info-item">
                        <i>🏷️</i>
                        <span>{{ \App\Models\Event::categories()[$ticket->event->category] }}</span>
                    </div>
                </div>

                <div style="margin-top: 20px;">
                    <p style="color: #666; line-height: 1.6; margin: 0;">
                        {{ $ticket->event->description }}
                    </p>
                </div>
            </div>

            <div class="ticket-details">
                <h3>📋 Información de la Entrada</h3>
                <div class="ticket-grid">
                    <div class="ticket-item">
                        <span class="ticket-label">Código:</span>
                        <span class="ticket-value">{{ $ticket->ticket_code }}</span>
                    </div>
                    <div class="ticket-item">
                        <span class="ticket-label">Estado:</span>
                        <span class="ticket-value">{{ $ticket->status_label }}</span>
                    </div>
                    <div class="ticket-item">
                        <span class="ticket-label">Cantidad:</span>
                        <span class="ticket-value">{{ $ticket->quantity }} {{ Str::plural('entrada', $ticket->quantity) }}</span>
                    </div>
                    <div class="ticket-item">
                        <span class="ticket-label">Precio unitario:</span>
                        <span class="ticket-value">{{ $ticket->event->formatted_price }}</span>
                    </div>
                    <div class="ticket-item">
                        <span class="ticket-label">Total pagado:</span>
                        <span class="ticket-value" style="font-weight: bold; color: #28a745;">S/. {{ number_format($ticket->total_price, 2) }}</span>
                    </div>
                    <div class="ticket-item">
                        <span class="ticket-label">Fecha de compra:</span>
                        <span class="ticket-value">{{ $ticket->purchased_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>

                @if($ticket->notes)
                    <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e9ecef;">
                        <span class="ticket-label">Notas:</span>
                        <p style="color: #666; margin: 5px 0 0 0;">{{ $ticket->notes }}</p>
                    </div>
                @endif
            </div>

            <div class="qr-code">
                {!! QrCode::size(140)->generate($ticket->ticket_code) !!}
                <p>{{ $ticket->ticket_code }}</p>
                <p style="font-size:11px; color:#888;">Escanea este código para validar tu entrada</p>
            </div>
        </div>

        <div class="footer">
            <p><strong>Importante:</strong> Presenta esta entrada al ingresar al evento</p>
            <p>Esta entrada es válida solo para el evento especificado</p>
            <p>Generado el {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>

    <script>
        // Auto-print when page loads (optional)
        // window.onload = function() {
        //     window.print();
        // }
    </script>
</body>
</html> 