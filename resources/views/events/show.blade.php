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
        <div class="w-full px-0">
            <!-- Event Header -->
            <div class="glass-effect rounded-xl overflow-hidden shadow-lg border border-gray-200 mb-8">
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
                    <div class="relative h-64 lg:h-80 bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center">
                        <div class="text-center text-white">
                            <i class="fas fa-calendar text-6xl mb-4"></i>
                            <h1 class="text-3xl lg:text-4xl font-bold mb-3">{{ $event->title }}</h1>
                            <p class="text-xl">Organizado por {{ $event->user->name }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Main Content Grid -->
            <div class="w-full">
                <!-- Left Column - Event Details -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Status and Category -->
                    <div class="glass-effect rounded-xl p-8 shadow-lg border border-gray-200 w-full mb-8">
                        <div class="flex flex-wrap items-center gap-4">
                            @if($event->isSoldOut())
                                <span class="inline-flex items-center px-6 py-3 rounded-full text-base font-semibold bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-3 text-xl"></i>
                                    Agotado
                                </span>
                            @elseif($event->event_date->isPast())
                                <span class="inline-flex items-center px-6 py-3 rounded-full text-base font-semibold bg-gray-100 text-gray-800">
                                    <i class="fas fa-calendar-times mr-3 text-xl"></i>
                                    Evento Finalizado
                                </span>
                            @else
                                <span class="inline-flex items-center px-6 py-3 rounded-full text-base font-semibold bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-3 text-xl"></i>
                                    Disponible
                                </span>
                            @endif
                            <span class="inline-flex items-center px-6 py-3 rounded-full text-base font-semibold bg-blue-100 text-blue-800">
                                <i class="fas fa-tag mr-3 text-xl"></i>
                                {{ \App\Models\Event::categories()[$event->category] ?? $event->category }}
                            </span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="glass-effect rounded-xl p-8 shadow-lg border border-gray-200">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-align-left text-blue-600 mr-4 text-2xl"></i>
                            Descripción del Evento
                        </h2>
                        <div class="prose prose-lg max-w-none">
                            <p class="text-gray-700 leading-relaxed whitespace-pre-line text-lg">{{ $event->description }}</p>
                        </div>
                    </div>

                    <!-- Event Details -->
                    <div class="glass-effect rounded-xl p-8 shadow-lg border border-gray-200 w-full">
                        <h2 class="text-3xl font-bold text-gray-900 mb-10 flex items-center">
                            <i class="fas fa-info-circle text-blue-600 mr-4 text-2xl"></i>
                            Información del Evento
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
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
                                <div class="text-base text-gray-500 font-medium mb-1">Capacidad</div>
                                <div class="text-lg font-semibold text-gray-900 text-center">
                                    @if($event->available_capacity !== null)
                                        {{ $event->available_capacity }} de {{ $event->capacity }} disponibles
                                    @else
                                        {{ $event->capacity }} personas
                                    @endif
                                </div>
                            </div>
                            <div class="flex flex-col items-center bg-white rounded-xl shadow py-8 px-5 mb-6">
                                <span class="flex items-center justify-center w-12 h-12 rounded-xl bg-red-100 mb-4">
                                    <i class="fas fa-user text-red-600 text-2xl"></i>
                                </span>
                                <div class="text-base text-gray-500 font-medium mb-1">Organizador</div>
                                <div class="text-lg font-semibold text-gray-900 text-center">{{ $event->user->name }}</div>
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
                    </div>
                </div>

                <!-- Right Column - Purchase Section -->
                <div class="lg:col-span-1">
                    <div class="sticky top-8">
                        <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-shopping-cart text-green-600 mr-3"></i>
                                Comprar Entradas
                            </h3>
                            
                            @if($event->isSoldOut())
                                <div class="text-center py-8">
                                    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-times-circle text-red-500 text-3xl"></i>
                                    </div>
                                    <h4 class="text-lg font-semibold text-red-600 mb-2">Evento Agotado</h4>
                                    <p class="text-gray-600 text-sm">No hay entradas disponibles para este evento.</p>
                                </div>
                            @elseif($event->event_date->isPast())
                                <div class="text-center py-8">
                                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-calendar-times text-gray-500 text-3xl"></i>
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-600 mb-2">Evento Finalizado</h4>
                                    <p class="text-gray-500 text-sm">Este evento ya ha terminado.</p>
                                </div>
                            @else
                                <form action="{{ route('tickets.checkout', $event) }}" method="POST" class="space-y-6">
                                    @csrf
                                    
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

                                    <div class="bg-gray-50 rounded-xl p-4 space-y-3">
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
                                                {{ $event->formatted_price }}
                                            </span>
                                        </div>
                                    </div>

                                    <button type="submit" 
                                            class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                        <i class="fas fa-shopping-cart mr-3"></i>
                                        Continuar al Pago
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Calculate total price based on quantity
        document.getElementById('quantity').addEventListener('change', function() {
            const quantity = parseInt(this.value);
            const pricePerTicket = {{ $event->price }};
            const total = quantity * pricePerTicket;
            
            document.getElementById('selected-quantity').textContent = quantity;
            document.getElementById('total-price').textContent = 'S/. ' + total.toFixed(2);
        });
    </script>
</x-app-layout> 