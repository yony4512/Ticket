@extends('layouts.admin')

@section('title', 'Configuración del Sistema')
@section('subtitle')
    <div class="flex items-center text-blue-700 text-base font-semibold mb-2">
        <i class="fas fa-cogs mr-2"></i>
        Gestiona la configuración general del sistema
    </div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="text-center lg:text-left">
        <h1 class="text-3xl font-bold bg-gradient-to-r from-slate-900 via-blue-800 to-indigo-800 bg-clip-text text-transparent">
            Configuración del Sistema
        </h1>
        <p class="text-gray-600 mt-2">Gestiona la configuración general del sistema</p>
    </div>

    <!-- Settings Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- General Settings -->
        <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-700 rounded-xl flex items-center justify-center shadow-lg mr-4">
                    <i class="fas fa-cog text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Configuración General</h2>
                    <p class="text-gray-600">Ajustes básicos del sistema</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="site_name" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-globe mr-2 text-blue-600"></i>
                        Nombre del Sitio
                    </label>
                    <input type="text" name="site_name" id="site_name" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Wasi Tickets"
                           value="{{ old('site_name', 'Wasi Tickets') }}">
                </div>

                <div>
                    <label for="site_description" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                        Descripción del Sitio
                    </label>
                    <textarea name="site_description" id="site_description" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Descripción del sistema...">{{ old('site_description', 'Plataforma de venta de tickets para eventos') }}</textarea>
                </div>

                <div>
                    <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2 text-blue-600"></i>
                        Email de Contacto
                    </label>
                    <input type="email" name="contact_email" id="contact_email" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="contacto@ejemplo.com"
                           value="{{ old('contact_email', 'admin@example.com') }}">
                </div>

                <div class="flex items-center justify-between pt-4">
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-300">
                        <i class="fas fa-save mr-2"></i>
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>

        <!-- Email Settings -->
        <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-green-600 via-green-700 to-emerald-700 rounded-xl flex items-center justify-center shadow-lg mr-4">
                    <i class="fas fa-envelope text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Configuración de Email</h2>
                    <p class="text-gray-600">Configuración de notificaciones</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.settings.email') }}" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="smtp_host" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-server mr-2 text-green-600"></i>
                        Servidor SMTP
                    </label>
                    <input type="text" name="smtp_host" id="smtp_host" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                           placeholder="smtp.gmail.com"
                           value="{{ old('smtp_host', 'smtp.gmail.com') }}">
                </div>

                <div>
                    <label for="smtp_port" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-network-wired mr-2 text-green-600"></i>
                        Puerto SMTP
                    </label>
                    <input type="number" name="smtp_port" id="smtp_port" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                           placeholder="587"
                           value="{{ old('smtp_port', '587') }}">
                </div>

                <div>
                    <label for="smtp_username" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user mr-2 text-green-600"></i>
                        Usuario SMTP
                    </label>
                    <input type="text" name="smtp_username" id="smtp_username" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                           placeholder="tu-email@gmail.com"
                           value="{{ old('smtp_username') }}">
                </div>

                <div>
                    <label for="smtp_password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-green-600"></i>
                        Contraseña SMTP
                    </label>
                    <input type="password" name="smtp_password" id="smtp_password" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                           placeholder="Tu contraseña de aplicación">
                </div>

                <div class="flex items-center justify-between pt-4">
                    <button type="submit" 
                            class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-300">
                        <i class="fas fa-save mr-2"></i>
                        Guardar Configuración
                    </button>
                </div>
            </form>
        </div>

        <!-- Security Settings -->
        <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-red-600 via-red-700 to-pink-700 rounded-xl flex items-center justify-center shadow-lg mr-4">
                    <i class="fas fa-shield-alt text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Configuración de Seguridad</h2>
                    <p class="text-gray-600">Ajustes de seguridad del sistema</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <h3 class="font-medium text-gray-900">Autenticación de Dos Factores</h3>
                        <p class="text-sm text-gray-600">Requerir 2FA para usuarios admin</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <h3 class="font-medium text-gray-900">Registro de Actividad</h3>
                        <p class="text-sm text-gray-600">Registrar todas las acciones de admin</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <h3 class="font-medium text-gray-900">Límite de Intentos de Login</h3>
                        <p class="text-sm text-gray-600">Bloquear después de 5 intentos fallidos</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </div>
        </div>

        <!-- System Info -->
        <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-600 via-purple-700 to-pink-700 rounded-xl flex items-center justify-center shadow-lg mr-4">
                    <i class="fas fa-info-circle text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Información del Sistema</h2>
                    <p class="text-gray-600">Detalles técnicos del sistema</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <span class="text-sm font-medium text-gray-700">Versión de Laravel</span>
                    <span class="text-sm text-gray-900">{{ app()->version() }}</span>
                </div>

                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <span class="text-sm font-medium text-gray-700">Versión de PHP</span>
                    <span class="text-sm text-gray-900">{{ phpversion() }}</span>
                </div>

                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <span class="text-sm font-medium text-gray-700">Base de Datos</span>
                    <span class="text-sm text-gray-900">MySQL</span>
                </div>

                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <span class="text-sm font-medium text-gray-700">Tiempo de Uptime</span>
                    <span class="text-sm text-gray-900">24 días</span>
                </div>

                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <span class="text-sm font-medium text-gray-700">Última Actualización</span>
                    <span class="text-sm text-gray-900">{{ now()->format('d/m/Y H:i') }}</span>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-gray-200">
                <button class="w-full px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-300">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Verificar Actualizaciones
                </button>
            </div>
        </div>
    </div>

    <!-- Backup Section -->
    <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200">
        <div class="flex items-center mb-6">
            <div class="w-12 h-12 bg-gradient-to-br from-yellow-600 via-yellow-700 to-orange-700 rounded-xl flex items-center justify-center shadow-lg mr-4">
                <i class="fas fa-database text-white text-xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900">Respaldo del Sistema</h2>
                <p class="text-gray-600">Gestiona los respaldos de la base de datos</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <i class="fas fa-download text-blue-600 text-2xl mb-2"></i>
                <h3 class="font-medium text-gray-900">Crear Respaldo</h3>
                <p class="text-sm text-gray-600 mb-3">Generar un nuevo respaldo completo</p>
                <form method="POST" action="{{ route('admin.backup.create') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg hover:shadow-lg transition-all duration-300">
                        Crear Ahora
                    </button>
                </form>
            </div>

            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <i class="fas fa-upload text-green-600 text-2xl mb-2"></i>
                <h3 class="font-medium text-gray-900">Restaurar</h3>
                <p class="text-sm text-gray-600 mb-3">Restaurar desde un respaldo</p>
                <form method="POST" action="{{ route('admin.backup.restore') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="backup_file" class="mb-2 block w-full text-sm text-gray-600" required>
                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg hover:shadow-lg transition-all duration-300">
                        Restaurar
                    </button>
                </form>
            </div>

            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <i class="fas fa-history text-purple-600 text-2xl mb-2"></i>
                <h3 class="font-medium text-gray-900">Historial</h3>
                <p class="text-sm text-gray-600 mb-3">Ver respaldos anteriores</p>
                <a href="{{ route('admin.backup.history') }}" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg hover:shadow-lg transition-all duration-300 inline-block">
                    Ver Historial
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 