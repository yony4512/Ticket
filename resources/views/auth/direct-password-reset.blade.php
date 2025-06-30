@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="mx-auto w-24 h-24 flex items-center justify-center mb-6">
                <img src="{{ asset('imagenes/iconoboleto.png') }}" alt="Icono" class="w-20 h-20">
            </div>
            <h2 class="text-3xl font-bold bg-gradient-to-r from-gray-900 via-purple-800 to-indigo-900 bg-clip-text text-transparent">
                Wasi Tickets
            </h2>
            <p class="mt-3 text-gray-600 text-lg">Restablece tu contraseña</p>
        </div>
        <div class="glass-effect rounded-2xl p-8 shadow-2xl border border-gray-200">
            @if(session('status'))
                <div class="mb-4 text-green-600 font-semibold text-center">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ isset($showPasswordFields) && $showPasswordFields ? route('direct-password-reset.update') : route('direct-password-reset.check') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2 text-indigo-600"></i>
                        Correo Electrónico
                    </label>
                    <input id="email" name="email" type="email" required autofocus autocomplete="email"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 placeholder-gray-400"
                           placeholder="tu@email.com"
                           value="{{ old('email', $email ?? '') }}" {{ isset($showPasswordFields) && $showPasswordFields ? 'readonly' : '' }}>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                @if(isset($showPasswordFields) && $showPasswordFields)
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-indigo-600"></i>
                            Nueva Contraseña
                        </label>
                        <input id="password" name="password" type="password" required autocomplete="new-password"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 placeholder-gray-400"
                               placeholder="••••••••">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-indigo-600"></i>
                            Confirmar Contraseña
                        </label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 placeholder-gray-400"
                               placeholder="••••••••">
                    </div>
                @endif
                <button type="submit"
                        class="w-full py-3 px-4 border border-transparent text-lg font-medium rounded-xl text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    @if(isset($showPasswordFields) && $showPasswordFields)
                        <i class="fas fa-key mr-2"></i> Cambiar contraseña
                    @else
                        <i class="fas fa-search mr-2"></i> Verificar correo
                    @endif
                </button>
            </form>
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 underline">
                <i class="fas fa-arrow-left mr-1"></i> Volver al inicio de sesión
            </a>
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