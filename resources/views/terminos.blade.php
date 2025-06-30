<x-modal name="modal-terminos" :show="false" maxWidth="2xl">
    <div class="p-6">
        <div class="flex items-center mb-4">
            <img src="{{ asset('imagenes/iconoboleto.png') }}" alt="Icono" class="w-10 h-10 mr-3">
            <span class="text-2xl font-bold bg-gradient-to-r from-gray-900 via-purple-800 to-indigo-900 bg-clip-text text-transparent">Wasi Tickets</span>
        </div>
        <h2 class="text-xl font-bold mb-4 text-indigo-700">Términos y Condiciones</h2>
        <p class="mb-4">Esta aplicación es un sistema de prueba y demostración. No está destinada para uso en producción ni para la gestión real de eventos o ventas. El uso de este sistema es bajo su propio riesgo.</p>
        <ul class="list-disc pl-6 mb-4">
            <li>Los desarrolladores y responsables de este sistema no asumen ninguna responsabilidad por el uso, mal uso o consecuencias derivadas de la utilización de la plataforma.</li>
            <li>No se garantiza la disponibilidad, seguridad ni integridad de los datos ingresados.</li>
            <li>No se ofrece soporte ni garantía alguna sobre el funcionamiento del sistema.</li>
            <li>Este sistema es solo para fines educativos y de prueba.</li>
        </ul>
        <p>Si tienes dudas, contáctanos. Recomendamos no ingresar información sensible o real.</p>
        <button @click="$dispatch('close-modal', 'modal-terminos')" class="mt-6 px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded hover:from-indigo-700 hover:to-purple-700 flex items-center justify-center">
            <i class="fas fa-times mr-2"></i> Cerrar
        </button>
    </div>
</x-modal> 