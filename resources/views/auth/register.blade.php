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
                Crear Cuenta
            </h2>
            <p class="mt-3 text-gray-600 text-lg">Únete a nuestra plataforma de eventos</p>
        </div>

        <!-- Formulario de registro -->
        <div class="glass-effect rounded-2xl p-8 shadow-2xl border border-gray-200">
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user mr-2 text-indigo-600"></i>
                        Nombre Completo
                    </label>
                    <input id="name" name="name" type="text" required autofocus autocomplete="name"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 placeholder-gray-400"
                           placeholder="Tu nombre completo"
                           value="{{ old('name') }}">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2 text-indigo-600"></i>
                        Correo Electrónico
                    </label>
                    <input id="email" name="email" type="email" required autocomplete="username"
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

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-indigo-600"></i>
                        Confirmar Contraseña
                    </label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 placeholder-gray-400"
                           placeholder="••••••••">
                    @error('password_confirmation')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Terms -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" name="terms" type="checkbox" required
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="text-gray-700">
                            Acepto los 
                            <a href="#" onclick="abrirModal('modal-terminos'); return false;" class="text-indigo-600 hover:text-indigo-800 underline cursor-pointer">
                                términos y condiciones
                            </a>
                            y la 
                            <a href="#" onclick="abrirModal('modal-privacidad'); return false;" class="text-indigo-600 hover:text-indigo-800 underline cursor-pointer">
                                política de privacidad
                            </a>
                        </label>
                    </div>
                </div>

                <!-- Register Button -->
                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-lg font-medium rounded-xl text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-user-plus text-indigo-300 group-hover:text-indigo-200 transition-colors duration-200"></i>
                        </span>
                        Crear Cuenta
                    </button>
                </div>

                <!-- Divider -->
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">¿Ya tienes una cuenta?</span>
                    </div>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center px-6 py-3 border border-indigo-300 text-base font-medium rounded-xl text-indigo-700 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 shadow-md hover:shadow-lg">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Iniciar Sesión
                    </a>
                </div>
            </form>
        </div>

        <!-- Benefits -->
        <div class="glass-effect rounded-2xl p-6 shadow-xl border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 text-center">¿Por qué registrarte?</h3>
            <div class="space-y-3">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-check text-green-600 text-sm"></i>
                    </div>
                    <span class="text-sm text-gray-700">Acceso a eventos exclusivos</span>
                </div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-check text-green-600 text-sm"></i>
                    </div>
                    <span class="text-sm text-gray-700">Reserva de tickets fácil y rápida</span>
                </div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-check text-green-600 text-sm"></i>
                    </div>
                    <span class="text-sm text-gray-700">Historial de compras</span>
                </div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-check text-green-600 text-sm"></i>
                    </div>
                    <span class="text-sm text-gray-700">Notificaciones personalizadas</span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center">
            <p class="text-sm text-gray-500">
                Wasi Tickets
            </p>
        </div>
    </div>
</div>

<!-- Modales personalizados -->
<div id="modal-terminos" class="custom-modal" style="display:none;">
    <div class="custom-modal-content">
        <div class="modal-header-wasi">
            <img src="{{ asset('imagenes/iconoboleto.png') }}" alt="Icono" class="modal-logo">
            <span class="modal-title">Wasi Tickets</span>
            <span class="close" onclick="cerrarModal('modal-terminos')">&times;</span>
        </div>
        <h2 class="modal-section-title">Términos y Condiciones</h2>
        <p>Bienvenido a <b>Wasi Tickets</b>. Al utilizar nuestra plataforma, aceptas los siguientes términos y condiciones. Por favor, léelos detenidamente antes de continuar con el registro y uso de nuestros servicios.</p>
        <ul>
            <li><b>Uso del sistema:</b> Esta aplicación es un sistema de prueba y demostración. No está destinada para uso en producción ni para la gestión real de eventos o ventas. El uso de este sistema es bajo tu propio riesgo.</li>
            <li><b>Responsabilidad:</b> Los desarrolladores y responsables de este sistema no asumen ninguna responsabilidad por el uso, mal uso o consecuencias derivadas de la utilización de la plataforma.</li>
            <li><b>Disponibilidad y seguridad:</b> No se garantiza la disponibilidad, seguridad ni integridad de los datos ingresados. El sistema puede estar sujeto a interrupciones, errores o pérdida de información.</li>
            <li><b>Soporte:</b> No se ofrece soporte ni garantía alguna sobre el funcionamiento del sistema. Cualquier inconveniente debe ser reportado solo con fines educativos.</li>
            <li><b>Propiedad intelectual:</b> Todos los derechos sobre el diseño, logotipo, nombre y contenido de <b>Wasi Tickets</b> pertenecen a sus respectivos creadores. El uso de la marca está limitado a fines de prueba y demostración.</li>
            <li><b>Prohibiciones:</b> Está prohibido el uso de la plataforma para actividades ilícitas, comerciales o que vulneren derechos de terceros.</li>
            <li><b>Actualizaciones:</b> Los términos y condiciones pueden ser modificados en cualquier momento sin previo aviso. Es responsabilidad del usuario revisarlos periódicamente.</li>
            <li><b>Duración:</b> El acceso a la plataforma puede ser revocado en cualquier momento por los administradores sin justificación.</li>
        </ul>
        <p>Si tienes dudas, contáctanos. Recomendamos no ingresar información sensible o real. El uso de esta plataforma es únicamente para fines educativos y de prueba.</p>
        <p style="margin-top:18px; color:#7c3aed; font-size:0.98rem;">Gracias por confiar en <b>Wasi Tickets</b>. ¡Disfruta explorando y aprendiendo con nuestra plataforma!</p>
    </div>
