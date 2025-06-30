@php
    use App\Models\Event;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalles del Evento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Event Header -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-xl border border-gray-100 mb-8">
                @if($event->image_path)
                    <div class="relative h-64 lg:h-80">
                        <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-6 left-6 right-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h1 class="text-3xl lg:text-4xl font-bold text-white mb-3">{{ $event->title }}</h1>
                                    <p class="text-white/90 text-lg">Organizado por {{ $event->user->name }}</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl lg:text-3xl font-bold text-white mb-2">{{ $event->formatted_price }}</div>
                                    <p class="text-white/80 text-sm">por entrada</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="relative h-64 lg:h-80 bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-600 flex items-center justify-center">
                        <div class="text-center text-white">
                            <i class="fas fa-calendar text-6xl mb-4"></i>
                            <h1 class="text-3xl lg:text-4xl font-bold mb-3">{{ $event->title }}</h1>
                            <p class="text-xl">Organizado por {{ $event->user->name }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Event Details -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Status and Category -->
                    <div class="bg-white rounded-2xl p-6 shadow-xl border border-gray-100">
                        <div class="flex flex-wrap items-center gap-4">
                            @if($event->isSoldOut())
                                <span class="inline-flex items-center px-6 py-3 rounded-full text-base font-semibold bg-gradient-to-r from-red-100 to-pink-100 text-red-800 border border-red-200">
                                    <i class="fas fa-times-circle mr-3 text-xl"></i>
                                    Agotado
                                </span>
                            @elseif($event->event_date->isPast())
                                <span class="inline-flex items-center px-6 py-3 rounded-full text-base font-semibold bg-gradient-to-r from-gray-100 to-slate-100 text-gray-800 border border-gray-200">
                                    <i class="fas fa-calendar-times mr-3 text-xl"></i>
                                    Evento Finalizado
                                </span>
                            @else
                                <span class="inline-flex items-center px-6 py-3 rounded-full text-base font-semibold bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200">
                                    <i class="fas fa-check-circle mr-3 text-xl"></i>
                                    Disponible
                                </span>
                            @endif
                            <span class="inline-flex items-center px-6 py-3 rounded-full text-base font-semibold bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border border-blue-200">
                                <i class="fas fa-tag mr-3 text-xl"></i>
                                {{ \App\Models\Event::categories()[$event->category] ?? $event->category }}
                            </span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="bg-white rounded-2xl p-8 shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg mr-4">
                                <i class="fas fa-align-left text-white text-lg"></i>
                            </div>
                            Descripción del Evento
                        </h2>
                        <div class="prose prose-lg max-w-none">
                            <p class="text-gray-700 leading-relaxed whitespace-pre-line text-lg">{{ $event->description }}</p>
                        </div>
                    </div>

                    <!-- Event Details -->
                    <div class="bg-white rounded-2xl p-8 shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-8 flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-emerald-600 to-teal-600 rounded-xl flex items-center justify-center shadow-lg mr-4">
                                <i class="fas fa-info-circle text-white text-lg"></i>
                            </div>
                            Información del Evento
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex items-center bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg mr-4">
                                    <i class="fas fa-calendar text-white text-xl"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-600 font-medium">Fecha y Hora</div>
                                    <div class="text-lg font-semibold text-gray-900">{{ $event->formatted_date }}</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl p-6 border border-yellow-100">
                                <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg mr-4">
                                    <i class="fas fa-dollar-sign text-white text-xl"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-600 font-medium">Precio</div>
                                    <div class="text-xl font-bold text-green-600">{{ $event->formatted_price }}</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 border border-green-100">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-600 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg mr-4">
                                    <i class="fas fa-map-marker-alt text-white text-xl"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-600 font-medium">Ubicación</div>
                                    <div class="text-lg font-semibold text-gray-900">{{ $event->location }}</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl p-6 border border-purple-100">
                                <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg mr-4">
                                    <i class="fas fa-users text-white text-xl"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-600 font-medium">Capacidad</div>
                                    <div class="text-lg font-semibold text-gray-900">
                                        @if($event->available_capacity !== null)
                                            {{ $event->available_capacity }} de {{ $event->capacity }} disponibles
                                        @else
                                            {{ $event->capacity }} personas
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center bg-gradient-to-r from-red-50 to-pink-50 rounded-xl p-6 border border-red-100">
                                <div class="w-12 h-12 bg-gradient-to-br from-red-600 to-pink-600 rounded-xl flex items-center justify-center shadow-lg mr-4">
                                    <i class="fas fa-user text-white text-xl"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-600 font-medium">Organizador</div>
                                    <div class="text-lg font-semibold text-gray-900">{{ $event->user->name }}</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center bg-gradient-to-r from-teal-50 to-cyan-50 rounded-xl p-6 border border-teal-100">
                                <div class="w-12 h-12 bg-gradient-to-br from-teal-600 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg mr-4">
                                    <i class="fas fa-tag text-white text-xl"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-600 font-medium">Categoría</div>
                                    <div class="text-lg font-semibold text-gray-900">
                                        {{ \App\Models\Event::categories()[$event->category] ?? $event->category }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Purchase Section -->
                <div class="lg:col-span-1">
                    <div class="sticky top-8">
                        <div class="bg-white rounded-2xl p-6 shadow-xl border border-gray-100">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <div class="w-8 h-8 bg-gradient-to-br from-green-600 to-emerald-600 rounded-lg flex items-center justify-center shadow-lg mr-3">
                                    <i class="fas fa-shopping-cart text-white text-sm"></i>
                                </div>
                                Comprar Entradas
                            </h3>
                            
                            @if($event->isSoldOut())
                                <div class="text-center py-8">
                                    <div class="w-20 h-20 bg-gradient-to-br from-red-100 to-pink-100 rounded-full flex items-center justify-center mx-auto mb-4 border border-red-200">
                                        <i class="fas fa-times-circle text-red-500 text-3xl"></i>
                                    </div>
                                    <h4 class="text-lg font-semibold text-red-600 mb-2">Evento Agotado</h4>
                                    <p class="text-gray-600 text-sm">No hay entradas disponibles para este evento.</p>
                                </div>
                            @elseif($event->event_date->isPast())
                                <div class="text-center py-8">
                                    <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-200">
                                        <i class="fas fa-calendar-times text-gray-500 text-3xl"></i>
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-600 mb-2">Evento Finalizado</h4>
                                    <p class="text-gray-500 text-sm">Este evento ya ha terminado.</p>
                                </div>
                            @else
                                <div class="space-y-6">
                                    <div>
                                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-3">
                                            <i class="fas fa-ticket-alt mr-2 text-blue-600"></i>
                                            Cantidad de Entradas
                                        </label>
                                        <select name="quantity" id="quantity" 
                                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                            @for($i = 1; $i <= min(10, $event->available_capacity ?? 10); $i++)
                                                <option value="{{ $i }}">{{ $i }} {{ Str::plural('entrada', $i) }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl p-4 space-y-3 border border-gray-100">
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-600">Precio por entrada:</span>
                                            <span class="font-semibold text-gray-900">{{ $event->formatted_price }}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-600">Cantidad:</span>
                                            <span class="font-semibold text-gray-900" id="selected-quantity">1</span>
                                        </div>
                                        <hr class="border-gray-200">
                                        <div class="flex justify-between items-center">
                                            <span class="text-lg font-semibold text-gray-900">Total:</span>
                                            <span class="text-2xl font-bold text-green-600" id="total-price">
                                                S/. {{ number_format($event->price, 2) }}
                                            </span>
                                        </div>
                                    </div>

                                    <a href="{{ route('tickets.checkout.form', ['event' => $event, 'quantity' => 1]) }}" 
                                       id="checkout-link"
                                       class="w-full bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 hover:from-green-700 hover:via-emerald-700 hover:to-teal-700 text-white font-semibold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 text-center block">
                                        <i class="fas fa-credit-card mr-2"></i>
                                        Proceder al Pago
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantitySelect = document.getElementById('quantity');
            const selectedQuantity = document.getElementById('selected-quantity');
            const totalPrice = document.getElementById('total-price');
            const checkoutLink = document.getElementById('checkout-link');
            const pricePerTicket = {{ $event->price }};

            function updateTotal() {
                const quantity = parseInt(quantitySelect.value);
                const total = quantity * pricePerTicket;
                selectedQuantity.textContent = quantity;
                totalPrice.textContent = 'S/. ' + total.toFixed(2);
                
                // Actualizar el enlace de checkout con la cantidad seleccionada
                const baseUrl = "{{ route('tickets.checkout.form', ['event' => $event]) }}";
                checkoutLink.href = baseUrl + '?quantity=' + quantity;
            }

            quantitySelect.addEventListener('change', updateTotal);
            updateTotal();
        });
    </script>
</x-app-layout> 