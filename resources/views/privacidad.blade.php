<x-modal name="modal-privacidad" :show="false" maxWidth="2xl">
    <div class="p-6">
        <div class="flex items-center mb-4">
            <img src="{{ asset('imagenes/iconoboleto.png') }}" alt="Icono" class="w-10 h-10 mr-3">
            <span class="text-2xl font-bold bg-gradient-to-r from-gray-900 via-purple-800 to-indigo-900 bg-clip-text text-transparent">Wasi Tickets</span>
        </div>
        <h2 class="text-xl font-bold mb-4 text-indigo-700">Política de Privacidad</h2>
        <p class="mb-4">Esta aplicación es un sistema de prueba y demostración. No está destinada para uso en producción ni para la gestión real de datos personales. El uso de este sistema es bajo su propio riesgo.</p>
        <ul class="list-disc pl-6 mb-4">
            <li>No se garantiza la protección, confidencialidad ni integridad de los datos ingresados.</li>
            <li>Los desarrolladores y responsables de este sistema no asumen ninguna responsabilidad por la gestión, pérdida o filtración de datos.</li>
            <li>Este sistema no almacena datos personales con fines comerciales ni de explotación.</li>
            <li>Recomendamos no ingresar información sensible o real.</li>
        </ul>
        <p>Si tienes dudas, contáctanos. El uso de esta plataforma es únicamente para fines educativos y de prueba.</p>
        <button @click="$dispatch('close-modal', 'modal-privacidad')" class="mt-6 px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded hover:from-indigo-700 hover:to-purple-700 flex items-center justify-center">
            <i class="fas fa-times mr-2"></i> Cerrar
        </button>
    </div>
</x-modal> 