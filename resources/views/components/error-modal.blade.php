@props(['errors' => null])

@if($errors && $errors->any())
<div id="errorModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm flex items-center justify-center z-50" 
     x-data="{ open: true }" 
     x-show="open" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95">
    
    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full mx-4 transform transition-all border border-gray-100">
        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-100 bg-gradient-to-r from-red-600 via-orange-600 to-red-700 rounded-t-2xl">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center shadow-lg backdrop-blur-sm">
                    <i class="fas fa-exclamation-triangle text-white text-lg"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">Error de Validación</h3>
                    <p class="text-sm text-red-100">Revisa los campos marcados</p>
                </div>
            </div>
            <button @click="open = false" 
                    class="w-8 h-8 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg flex items-center justify-center transition-colors backdrop-blur-sm">
                <i class="fas fa-times text-white"></i>
            </button>
        </div>

        <!-- Content -->
        <div class="p-6">
            <div class="bg-gradient-to-r from-red-50 to-orange-50 border border-red-200 rounded-xl p-4 mb-4">
                <div class="flex items-start space-x-3">
                    <i class="fas fa-info-circle text-red-600 mt-0.5"></i>
                    <p class="text-sm text-red-800 font-medium">Por favor, corrige los siguientes errores antes de continuar:</p>
                </div>
            </div>
            
            <div class="space-y-3 max-h-64 overflow-y-auto">
                @foreach($errors->all() as $error)
                    <div class="flex items-start space-x-3 p-3 bg-gradient-to-r from-red-50 to-orange-50 border border-red-100 rounded-lg">
                        <div class="w-2 h-2 bg-gradient-to-r from-red-500 to-orange-500 rounded-full mt-2 flex-shrink-0"></div>
                        <p class="text-sm text-red-800 leading-relaxed">{{ __($error) }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Footer -->
        <div class="flex justify-end p-6 border-t border-gray-100 bg-gradient-to-r from-gray-50 to-red-50 rounded-b-2xl">
            <button @click="open = false" 
                    class="px-6 py-3 bg-gradient-to-r from-red-600 via-orange-600 to-red-700 hover:from-red-700 hover:via-orange-700 hover:to-red-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-check mr-2"></i>
                Entendido
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cerrar modal con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('errorModal');
            if (modal && modal.style.display !== 'none') {
                modal.style.display = 'none';
            }
        }
    });

    // Cerrar modal al hacer clic fuera
    const modal = document.getElementById('errorModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.style.display = 'none';
            }
        });
    }
});
</script>
@endif
