<x-app-layout>
    <x-slot name="header">
        {{-- Título eliminado --}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Progress Steps -->
            <div class="bg-white rounded-2xl p-6 shadow-xl border border-gray-100 mb-8">
                <div class="flex items-center justify-center space-x-8">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-600 to-emerald-600 rounded-full flex items-center justify-center shadow-lg">
                            <i class="fas fa-check text-white text-xl"></i>
                        </div>
                        <span class="ml-3 text-sm font-medium text-green-700">Resumen</span>
                    </div>
                    <div class="flex-1 h-1 bg-gradient-to-r from-green-300 to-emerald-300"></div>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-full flex items-center justify-center shadow-lg">
                            <i class="fas fa-credit-card text-white text-xl"></i>
                        </div>
                        <span class="ml-3 text-sm font-medium text-blue-700">Pago</span>
                    </div>
                    <div class="flex-1 h-1 bg-gray-200"></div>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-full flex items-center justify-center shadow-lg">
                            <i class="fas fa-check text-white text-xl"></i>
                        </div>
                        <span class="ml-3 text-sm font-medium text-yellow-700">Confirmación</span>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Payment Form -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Payment Methods -->
                    <div class="bg-white rounded-2xl p-6 shadow-xl border border-gray-100">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg mr-3">
                                <i class="fas fa-credit-card text-white text-sm"></i>
                            </div>
                            Método de Pago
                        </h3>
                        
                        <form id="payment-form" action="{{ route('tickets.purchase', $event) }}" method="POST" class="space-y-6">
                            @csrf
                            <input type="hidden" name="quantity" value="{{ $quantity }}">
                            
                            <div class="space-y-4">
                                <div class="flex items-center p-4 border-2 border-blue-500 rounded-xl bg-gradient-to-r from-blue-50 to-indigo-50">
                                    <input type="radio" name="payment_method" value="card" id="card" checked
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <label for="card" class="ml-3 flex items-center">
                                        <i class="fas fa-credit-card text-blue-600 text-xl mr-3"></i>
                                        <div>
                                            <p class="font-semibold text-gray-900">Tarjeta de Crédito/Débito</p>
                                            <p class="text-sm text-gray-600">Visa, Mastercard, American Express</p>
                                        </div>
                                    </label>
                                </div>
                                
                                <div class="flex items-center p-4 border-2 border-gray-200 rounded-xl hover:border-gray-300 transition-colors">
                                    <input type="radio" name="payment_method" value="transfer" id="transfer"
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <label for="transfer" class="ml-3 flex items-center">
                                        <i class="fas fa-university text-gray-600 text-xl mr-3"></i>
                                        <div>
                                            <p class="font-semibold text-gray-900">Transferencia Bancaria</p>
                                            <p class="text-sm text-gray-600">Pago en 24-48 horas</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Card Details -->
                    <div class="bg-white rounded-2xl p-6 shadow-xl border border-gray-100">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-br from-green-600 to-emerald-600 rounded-lg flex items-center justify-center shadow-lg mr-3">
                                <i class="fas fa-lock text-white text-sm"></i>
                            </div>
                            Información de Pago
                        </h3>
                        
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="card_number" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-credit-card mr-2 text-blue-600"></i>
                                        Número de Tarjeta
                                    </label>
                                    <input type="text" id="card_number" name="card_number" form="payment-form"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                           placeholder="1234 5678 9012 3456"
                                           maxlength="19">
                                </div>
                                
                                <div>
                                    <label for="card_holder" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-user mr-2 text-blue-600"></i>
                                        Titular de la Tarjeta
                                    </label>
                                    <input type="text" id="card_holder" name="card_holder" form="payment-form"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                           placeholder="NOMBRE APELLIDO">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="expiry_month" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-calendar mr-2 text-blue-600"></i>
                                        Mes
                                    </label>
                                    <select id="expiry_month" name="expiry_month" form="payment-form"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                        <option value="">MM</option>
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                        @endfor
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="expiry_year" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-calendar mr-2 text-blue-600"></i>
                                        Año
                                    </label>
                                    <select id="expiry_year" name="expiry_year" form="payment-form"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                        <option value="">YYYY</option>
                                        @for($i = date('Y'); $i <= date('Y') + 10; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="cvv" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-shield-alt mr-2 text-blue-600"></i>
                                        CVV
                                    </label>
                                    <input type="text" id="cvv" name="cvv" form="payment-form"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                           placeholder="123"
                                           maxlength="4">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Billing Information -->
                    <div class="bg-white rounded-2xl p-6 shadow-xl border border-gray-100">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg mr-3">
                                <i class="fas fa-map-marker-alt text-white text-sm"></i>
                            </div>
                            Información de Facturación
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="billing_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user mr-2 text-purple-600"></i>
                                    Nombre Completo
                                </label>
                                <input type="text" id="billing_name" name="billing_name" form="payment-form"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200"
                                       value="{{ auth()->user()->name }}"
                                       placeholder="Nombre Completo" required>
                            </div>
                            
                            <div>
                                <label for="billing_email" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-envelope mr-2 text-purple-600"></i>
                                    Email
                                </label>
                                <input type="email" id="billing_email" name="billing_email" form="payment-form"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200"
                                       value="{{ auth()->user()->email }}"
                                       placeholder="email@ejemplo.com" required>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="billing_address" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-home mr-2 text-purple-600"></i>
                                    Dirección
                                </label>
                                <input type="text" id="billing_address" name="billing_address" form="payment-form"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200"
                                       placeholder="Dirección completa" required>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-sticky-note mr-2 text-purple-600"></i>
                                    Notas Adicionales (Opcional)
                                </label>
                                <textarea id="notes" name="notes" rows="3" form="payment-form"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200"
                                          placeholder="Información adicional para tu pedido..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Order Summary -->
                <div class="lg:col-span-1">
                    <div class="sticky top-8">
                        <div class="bg-white rounded-2xl p-8 shadow-xl border border-gray-100">
                            <h3 class="text-2xl font-bold text-gray-900 mb-8 flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-green-600 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg mr-4">
                                    <i class="fas fa-receipt text-white text-lg"></i>
                                </div>
                                Resumen del Pedido
                            </h3>
                            
                            <!-- Event Info -->
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 mb-6 border border-blue-100">
                                <div class="flex items-center space-x-4">
                                    @if($event->image_path)
                                        <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-16 h-16 rounded-lg object-cover">
                                    @else
                                        <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-calendar text-white text-xl"></i>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 text-lg">{{ $event->title }}</h4>
                                        <p class="text-sm text-gray-600">{{ $event->formatted_date }}</p>
                                        <p class="text-sm text-gray-600">{{ $event->location }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Order Details -->
                            <div class="space-y-4 mb-6">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Cantidad de entradas:</span>
                                    <span class="font-semibold text-gray-900">{{ $quantity }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Precio por entrada:</span>
                                    <span class="font-semibold text-gray-900">{{ $event->formatted_price }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Subtotal:</span>
                                    <span class="font-semibold text-gray-900">S/. {{ number_format($event->price * $quantity, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Comisión (2%):</span>
                                    <span class="font-semibold text-gray-900">S/. {{ number_format(($event->price * $quantity) * 0.02, 2) }}</span>
                                </div>
                                <hr class="border-gray-200">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-gray-900">Total:</span>
                                    <span class="text-2xl font-bold text-green-600">S/. {{ number_format(($event->price * $quantity) * 1.02, 2) }}</span>
                                </div>
                            </div>
                            
                            <!-- Payment Button -->
                            <button type="submit" form="payment-form"
                                    class="w-full bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 hover:from-green-700 hover:via-emerald-700 hover:to-teal-700 text-white font-semibold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-lock mr-2"></i>
                                Pagar S/. {{ number_format(($event->price * $quantity) * 1.02, 2) }}
                            </button>
                            
                            <!-- Security Notice -->
                            <div class="mt-6 text-center">
                                <div class="flex items-center justify-center space-x-2 text-sm text-gray-500">
                                    <i class="fas fa-shield-alt text-green-600"></i>
                                    <span>Pago seguro con encriptación SSL</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Card number formatting
        document.getElementById('card_number').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
            let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
            e.target.value = formattedValue;
        });

        // CVV formatting
        document.getElementById('cvv').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
        });

        // Payment method toggle
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const cardFields = document.querySelectorAll('#card_number, #card_holder, #expiry_month, #expiry_year, #cvv');
                cardFields.forEach(field => {
                    field.required = this.value === 'card';
                    field.disabled = this.value === 'transfer';
                });
            });
        });
    </script>
</x-app-layout> 