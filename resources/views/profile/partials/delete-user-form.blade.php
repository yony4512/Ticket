<section class="space-y-6">
    <header class="mb-6">
        <div class="flex items-center space-x-3 mb-4">
            <div class="w-10 h-10 bg-gradient-to-br from-red-600 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-trash-alt text-white text-lg"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold bg-gradient-to-r from-gray-900 via-red-800 to-pink-800 bg-clip-text text-transparent">
                    Eliminar Cuenta
                </h2>
                <p class="text-gray-600 mt-1">Una vez eliminada tu cuenta, todos sus recursos y datos se eliminarán permanentemente</p>
            </div>
        </div>
    </header>

    <div class="bg-red-50 border border-red-200 rounded-xl p-6">
        <div class="flex items-start space-x-3">
            <div class="w-6 h-6 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                <i class="fas fa-exclamation-triangle text-red-600 text-sm"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-sm font-medium text-red-800 mb-2">Acción irreversible</h3>
                <p class="text-sm text-red-700 mb-4">
                    Antes de eliminar tu cuenta, asegúrate de descargar cualquier dato o información que desees conservar. 
                    Esta acción no se puede deshacer.
                </p>
                <x-danger-button
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                    class="bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300"
                >
                    <i class="fas fa-trash-alt mr-2"></i>
                    Eliminar Cuenta
                </x-danger-button>
            </div>
        </div>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <div class="flex items-center space-x-3 mb-4">
                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <h2 class="text-lg font-medium text-gray-900">
                    ¿Estás seguro de que quieres eliminar tu cuenta?
                </h2>
            </div>

            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-red-800">
                    Una vez eliminada tu cuenta, todos sus recursos y datos se eliminarán permanentemente. 
                    Por favor, ingresa tu contraseña para confirmar que deseas eliminar permanentemente tu cuenta.
                </p>
            </div>

            <div class="mb-6">
                <x-input-label for="password" value="Contraseña" class="block text-sm font-medium text-gray-700 mb-2" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full"
                    placeholder="Ingresa tu contraseña para confirmar"
                />
            </div>

            <div class="flex justify-end space-x-3">
                <x-secondary-button x-on:click="$dispatch('close')" 
                                   class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium rounded-lg transition-colors">
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </x-secondary-button>

                <x-danger-button class="bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                    <i class="fas fa-trash-alt mr-2"></i>
                    Eliminar Cuenta
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
