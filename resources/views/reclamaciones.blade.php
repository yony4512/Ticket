<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Libro de Reclamaciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="glass-effect rounded-xl p-8 mb-8 shadow-lg border border-gray-200 text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-exclamation-triangle text-white text-3xl"></i>
                </div>
                <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Libro de Reclamaciones</h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Tu opinión es importante para nosotros. Si tienes alguna queja, sugerencia o reclamo, 
                    estamos aquí para escucharte y ayudarte a resolver cualquier inconveniente.
                </p>
            </div>

            <!-- Contact Information -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <div class="glass-effect rounded-xl p-8 shadow-lg border border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-info-circle text-blue-600 mr-3"></i>
                        Información de Contacto
                    </h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-building text-white text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">Empresa</h4>
                                <p class="text-gray-600">Sistema de Gestión de Eventos S.A.C.</p>
                                <p class="text-gray-600">RUC: 20123456789</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-map-marker-alt text-white text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">Dirección</h4>
                                <p class="text-gray-600">Av. Principal 123, Oficina 456</p>
                                <p class="text-gray-600">Lima, Perú</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-phone text-white text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">Teléfono</h4>
                                <p class="text-gray-600">+51 1 234-5678</p>
                                <p class="text-gray-600">Lun - Vie: 9:00 AM - 6:00 PM</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-envelope text-white text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">Email</h4>
                                <p class="text-gray-600">reclamaciones@eventos.com</p>
                                <p class="text-gray-600">soporte@eventos.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Complaint Form -->
                <div class="glass-effect rounded-xl p-8 shadow-lg border border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-edit text-green-600 mr-3"></i>
                        Formulario de Reclamación
                    </h3>
                    
                    <form method="POST" action="#" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user mr-2 text-blue-600"></i>
                                Nombre Completo *
                            </label>
                            <input type="text" id="name" name="name" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                   placeholder="Tu nombre completo">
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope mr-2 text-green-600"></i>
                                Email *
                            </label>
                            <input type="email" id="email" name="email" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                   placeholder="tu@email.com">
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-phone mr-2 text-purple-600"></i>
                                Teléfono
                            </label>
                            <input type="tel" id="phone" name="phone"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                   placeholder="+51 999 999 999">
                        </div>
                        
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-tag mr-2 text-orange-600"></i>
                                Tipo de Reclamación *
                            </label>
                            <select id="type" name="type" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <option value="">Selecciona el tipo</option>
                                <option value="service">Problema con el servicio</option>
                                <option value="payment">Problema con el pago</option>
                                <option value="ticket">Problema con la entrada</option>
                                <option value="event">Problema con el evento</option>
                                <option value="technical">Problema técnico</option>
                                <option value="other">Otro</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-heading mr-2 text-red-600"></i>
                                Asunto *
                            </label>
                            <input type="text" id="subject" name="subject" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                   placeholder="Resumen de tu reclamación">
                        </div>
                        
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-align-left mr-2 text-indigo-600"></i>
                                Descripción Detallada *
                            </label>
                            <textarea id="description" name="description" rows="6" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                      placeholder="Describe detalladamente tu reclamación, incluyendo fechas, números de ticket, etc."></textarea>
                        </div>
                        
                        <div>
                            <label for="expected_solution" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-lightbulb mr-2 text-yellow-600"></i>
                                Solución Esperada
                            </label>
                            <textarea id="expected_solution" name="expected_solution" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                      placeholder="¿Qué solución esperas de nosotros?"></textarea>
                        </div>
                        
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <i class="fas fa-paper-plane mr-3"></i>
                            Enviar Reclamación
                        </button>
                    </form>
                </div>
            </div>

            <!-- Response Time Information -->
            <div class="glass-effect rounded-xl p-8 shadow-lg border border-gray-200">
                <h3 class="text-2xl font-bold text-gray-900 mb-8 flex items-center justify-center">
                    <i class="fas fa-clock text-blue-600 mr-3"></i>
                    Tiempos de Respuesta
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="glass-effect rounded-xl p-8 text-center shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-bolt text-white text-3xl"></i>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-4">Respuesta Inmediata</h4>
                        <p class="text-gray-600 leading-relaxed">Confirmación de recepción en menos de 24 horas</p>
                        <div class="mt-4 text-sm text-blue-600 font-semibold">
                            <i class="fas fa-check-circle mr-2"></i>
                            Respuesta automática
                        </div>
                    </div>
                    
                    <div class="glass-effect rounded-xl p-8 text-center shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-search text-white text-3xl"></i>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-4">Revisión y Análisis</h4>
                        <p class="text-gray-600 leading-relaxed">Evaluación completa de tu reclamación en 2-3 días hábiles</p>
                        <div class="mt-4 text-sm text-green-600 font-semibold">
                            <i class="fas fa-clock mr-2"></i>
                            Análisis detallado
                        </div>
                    </div>
                    
                    <div class="glass-effect rounded-xl p-8 text-center shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-check-double text-white text-3xl"></i>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-4">Solución Final</h4>
                        <p class="text-gray-600 leading-relaxed">Resolución completa de tu caso en máximo 5 días hábiles</p>
                        <div class="mt-4 text-sm text-purple-600 font-semibold">
                            <i class="fas fa-star mr-2"></i>
                            Solución garantizada
                        </div>
                    </div>
                </div>
                
                <!-- Additional Information -->
                <div class="mt-12 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200">
                    <div class="flex items-center justify-center mb-4">
                        <i class="fas fa-info-circle text-blue-600 text-2xl mr-3"></i>
                        <h4 class="text-lg font-bold text-gray-900">Información Importante</h4>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-center">
                        <div class="flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-green-600 mr-3"></i>
                            <span class="text-gray-700">Horarios de atención: Lun - Vie 9:00 AM - 6:00 PM</span>
                        </div>
                        <div class="flex items-center justify-center">
                            <i class="fas fa-phone text-blue-600 mr-3"></i>
                            <span class="text-gray-700">Soporte telefónico: +51 1 234-5678</span>
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