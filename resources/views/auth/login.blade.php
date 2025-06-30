@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Logo y título -->
        <div class="text-center">
            <div class="mx-auto w-24 h-24 flex items-center justify-center mb-6">
                <img src="{{ asset('imagenes/iconoboleto.png') }}" alt="Icono" class="w-20 h-20">
            </div>
            <h2 class="text-4xl font-bold bg-gradient-to-r from-gray-900 via-purple-800 to-indigo-900 bg-clip-text text-transparent">
                Bienvenido
            </h2>
            <p class="mt-3 text-gray-600 text-lg">Inicia sesión en tu cuenta</p>
        </div>

        <!-- Formulario de login -->
        <div class="glass-effect rounded-2xl p-8 shadow-2xl border border-gray-200">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2 text-indigo-600"></i>
                        Correo Electrónico
                    </label>
                    <input id="email" name="email" type="email" required autofocus autocomplete="username"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 placeholder-gray-400"
                           placeholder="tu@email.com"
                           value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-indigo-600"></i>
                        Contraseña
                    </label>
                    <input id="password" name="password" type="password" required autocomplete="current-password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 placeholder-gray-400"
                           placeholder="••••••••">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" 
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                            Recordarme
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('direct-password-reset.form') }}" 
                           class="text-sm text-indigo-600 hover:text-indigo-800 transition-colors duration-200">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-lg font-medium rounded-xl text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-sign-in-alt text-indigo-300 group-hover:text-indigo-200 transition-colors duration-200"></i>
                        </span>
                        Iniciar Sesión
                    </button>
                </div>

                <!-- Divider -->
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">¿No tienes una cuenta?</span>
                    </div>
                </div>

                <!-- Register Link -->
                <div class="text-center">
                    <a href="{{ route('register') }}" 
                       class="inline-flex items-center px-6 py-3 border border-indigo-300 text-base font-medium rounded-xl text-indigo-700 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 shadow-md hover:shadow-lg">
                        <i class="fas fa-user-plus mr-2"></i>
                        Crear Cuenta
                    </a>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center">
            <p class="text-sm text-gray-500">
                Wasi Tickets
            </p>
        </div>
    </div>
</div>

<style>
    .glass-effect {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
</style>
@endsection
