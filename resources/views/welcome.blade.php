<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inicio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Hero Section with Background -->
            <div class="relative overflow-hidden rounded-2xl mb-16">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-800"></div>
                <div class="absolute inset-0 bg-black opacity-20"></div>
                <div class="relative px-8 py-16 lg:py-24 text-center">
                    <h1 class="text-4xl lg:text-7xl font-bold text-white mb-6 leading-tight">
                        La Plataforma de Eventos
                        <span class="block text-yellow-300">Más Confiable</span>
                    </h1>
                    <p class="text-xl lg:text-2xl text-white/90 mb-8 max-w-4xl mx-auto leading-relaxed">
                        Conectamos organizadores con audiencias apasionadas. Crea, descubre y disfruta de experiencias únicas con la máxima seguridad y profesionalismo.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-6 justify-center mb-8">
                        <a href="{{ route('events.index') }}" 
                           class="group inline-flex items-center px-8 py-4 bg-white text-blue-600 font-bold rounded-xl shadow-2xl hover:shadow-3xl transform hover:-translate-y-2 transition-all duration-300">
                            <i class="fas fa-rocket mr-3 text-xl group-hover:rotate-12 transition-transform"></i>
                            Explorar Eventos
                        </a>
                        @auth
                            <a href="{{ route('events.create') }}" 
                               class="group inline-flex items-center px-8 py-4 bg-yellow-400 text-gray-900 font-bold rounded-xl shadow-2xl hover:shadow-3xl transform hover:-translate-y-2 transition-all duration-300">
                                <i class="fas fa-plus mr-3 text-xl group-hover:scale-110 transition-transform"></i>
                                Crear Evento
                            </a>
                        @else
                            <a href="{{ route('register') }}" 
                               class="group inline-flex items-center px-8 py-4 bg-green-500 text-white font-bold rounded-xl shadow-2xl hover:shadow-3xl transform hover:-translate-y-2 transition-all duration-300">
                                <i class="fas fa-user-plus mr-3 text-xl group-hover:scale-110 transition-transform"></i>
                                Unirse Ahora
                            </a>
                        @endauth
                    </div>
                    
                    <!-- Botón Sobre Nosotros -->
                    <div class="flex justify-center">
                        <a href="{{ route('about') }}" 
                           class="group inline-flex items-center px-6 py-3 bg-transparent border-2 border-white/30 text-white font-semibold rounded-xl hover:bg-white/10 hover:border-white/50 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-info-circle mr-2 group-hover:rotate-12 transition-transform"></i>
                            Sobre Nosotros
                        </a>
                    </div>
                </div>
            </div>

            <!-- Featured Events Carousel -->
            <div class="mb-16">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Eventos Destacados</h2>
                    <p class="text-xl text-gray-600">Los eventos más populares del momento</p>
                </div>
                
                <div class="relative">
                    <!-- Carousel Container -->
                    <div class="overflow-hidden rounded-2xl shadow-2xl">
                        <div class="flex transition-transform duration-500 ease-in-out" id="eventCarousel">
                            @foreach($events ?? [] as $index => $event)
                                <div class="w-full flex-shrink-0">
                                    <div class="relative h-96 lg:h-[500px]">
                                        @if($event->image_path)
                                            <img src="{{ $event->image_url }}" alt="{{ $event->title }}" 
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-blue-400 via-purple-500 to-indigo-600 flex items-center justify-center">
                                                <i class="fas fa-calendar text-white text-6xl"></i>
                                            </div>
                                        @endif
                                        
                                        <!-- Overlay with event info -->
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                                        <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                                            <div class="max-w-4xl mx-auto">
                                                <div class="flex items-center mb-4">
                                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-blue-500/90 text-white mr-4">
                                                        <i class="fas fa-tag mr-2"></i>
                                                        {{ \App\Models\Event::categories()[$event->category] ?? $event->category }}
                                                    </span>
                                                    <span class="text-2xl font-bold text-yellow-300">{{ $event->formatted_price }}</span>
                                                </div>
                                                
                                                <h3 class="text-3xl lg:text-4xl font-bold mb-4">{{ $event->title }}</h3>
                                                <p class="text-lg text-gray-200 mb-6 max-w-2xl">{{ Str::limit($event->description, 150) }}</p>
                                                
                                                <div class="flex items-center space-x-6 mb-6">
                                                    <div class="flex items-center">
                                                        <i class="fas fa-map-marker-alt mr-2 text-red-400"></i>
                                                        <span>{{ $event->location }}</span>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <i class="fas fa-calendar mr-2 text-blue-400"></i>
                                                        <span>{{ $event->formatted_date }}</span>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <i class="fas fa-user mr-2 text-green-400"></i>
                                                        <span>{{ $event->user->name }}</span>
                                                    </div>
                                                </div>
                                                
                                                <a href="{{ route('events.show', $event) }}" 
                                                   class="inline-flex items-center px-8 py-4 bg-white text-gray-900 font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                                    <i class="fas fa-ticket-alt mr-3"></i>
                                                    Ver Detalles
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Carousel Navigation -->
                    @if(count($events ?? []) > 1)
                        <button class="absolute left-4 top-1/2 transform -translate-y-1/2 w-12 h-12 bg-white/90 hover:bg-white text-gray-800 rounded-full shadow-lg flex items-center justify-center transition-all duration-300 hover:scale-110" 
                                onclick="changeSlide(-1)">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        
                        <button class="absolute right-4 top-1/2 transform -translate-y-1/2 w-12 h-12 bg-white/90 hover:bg-white text-gray-800 rounded-full shadow-lg flex items-center justify-center transition-all duration-300 hover:scale-110" 
                                onclick="changeSlide(1)">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        
                        <!-- Carousel Indicators -->
                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                            @foreach($events ?? [] as $index => $event)
                                <button class="w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-all duration-300" 
                                        onclick="goToSlide({{ $index }})" 
                                        id="indicator-{{ $index }}"></button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Statistics Section -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-16">
                <div class="glass-effect rounded-xl p-6 text-center shadow-lg border border-gray-200">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-gray-900 mb-2">{{ $totalUsers ?? '1,500+' }}</div>
                    <div class="text-sm text-gray-600">Usuarios Activos</div>
                </div>
                
                <div class="glass-effect rounded-xl p-6 text-center shadow-lg border border-gray-200">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calendar-check text-white text-xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-gray-900 mb-2">{{ $totalEvents ?? '200+' }}</div>
                    <div class="text-sm text-gray-600">Eventos Creados</div>
                </div>
                
                <div class="glass-effect rounded-xl p-6 text-center shadow-lg border border-gray-200">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-ticket-alt text-white text-xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-gray-900 mb-2">{{ $totalTickets ?? '5,000+' }}</div>
                    <div class="text-sm text-gray-600">Entradas Vendidas</div>
                </div>
                
                <div class="glass-effect rounded-xl p-6 text-center shadow-lg border border-gray-200">
                    <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-star text-white text-xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-gray-900 mb-2">4.9</div>
                    <div class="text-sm text-gray-600">Calificación</div>
                </div>
            </div>

            <!-- Features Section -->
            <div class="mb-16">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">¿Por qué elegirnos?</h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Ofrecemos las herramientas más avanzadas para crear y gestionar eventos exitosos
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="glass-effect rounded-xl p-8 text-center shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-shield-alt text-white text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Seguridad Garantizada</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Transacciones seguras con encriptación SSL de 256 bits. Tus datos y pagos están completamente protegidos.
                        </p>
                    </div>

                    <div class="glass-effect rounded-xl p-8 text-center shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-mobile-alt text-white text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">100% Responsivo</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Accede desde cualquier dispositivo. Nuestra plataforma se adapta perfectamente a móviles, tablets y computadoras.
                        </p>
                    </div>

                    <div class="glass-effect rounded-xl p-8 text-center shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-headset text-white text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Soporte 24/7</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Nuestro equipo está disponible para ayudarte en cualquier momento. Resolvemos tus dudas rápidamente.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Testimonials Section -->
            <div class="mb-16">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Lo que dicen nuestros usuarios</h2>
                    <p class="text-xl text-gray-600">Experiencias reales de organizadores y asistentes</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="glass-effect rounded-xl p-8 shadow-lg border border-gray-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mr-4">
                                <span class="text-white font-bold text-lg">M</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">María González</h4>
                                <p class="text-sm text-gray-600">Organizadora de Eventos</p>
                            </div>
                        </div>
                        <p class="text-gray-600 italic mb-4">
                            "La plataforma me ha permitido organizar eventos profesionales de manera sencilla. El sistema de pagos es muy confiable."
                        </p>
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>

                    <div class="glass-effect rounded-xl p-8 shadow-lg border border-gray-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center mr-4">
                                <span class="text-white font-bold text-lg">C</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Carlos Rodríguez</h4>
                                <p class="text-sm text-gray-600">Asistente Frecuente</p>
                            </div>
                        </div>
                        <p class="text-gray-600 italic mb-4">
                            "Comprar entradas es súper fácil y rápido. Siempre recibo confirmaciones inmediatas y el proceso es muy seguro."
                        </p>
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>

                    <div class="glass-effect rounded-xl p-8 shadow-lg border border-gray-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center mr-4">
                                <span class="text-white font-bold text-lg">A</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Ana Martínez</h4>
                                <p class="text-sm text-gray-600">Empresaria</p>
                            </div>
                        </div>
                        <p class="text-gray-600 italic mb-4">
                            "Excelente para eventos corporativos. La gestión de asistentes y reportes me ha facilitado mucho el trabajo."
                        </p>
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Events Preview -->
            <div class="mb-16">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900">Eventos Destacados</h2>
                        <p class="text-gray-600 mt-2">Descubre los eventos más populares del momento</p>
                    </div>
                    <a href="{{ route('events.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                        Ver todos <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($events ?? [] as $event)
                        <div class="glass-effect rounded-xl overflow-hidden shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                            @if($event->image_path)
                                <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center">
                                    <i class="fas fa-calendar text-white text-4xl"></i>
                                </div>
                            @endif
                            
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                        {{ \App\Models\Event::categories()[$event->category] ?? $event->category }}
                                    </span>
                                    <span class="text-lg font-bold text-green-600">{{ $event->formatted_price }}</span>
                                </div>
                                
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $event->title }}</h3>
                                <p class="text-gray-600 mb-4 line-clamp-2">{{ Str::limit($event->description, 100) }}</p>
                                
                                <div class="flex items-center text-sm text-gray-500 mb-4">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    <span>{{ $event->location }}</span>
                                </div>
                                
                                <div class="flex items-center text-sm text-gray-500 mb-4">
                                    <i class="fas fa-calendar mr-2"></i>
                                    <span>{{ $event->formatted_date }}</span>
                                </div>
                                
                                <a href="{{ route('events.show', $event) }}" 
                                   class="block w-full text-center bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-300">
                                    Ver Detalles
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- CTA Section -->
            <div class="glass-effect rounded-2xl p-12 lg:p-16 text-center shadow-2xl border border-gray-200 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-indigo-50"></div>
                <div class="relative">
                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">¿Listo para crear tu próximo evento?</h2>
                    <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                        Únete a miles de organizadores que confían en nuestra plataforma para crear experiencias inolvidables
                    </p>
                    @auth
                        <a href="{{ route('events.create') }}" 
                           class="group inline-flex items-center px-10 py-5 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold text-lg rounded-xl shadow-2xl hover:shadow-3xl transform hover:-translate-y-2 transition-all duration-300">
                            <i class="fas fa-rocket mr-3 text-xl group-hover:rotate-12 transition-transform"></i>
                            Crear mi primer evento
                        </a>
                    @else
                        <div class="flex flex-col sm:flex-row gap-6 justify-center">
                            <a href="{{ route('register') }}" 
                               class="group inline-flex items-center px-10 py-5 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold text-lg rounded-xl shadow-2xl hover:shadow-3xl transform hover:-translate-y-2 transition-all duration-300">
                                <i class="fas fa-user-plus mr-3 text-xl group-hover:scale-110 transition-transform"></i>
                                Registrarse Gratis
                            </a>
                            <a href="{{ route('login') }}" 
                               class="group inline-flex items-center px-10 py-5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-lg rounded-xl shadow-2xl hover:shadow-3xl transform hover:-translate-y-2 transition-all duration-300">
                                <i class="fas fa-sign-in-alt mr-3 text-xl group-hover:scale-110 transition-transform"></i>
                                Iniciar Sesión
                            </a>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Libro de Reclamaciones -->
            <div class="text-center mt-12 mb-8">
                <a href="{{ route('reclamaciones') }}" 
                   class="group inline-flex items-center px-6 py-4 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <i class="fas fa-book mr-3 text-xl text-red-500 group-hover:scale-110 transition-transform"></i>
                    <span class="mr-2">Libro de Reclamaciones</span>
                    <i class="fas fa-external-link-alt text-sm opacity-70 group-hover:opacity-100 transition-opacity"></i>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .glass-effect {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .shadow-3xl {
        box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
    }
</style>

<script>
    // Carousel functionality
    let currentSlide = 0;
    const slides = document.querySelectorAll('#eventCarousel > div');
    const totalSlides = slides.length;
    
    function updateCarousel() {
        const carousel = document.getElementById('eventCarousel');
        if (carousel) {
            carousel.style.transform = `translateX(-${currentSlide * 100}%)`;
        }
        
        // Update indicators
        document.querySelectorAll('[id^="indicator-"]').forEach((indicator, index) => {
            if (index === currentSlide) {
                indicator.classList.add('bg-white');
                indicator.classList.remove('bg-white/50');
            } else {
                indicator.classList.remove('bg-white');
                indicator.classList.add('bg-white/50');
            }
        });
    }
    
    function changeSlide(direction) {
        currentSlide = (currentSlide + direction + totalSlides) % totalSlides;
        updateCarousel();
    }
    
    function goToSlide(slideIndex) {
        currentSlide = slideIndex;
        updateCarousel();
    }
    
    // Auto-play carousel
    if (totalSlides > 1) {
        setInterval(() => {
            changeSlide(1);
        }, 5000); // Change slide every 5 seconds
    }
    
    // Initialize carousel
    document.addEventListener('DOMContentLoaded', function() {
        updateCarousel();
    });
</script> 