<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Proceso de Pago') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full px-0">
            <!-- Progress Steps -->
            <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200 mb-8">
                <div class="flex items-center justify-center space-x-8">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-green-600 text-xl"></i>
                        </div>
                        <span class="ml-3 text-sm font-medium text-green-700">Resumen</span>
                    </div>
                    <div class="flex-1 h-1 bg-green-300"></div>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-credit-card text-blue-600 text-xl"></i>
                        </div>
                        <span class="ml-3 text-sm font-medium text-blue-700">Pago</span>
                    </div>
                    <div class="flex-1 h-1 bg-gray-200"></div>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-yellow-600 text-xl"></i>
                        </div>
                        <span class="ml-3 text-sm font-medium text-yellow-700">Confirmación</span>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="w-full flex flex-col gap-8">
                <!-- Payment Form -->
                <div class="w-full">
                    <!-- Payment Methods -->
                    <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-credit-card text-blue-600 mr-3"></i>
                            Método de Pago
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center p-4 border-2 border-blue-500 rounded-xl bg-blue-50">
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
                    </div>

                    <!-- Card Details -->
                    <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-lock text-green-600 mr-3"></i>
                            Información de Pago
                        </h3>
                        
                        <form id="payment-form" action="{{ route('tickets.purchase', $event) }}" method="POST" class="space-y-6">
                            @csrf
                            <input type="hidden" name="quantity" value="{{ $quantity }}">
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="card_number" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-credit-card mr-2 text-blue-600"></i>
                                        Número de Tarjeta
                                    </label>
                                    <input type="text" id="card_number" name="card_number" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                           placeholder="1234 5678 9012 3456"
                                           maxlength="19">
                                </div>
                                
                                <div>
                                    <label for="card_holder" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-user mr-2 text-blue-600"></i>
                                        Titular de la Tarjeta
                                    </label>
                                    <input type="text" id="card_holder" name="card_holder" 
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
                                    <select id="expiry_month" name="expiry_month" 
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
                                    <select id="expiry_year" name="expiry_year" 
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
                                    <input type="text" id="cvv" name="cvv" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                           placeholder="123"
                                           maxlength="4">
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Billing Information -->
                    <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-map-marker-alt text-purple-600 mr-3"></i>
                            Información de Facturación
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="billing_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user mr-2 text-purple-600"></i>
                                    Nombre Completo
                                </label>
                                <input type="text" id="billing_name" name="billing_name" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200"
                                       value="{{ auth()->user()->name }}"
                                       placeholder="Nombre Completo">
                            </div>
                            
                            <div>
                                <label for="billing_email" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-envelope mr-2 text-purple-600"></i>
                                    Email
                                </label>
                                <input type="email" id="billing_email" name="billing_email" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200"
                                       value="{{ auth()->user()->email }}"
                                       placeholder="email@ejemplo.com">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="billing_address" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-home mr-2 text-purple-600"></i>
                                    Dirección
                                </label>
                                <input type="text" id="billing_address" name="billing_address" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200"
                                       placeholder="Dirección completa">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Order Summary -->
                <div class="lg:col-span-1">
                    <div class="sticky top-8">
                        <div class="glass-effect rounded-xl p-12 shadow-lg border border-gray-200 w-full">
                            <h3 class="text-2xl font-bold text-gray-900 mb-10 flex items-center">
                                <i class="fas fa-receipt text-green-600 mr-4"></i>
                                Resumen del Pedido
                            </h3>
                            
                            <!-- Event Info -->
                            <div class="border-b border-gray-200 pb-6 mb-6">
                                <div class="flex flex-col items-center text-center">
                                    @if($event->image_path)
                                        <img src="{{ $event->image_url }}" alt="{{ $event->title }}" 
                                             class="w-24 h-24 object-cover rounded-xl shadow-lg mb-4">
                                    @else
                                        <div class="w-24 h-24 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-xl flex items-center justify-center shadow-lg mb-4">
                                            <i class="fas fa-calendar text-white text-2xl"></i>
                                        </div>
                                    @endif
                                    <div class="w-full">
                                        <h4 class="font-bold text-gray-900 text-lg mb-2">{{ $event->title }}</h4>
                                        <p class="text-sm text-gray-600 mb-1">{{ $event->formatted_date }}</p>
                                        <p class="text-sm text-gray-600">{{ $event->location }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Order Details -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10 w-full">
                                <div class="flex flex-col items-center bg-white rounded-xl shadow py-8 px-5 mb-6">
                                    <span class="flex items-center justify-center w-12 h-12 rounded-xl bg-blue-100 mb-4">
                                        <i class="fas fa-calendar text-blue-600 text-2xl"></i>
                                    </span>
                                    <div class="text-base text-gray-500 font-medium mb-1">Fecha y Hora</div>
                                    <div class="text-xl font-semibold text-gray-900 text-center">{{ $event->formatted_date }}</div>
                                </div>
                                <div class="flex flex-col items-center bg-white rounded-xl shadow py-8 px-5 mb-6">
                                    <span class="flex items-center justify-center w-12 h-12 rounded-xl bg-yellow-100 mb-4">
                                        <i class="fas fa-dollar-sign text-yellow-500 text-2xl"></i>
                                    </span>
                                    <div class="text-base text-gray-500 font-medium mb-1">Precio</div>
                                    <div class="text-2xl font-bold text-green-600 text-center">{{ $event->formatted_price }}</div>
                                </div>
                                <div class="flex flex-col items-center bg-white rounded-xl shadow py-8 px-5 mb-6">
                                    <span class="flex items-center justify-center w-12 h-12 rounded-xl bg-green-100 mb-4">
                                        <i class="fas fa-map-marker-alt text-green-600 text-2xl"></i>
                                    </span>
                                    <div class="text-base text-gray-500 font-medium mb-1">Ubicación</div>
                                    <div class="text-lg font-semibold text-gray-900 text-center">{{ $event->location }}</div>
                                </div>
                                <div class="flex flex-col items-center bg-white rounded-xl shadow py-8 px-5 mb-6">
                                    <span class="flex items-center justify-center w-12 h-12 rounded-xl bg-indigo-100 mb-4">
                                        <i class="fas fa-users text-indigo-600 text-2xl"></i>
                                    </span>
                                    <div class="text-base text-gray-500 font-medium mb-1">Entradas</div>
                                    <div class="text-lg font-semibold text-gray-900 text-center">{{ $quantity }} x {{ $event->formatted_price }}</div>
                                </div>
                                <div class="flex flex-col items-center bg-white rounded-xl shadow py-8 px-5 mb-6">
                                    <span class="flex items-center justify-center w-12 h-12 rounded-xl bg-purple-100 mb-4">
                                        <i class="fas fa-tag text-purple-600 text-2xl"></i>
                                    </span>
                                    <div class="text-base text-gray-500 font-medium mb-1">Categoría</div>
                                    <div class="text-lg font-semibold text-gray-900 text-center">
                                        {{ \App\Models\Event::categories()[$event->category] ?? $event->category }}
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Price Breakdown -->
                            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4 text-center">
                                    <i class="fas fa-calculator text-blue-600 mr-2"></i>
                                    Desglose de Precios
                                </h4>
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-gray-600 flex items-center">
                                            <i class="fas fa-ticket-alt mr-2 text-blue-500"></i>
                                            Subtotal ({{ $quantity }} entradas):
                                        </span>
                                        <span class="font-semibold text-gray-900 text-lg">${{ number_format($event->price * $quantity, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-gray-600 flex items-center">
                                            <i class="fas fa-percentage mr-2 text-orange-500"></i>
                                            Comisión (2%):
                                        </span>
                                        <span class="font-semibold text-gray-900 text-lg">${{ number_format(($event->price * $quantity) * 0.02, 2) }}</span>
                                    </div>
                                    <hr class="border-gray-300 my-4">
                                    <div class="flex justify-between items-center py-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg px-4">
                                        <span class="text-xl font-bold text-gray-900 flex items-center">
                                            <i class="fas fa-dollar-sign mr-2 text-green-600"></i>
                                            Total a Pagar:
                                        </span>
                                        <span class="text-2xl font-bold text-green-600">${{ number_format(($event->price * $quantity) * 1.02, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Security Info -->
                            <div class="bg-green-50 rounded-xl p-4 mb-6">
                                <div class="flex items-center">
                                    <i class="fas fa-shield-alt text-green-600 mr-3"></i>
                                    <div>
                                        <p class="text-sm font-semibold text-green-800">Pago Seguro</p>
                                        <p class="text-xs text-green-600">Tus datos están protegidos con encriptación SSL</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Pay Button -->
                            <button type="submit" id="pay-button"
                                    class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                <i class="fas fa-lock mr-3"></i>
                                Pagar {{ number_format(($event->price * $quantity) * 1.02, 2) }}
                            </button>
                            
                            <p class="text-xs text-gray-500 text-center mt-4">
                                Al completar la compra, aceptas nuestros 
                                <a href="#" class="text-blue-600 hover:underline">términos y condiciones</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Format card number with spaces
        document.getElementById('card_number').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
            let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
            e.target.value = formattedValue;
        });

        // Format CVV to only allow numbers
        document.getElementById('cvv').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
        });

        // Handle payment method selection
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const cardForm = document.getElementById('payment-form');
                const payButton = document.getElementById('pay-button');
                
                if (this.value === 'transfer') {
                    cardForm.style.display = 'none';
                    payButton.innerHTML = '<i class="fas fa-university mr-3"></i>Crear Pedido por Transferencia';
                    payButton.className = 'w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1';
                } else {
                    cardForm.style.display = 'block';
                    payButton.innerHTML = '<i class="fas fa-lock mr-3"></i>Pagar {{ number_format(($event->price * $quantity) * 1.02, 2) }}';
                    payButton.className = 'w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1';
                }
            });
        });

        // Form validation
        document.getElementById('payment-form').addEventListener('submit', function(e) {
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            
            if (paymentMethod === 'card') {
                const cardNumber = document.getElementById('card_number').value;
                const cardHolder = document.getElementById('card_holder').value;
                const expiryMonth = document.getElementById('expiry_month').value;
                const expiryYear = document.getElementById('expiry_year').value;
                const cvv = document.getElementById('cvv').value;
                
                if (!cardNumber || !cardHolder || !expiryMonth || !expiryYear || !cvv) {
                    e.preventDefault();
                    alert('Por favor completa todos los campos de la tarjeta.');
                    return false;
                }
                
                if (cardNumber.replace(/\s/g, '').length < 13) {
                    e.preventDefault();
                    alert('El número de tarjeta debe tener al menos 13 dígitos.');
                    return false;
                }
                
                if (cvv.length < 3) {
                    e.preventDefault();
                    alert('El CVV debe tener al menos 3 dígitos.');
                    return false;
                }
            }
        });
    </script>
</x-app-layout> 