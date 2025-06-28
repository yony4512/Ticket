<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pago Exitoso') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-effect rounded-xl p-8 shadow-lg border border-gray-200 text-center">
                <!-- Success Icon -->
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-check-circle text-green-600 text-4xl"></i>
                </div>
                
                <h1 class="text-3xl font-bold text-gray-900 mb-4">¡Pago Procesado Exitosamente!</h1>
                <p class="text-lg text-gray-600 mb-8">Tus entradas han sido confirmadas y están listas para usar.</p>
                
                <!-- Ticket Details -->
                <div class="bg-gray-50 rounded-xl p-6 mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Detalles del Ticket</h3>
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
                            <p class="text-sm text-gray-600">Total Pagado:</p>
                            <p class="font-semibold text-green-600">S/. {{ number_format($ticket->total_price, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Fecha de Compra:</p>
                            <p class="font-semibold text-gray-900">{{ $ticket->purchased_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Estado:</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-2"></i>
                                Confirmado
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('tickets.download', $ticket) }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                        <i class="fas fa-download mr-2"></i>
                        Descargar Ticket
                    </a>
                    <a href="{{ route('tickets.index') }}" 
                       class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                        <i class="fas fa-ticket-alt mr-2"></i>
                        Ver Mis Tickets
                    </a>
                    <a href="{{ route('events.show', $ticket->event) }}" 
                       class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                        <i class="fas fa-calendar mr-2"></i>
                        Ver Evento
                    </a>
                </div>
                
                <!-- Important Information -->
                <div class="mt-8 p-4 bg-blue-50 rounded-xl">
                    <h4 class="font-semibold text-blue-900 mb-2 flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        Información Importante
                    </h4>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Guarda tu código de ticket en un lugar seguro</li>
                        <li>• Presenta el ticket al ingresar al evento</li>
                        <li>• El ticket es válido solo para la fecha del evento</li>
                        <li>• No se permiten reembolsos después de la compra</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 