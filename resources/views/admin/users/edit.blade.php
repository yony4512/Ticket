@extends('layouts.admin')

@section('title', 'Editar Usuario')
@section('subtitle')
    <div class="flex items-center text-blue-700 text-base font-semibold mb-2">
        <i class="fas fa-user-edit mr-2"></i>
        Modifica la información del usuario
    </div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Card -->
    <div class="glass-effect rounded-xl shadow-lg border border-gray-200">
        <div class="px-6 lg:px-8 py-4 lg:py-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3 lg:space-x-4">
                    <div class="w-10 h-10 lg:w-12 lg:h-12 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-700 rounded-xl flex items-center justify-center shadow-lg">
                        <img src="{{ asset('imagenes/iconoboleto.png') }}" alt="Icono" class="w-6 h-6 lg:w-8 lg:h-8">
                    </div>
                    <div>
                        <h3 class="text-xl lg:text-2xl font-bold text-gray-900">Editar Usuario</h3>
                        <p class="text-gray-600 text-sm lg:text-base">{{ $user->name }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center px-3 lg:px-4 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg lg:rounded-xl transition-all duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver
                </a>
            </div>
        </div>
        
        <div class="p-6 lg:p-8">
            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6 lg:space-y-8">
                @csrf
                @method('PATCH')
                
                <!-- Personal Information -->
                <div class="space-y-4 lg:space-y-6">
                    <div class="flex items-center space-x-2 lg:space-x-3 mb-4 lg:mb-6">
                        <div class="w-6 h-6 lg:w-8 lg:h-8 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-700 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user text-white text-xs lg:text-sm"></i>
                        </div>
                        <h4 class="text-lg lg:text-xl font-semibold text-gray-900">Información Personal</h4>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700">
                                Nombre Completo
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                                   class="w-full px-3 lg:px-4 py-2 lg:py-3 border border-gray-300 rounded-lg lg:rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                                   placeholder="Ingresa el nombre completo" required>
                            @error('name')
                                <p class="text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-semibold text-gray-700">
                                Email
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                                   class="w-full px-3 lg:px-4 py-2 lg:py-3 border border-gray-300 rounded-lg lg:rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                                   placeholder="Ingresa el email" required>
                            @error('email')
                                <p class="text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Account Settings -->
                <div class="space-y-4 lg:space-y-6">
                    <div class="flex items-center space-x-2 lg:space-x-3 mb-4 lg:mb-6">
                        <div class="w-6 h-6 lg:w-8 lg:h-8 bg-gradient-to-br from-green-600 via-green-700 to-emerald-700 rounded-lg flex items-center justify-center">
                            <i class="fas fa-cog text-white text-xs lg:text-sm"></i>
                        </div>
                        <h4 class="text-lg lg:text-xl font-semibold text-gray-900">Configuración de Cuenta</h4>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                        <div class="space-y-2">
                            <label for="role" class="block text-sm font-semibold text-gray-700">
                                Rol de Usuario
                            </label>
                            <select name="role" id="role" 
                                    class="w-full px-3 lg:px-4 py-2 lg:py-3 border border-gray-300 rounded-lg lg:rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <option value="user" {{ $user->hasRole('user') ? 'selected' : '' }}>Usuario</option>
                                <option value="admin" {{ $user->hasRole('admin') ? 'selected' : '' }}>Administrador</option>
                            </select>
                            @error('role')
                                <p class="text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <div class="space-y-2">
                            <label for="status" class="block text-sm font-semibold text-gray-700">
                                Estado de la Cuenta
                            </label>
                            <select name="status" id="status" 
                                    class="w-full px-3 lg:px-4 py-2 lg:py-3 border border-gray-300 rounded-lg lg:rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <option value="active" {{ ($user->status ?? 'active') === 'active' ? 'selected' : '' }}>Activo</option>
                                <option value="inactive" {{ ($user->status ?? 'active') === 'inactive' ? 'selected' : '' }}>Inactivo</option>
                                <option value="suspended" {{ ($user->status ?? 'active') === 'suspended' ? 'selected' : '' }}>Suspendido</option>
                            </select>
                            @error('status')
                                <p class="text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- User Statistics -->
                <div class="bg-gray-50 rounded-xl p-4 lg:p-6">
                    <div class="flex items-center space-x-2 lg:space-x-3 mb-3 lg:mb-4">
                        <div class="w-6 h-6 lg:w-8 lg:h-8 bg-gradient-to-br from-purple-600 via-purple-700 to-indigo-700 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chart-bar text-white text-xs lg:text-sm"></i>
                        </div>
                        <h4 class="text-lg lg:text-xl font-semibold text-gray-900">Estadísticas del Usuario</h4>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-6">
                        <div class="text-center p-3 lg:p-4 bg-white rounded-xl shadow-sm">
                            <div class="w-10 h-10 lg:w-12 lg:h-12 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-700 rounded-xl flex items-center justify-center mx-auto mb-2 lg:mb-3">
                                <i class="fas fa-ticket-alt text-white text-sm lg:text-lg"></i>
                            </div>
                            <p class="text-xl lg:text-2xl font-bold text-gray-900">{{ $user->tickets()->count() }}</p>
                            <p class="text-xs lg:text-sm text-gray-600">Tickets Comprados</p>
                        </div>
                        
                        <div class="text-center p-3 lg:p-4 bg-white rounded-xl shadow-sm">
                            <div class="w-10 h-10 lg:w-12 lg:h-12 bg-gradient-to-br from-green-600 via-green-700 to-emerald-700 rounded-xl flex items-center justify-center mx-auto mb-2 lg:mb-3">
                                <i class="fas fa-calendar-check text-white text-sm lg:text-lg"></i>
                            </div>
                            <p class="text-xl lg:text-2xl font-bold text-gray-900">{{ $user->tickets()->where('status', 'confirmed')->count() }}</p>
                            <p class="text-xs lg:text-sm text-gray-600">Eventos Asistidos</p>
                        </div>
                        
                        <div class="text-center p-3 lg:p-4 bg-white rounded-xl shadow-sm">
                            <div class="w-10 h-10 lg:w-12 lg:h-12 bg-gradient-to-br from-purple-600 via-purple-700 to-indigo-700 rounded-xl flex items-center justify-center mx-auto mb-2 lg:mb-3">
                                <i class="fas fa-clock text-white text-sm lg:text-lg"></i>
                            </div>
                            <p class="text-xl lg:text-2xl font-bold text-gray-900">{{ $user->created_at->diffForHumans() }}</p>
                            <p class="text-xs lg:text-sm text-gray-600">Miembro desde</p>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-4 lg:pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.users.index') }}" 
                       class="flex items-center justify-center px-4 lg:px-6 py-2 lg:py-3 border border-gray-300 rounded-lg lg:rounded-xl text-gray-700 hover:bg-gray-50 transition-all duration-200">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="flex items-center justify-center px-6 lg:px-8 py-2 lg:py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg lg:rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                        <i class="fas fa-save mr-2"></i>
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 