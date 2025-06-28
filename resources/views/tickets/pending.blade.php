<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pago Pendiente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-effect rounded-xl p-8 shadow-lg border border-gray-200 text-center">
                <!-- Pending Icon -->
                <div class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-clock text-yellow-600 text-4xl"></i>
                </div>
                
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Pago Pendiente</h1>
                <p class="text-lg text-gray-600 mb-8">Tu pedido ha sido creado. Completa el pago por transferencia bancaria para confirmar tus entradas.</p>
                
                <!-- Ticket Details -->
                <div class="bg-gray-50 rounded-xl p-6 mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Detalles del Pedido</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                        <div>
                            <p class="text-sm text-gray-600">Código del Ticket:</p>
                            <p class="font-semibold text-gray-900">{{ $ticket->ticket_code }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Evento:</p>
                            <p class="font-semibold text-gray-900">{{ $ticket->event->title }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Cantidad:</p>
                            <p class="font-semibold text-gray-900">{{ $ticket->quantity }} {{ Str::plural('entrada', $ticket->quantity) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total a Pagar:</p>
                            <p class="font-semibold text-green-600">S/. {{ number_format($ticket->total_price, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Fecha de Pedido:</p>
                            <p class="font-semibold text-gray-900">{{ $ticket->purchased_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Estado:</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock mr-2"></i>
                                Pendiente
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Bank Transfer Information -->
                <div class="bg-blue-50 rounded-xl p-6 mb-8">
                    <h3 class="text-xl font-semibold text-blue-900 mb-4 flex items-center">
                        <i class="fas fa-university mr-3"></i>
                        Información de Transferencia Bancaria
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                        <div>
                            <p class="text-sm text-blue-700">Banco:</p>
                            <p class="font-semibold text-blue-900">Banco de Crédito del Perú</p>
                        </div>
                        <div>
                            <p class="text-sm text-blue-700">Tipo de Cuenta:</p>
                            <p class="font-semibold text-blue-900">Cuenta Corriente</p>
                        </div>
                        <div>
                            <p class="text-sm text-blue-700">Número de Cuenta:</p>
                            <p class="font-semibold text-blue-900">193-12345678-0-12</p>
                        </div>
                        <div>
                            <p class="text-sm text-blue-700">CCI:</p>
                            <p class="font-semibold text-blue-900">002-193-000123456789-12</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-blue-700">Titular:</p>
                            <p class="font-semibold text-blue-900">EVENTOS PERU SAC</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-blue-700">Concepto de Pago:</p>
                            <p class="font-semibold text-blue-900">{{ $ticket->ticket_code }} - {{ $ticket->event->title }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Instructions -->
                <div class="bg-yellow-50 rounded-xl p-6 mb-8">
                    <h4 class="font-semibold text-yellow-900 mb-4 flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        Instrucciones de Pago
                    </h4>
                    <ol class="text-sm text-yellow-800 space-y-2 text-left">
                        <li>1. Realiza la transferencia bancaria por el monto exacto: <strong>S/. {{ number_format($ticket->total_price, 2) }}</strong></li>
                        <li>2. Usa el código del ticket como concepto de pago: <strong>{{ $ticket->ticket_code }}</strong></li>
                        <li>3. Guarda el comprobante de transferencia</li>
                        <li>4. El pago será verificado en 24-48 horas</li>
                        <li>5. Recibirás una notificación cuando se confirme el pago</li>
                    </ol>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('tickets.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                        <i class="fas fa-ticket-alt mr-2"></i>
                        Ver Mis Tickets
                    </a>
                    <a href="{{ route('events.show', $ticket->event) }}" 
                       class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                        <i class="fas fa-calendar mr-2"></i>
                        Ver Evento
                    </a>
                </div>
                
                <!-- Important Notice -->
                <div class="mt-8 p-4 bg-red-50 rounded-xl">
                    <h4 class="font-semibold text-red-900 mb-2 flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Importante
                    </h4>
                    <p class="text-sm text-red-800">
                        Si no realizas el pago en las próximas 48 horas, tu pedido será cancelado automáticamente. 
                        Una vez confirmado el pago, podrás descargar tus tickets.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 