<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sobre Nosotros') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="glass-effect rounded-xl p-8 mb-8 shadow-lg border border-gray-200 text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-info-circle text-white text-3xl"></i>
                </div>
                <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Sobre Wasi Tickets</h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    La plataforma líder en gestión de eventos que conecta organizadores con audiencias apasionadas
                </p>
            </div>

            <!-- Main Content -->
            <div class="glass-effect rounded-xl p-8 shadow-lg border border-gray-200 mb-8">
                <div class="prose max-w-none">
                    <p class="text-lg text-gray-700 mb-6 leading-relaxed">
                        Wasi Tickets es la plataforma líder en gestión de eventos que conecta a organizadores con su 
                        público objetivo de manera eficiente y efectiva. Nuestra misión es facilitar la creación, 
                        promoción y gestión de eventos de todo tipo, desde pequeños encuentros hasta grandes 
                        conferencias y conciertos.
                    </p>

                    <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-6 flex items-center">
                        <i class="fas fa-star text-yellow-500 mr-3"></i>
                        ¿Por qué elegirnos?
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200 text-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-mouse-pointer text-white text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Fácil de Usar</h3>
                            <p class="text-gray-600">
                                Nuestra plataforma está diseñada para ser intuitiva y fácil de usar, 
                                permitiéndote registrar y promocionar tus eventos en minutos.
                            </p>
                        </div>

                        <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200 text-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-users text-white text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Mayor Alcance</h3>
                            <p class="text-gray-600">
                                Llega a más personas interesadas en tu evento gracias a nuestra 
                                amplia base de usuarios y herramientas de promoción.
                            </p>
                        </div>

                        <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200 text-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-cogs text-white text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Gestión Completa</h3>
                            <p class="text-gray-600">
                                Administra todos tus eventos desde un solo lugar, con herramientas 
                                para seguimiento y actualización de la información.
                            </p>
                        </div>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-6 flex items-center">
                        <i class="fas fa-envelope text-blue-500 mr-3"></i>
                        Contáctanos
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-envelope text-white text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">Email</h4>
                                    <p class="text-gray-600">info@eventsystem.com</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-phone text-white text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">Teléfono</h4>
                                    <p class="text-gray-600">+51 1 234-5678</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-map-marker-alt text-white text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">Dirección</h4>
                                    <p class="text-gray-600">Av. Principal 123, Oficina 456</p>
                                    <p class="text-gray-600">Lima, Perú</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200">
                            <h4 class="font-bold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-clock text-orange-500 mr-2"></i>
                                Horarios de Atención
                            </h4>
                            <div class="space-y-2 text-gray-600">
                                <p><strong>Lunes - Viernes:</strong> 9:00 AM - 6:00 PM</p>
                                <p><strong>Sábados:</strong> 9:00 AM - 1:00 PM</p>
                                <p><strong>Domingos:</strong> Cerrado</p>
                            </div>
                            
                            <div class="mt-6">
                                <a href="{{ route('reclamaciones') }}" 
                                   class="inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                                    <i class="fas fa-book mr-2"></i>
                                    Libro de Reclamaciones
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
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
</style> 