</div>
<div id="modal-privacidad" class="custom-modal" style="display:none;">
    <div class="custom-modal-content">
        <div class="modal-header-wasi">
            <img src="{{ asset('imagenes/iconoboleto.png') }}" alt="Icono" class="modal-logo">
            <span class="modal-title">Wasi Tickets</span>
            <span class="close" onclick="cerrarModal('modal-privacidad')">&times;</span>
        </div>
        <h2 class="modal-section-title">Política de Privacidad</h2>
        <p>En <b>Wasi Tickets</b> nos tomamos la privacidad en serio. A continuación, te explicamos cómo se maneja la información en nuestra plataforma de prueba.</p>
        <ul>
            <li><b>Datos personales:</b> Este sistema es solo para fines educativos y de prueba. No está destinado para la gestión real de datos personales ni para su uso en producción.</li>
            <li><b>Protección de datos:</b> No se garantiza la protección, confidencialidad ni integridad de los datos ingresados. Los datos pueden ser visibles para otros usuarios o administradores del sistema.</li>
            <li><b>Responsabilidad:</b> Los desarrolladores y responsables de este sistema no asumen ninguna responsabilidad por la gestión, pérdida o filtración de datos.</li>
            <li><b>Almacenamiento:</b> Este sistema no almacena datos personales con fines comerciales ni de explotación. Toda la información ingresada puede ser eliminada sin previo aviso.</li>
            <li><b>Recomendación:</b> Se recomienda no ingresar información sensible, real o confidencial. Usa datos ficticios para pruebas y demostraciones.</li>
            <li><b>Cookies y seguimiento:</b> La plataforma puede utilizar cookies técnicas para mejorar la experiencia de usuario, pero no realiza seguimiento ni análisis de datos personales.</li>
            <li><b>Acceso de terceros:</b> No compartimos información con terceros. Sin embargo, al ser un entorno de prueba, otros usuarios pueden visualizar los datos ingresados.</li>
            <li><b>Actualizaciones:</b> La política de privacidad puede ser modificada en cualquier momento sin previo aviso. Es responsabilidad del usuario revisarla periódicamente.</li>
        </ul>
        <p>Si tienes dudas, contáctanos. El uso de esta plataforma es únicamente para fines educativos y de prueba.</p>
        <p style="margin-top:18px; color:#7c3aed; font-size:0.98rem;">Gracias por confiar en <b>Wasi Tickets</b>. Tu privacidad es importante, incluso en un entorno de aprendizaje.</p>
    </div>
</div>

<style>
    .glass-effect {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .custom-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0; top: 0; width: 100%; height: 100%;
        overflow: auto;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        background-color: rgba(0,0,0,0.4);
    }
    .custom-modal-content {
        background: #fff;
        margin: 5% auto;
        padding: 32px 24px 24px 24px;
        border: 1px solid #e0e7ff;
        width: 95%; max-width: 480px;
        border-radius: 18px;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        position: relative;
        font-family: 'Montserrat', 'Figtree', sans-serif;
        color: #312e81;
        animation: modalFadeIn 0.3s;
    }
    @keyframes modalFadeIn {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .modal-header-wasi {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 12px;
        margin-bottom: 12px;
        border-bottom: 1px solid #e0e7ff;
        padding-bottom: 8px;
    }
    .modal-logo {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(99,102,241,0.10);
        background: #fff;
    }
    .modal-title {
        font-size: 1.3rem;
        font-weight: bold;
        background: linear-gradient(90deg, #312e81 0%, #7c3aed 50%, #6366f1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-fill-color: transparent;
        letter-spacing: 1px;
    }
    .modal-section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #4f46e5;
        margin-top: 10px;
        margin-bottom: 10px;
    }
    .close {
        color: #6366f1;
        position: absolute;
        right: 18px;
        top: 12px;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        transition: color 0.2s;
    }
    .close:hover, .close:focus {
        color: #a21caf;
        text-decoration: none;
        cursor: pointer;
    }
    .custom-modal-content ul {
        margin: 12px 0 12px 18px;
        padding-left: 18px;
        color: #312e81;
        font-size: 0.98rem;
    }
    .custom-modal-content ul li {
        margin-bottom: 6px;
        list-style: disc;
    }
    .custom-modal-content p {
        margin-bottom: 10px;
        font-size: 1rem;
    }
</style>
<script>
function abrirModal(id) {
    document.getElementById(id).style.display = 'block';
}
function cerrarModal(id) {
    document.getElementById(id).style.display = 'none';
}
window.onclick = function(event) {
    document.querySelectorAll('.custom-modal').forEach(function(modal) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    });
}
</script>

<div x-data="{open:false}">
    <button @click="open = !open">Test Alpine</button>
    <span x-show="open">¡Alpine funciona!</span>
</div>
@endsection
