<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Voucher de Pago Exitoso -->
            <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">
                <!-- Header del Voucher -->
                <div class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 px-8 py-6 text-center">
                    <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
                        <i class="fas fa-check-circle text-white text-3xl"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">¡PAGO EXITOSO!</h1>
                    <p class="text-emerald-100 text-lg">Tu compra ha sido procesada correctamente</p>
                </div>

                <!-- Contenido del Voucher -->
                <div class="p-8">
                    <!-- Información del Evento -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 mb-6 border border-blue-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-calendar-alt text-blue-600 mr-3"></i>
                            {{ $ticket->event->title }}
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt text-blue-600 mr-3"></i>
                                <span class="text-gray-700">{{ $ticket->event->location }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-clock text-blue-600 mr-3"></i>
                                <span class="text-gray-700">{{ $ticket->event->formatted_date }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Detalles de la Compra -->
                    <div class="bg-gradient-to-r from-gray-50 to-slate-50 rounded-xl p-6 mb-6 border border-gray-200">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-receipt text-gray-600 mr-3"></i>
                            Detalles de la Compra
                        </h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                <span class="text-gray-600">Código de Ticket:</span>
                                <span class="font-mono font-bold text-gray-900 bg-gray-100 px-3 py-1 rounded-lg">{{ $ticket->ticket_code }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                <span class="text-gray-600">Cantidad de Entradas:</span>
                                <span class="font-semibold text-gray-900">{{ $ticket->quantity }} {{ Str::plural('entrada', $ticket->quantity) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                <span class="text-gray-600">Precio por Entrada:</span>
                                <span class="font-semibold text-gray-900">{{ $ticket->event->formatted_price }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                <span class="text-gray-600">Subtotal:</span>
                                <span class="font-semibold text-gray-900">S/. {{ number_format($ticket->subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                <span class="text-gray-600">Comisión (2%):</span>
                                <span class="font-semibold text-gray-900">S/. {{ number_format($ticket->commission, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg px-4">
                                <span class="text-lg font-bold text-gray-900">TOTAL PAGADO:</span>
                                <span class="text-2xl font-bold text-green-600">S/. {{ number_format($ticket->total_price, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Facturación -->
                    <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl p-6 mb-6 border border-purple-100">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-user text-purple-600 mr-3"></i>
                            Información de Facturación
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm text-gray-600">Nombre:</span>
                                <p class="font-semibold text-gray-900">{{ $ticket->billing_name }}</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">Email:</span>
                                <p class="font-semibold text-gray-900">{{ $ticket->billing_email }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <span class="text-sm text-gray-600">Dirección:</span>
                                <p class="font-semibold text-gray-900">{{ $ticket->billing_address }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Pago -->
                    <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl p-6 mb-6 border border-yellow-100">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-credit-card text-yellow-600 mr-3"></i>
                            Información de Pago
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm text-gray-600">Método de Pago:</span>
                                <p class="font-semibold text-gray-900">
                                    @if($ticket->payment_method === 'card')
                                        <i class="fas fa-credit-card text-blue-600 mr-2"></i>
                                        Tarjeta de Crédito/Débito
                                    @else
                                        <i class="fas fa-university text-green-600 mr-2"></i>
                                        Transferencia Bancaria
                                    @endif
                                </p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">Fecha de Compra:</span>
                                <p class="font-semibold text-gray-900">{{ $ticket->purchased_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">Estado:</span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Confirmado
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Información Importante -->
                    <div class="bg-gradient-to-r from-red-50 to-pink-50 rounded-xl p-6 mb-6 border border-red-100">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-exclamation-triangle text-red-600 mr-3"></i>
                            Información Importante
                        </h3>
                        <ul class="space-y-2 text-gray-700">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                                <span>Guarda tu código de ticket en un lugar seguro</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                                <span>Presenta el ticket al ingresar al evento</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                                <span>El ticket es válido solo para la fecha del evento</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                                <span>No se permiten reembolsos después de la compra</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center pt-6 border-t border-gray-200">
                        <button onclick="window.print()" 
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                            <i class="fas fa-print mr-2"></i>
                            Imprimir Voucher
                        </button>
                        <a href="{{ route('tickets.download', $ticket) }}" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                            <i class="fas fa-download mr-2"></i>
                            Descargar PDF
                        </a>
                        <a href="{{ route('tickets.index') }}" 
                           class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                            <i class="fas fa-ticket-alt mr-2"></i>
                            Mis Tickets
                        </a>
                    </div>
                    <!-- Mostrar QR -->
                    <div class="mt-8 flex flex-col items-center">
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">Código QR de tu entrada</h4>
                        {!! QrCode::size(180)->generate($ticket->ticket_code) !!}
                        <p class="text-xs text-gray-500 mt-2">Escanea este código al ingresar al evento</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estilos para impresión -->
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .bg-white, .bg-white * {
                visibility: visible;
            }
            .bg-white {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .flex, .grid {
                display: block !important;
            }
        }
    </style>
</x-app-layout> 