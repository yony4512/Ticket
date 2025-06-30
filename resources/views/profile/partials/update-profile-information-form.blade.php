<section>
    <header class="mb-6">
        <div class="flex items-center space-x-3 mb-4">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-user text-white text-lg"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold bg-gradient-to-r from-gray-900 via-blue-800 to-indigo-800 bg-clip-text text-transparent">
                    Información de Perfil
                </h2>
                <p class="text-gray-600 mt-1">Actualiza la información de tu cuenta y dirección de correo electrónico</p>
            </div>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <x-input-label for="name" value="Nombre completo" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" placeholder="Ingrese su nombre completo" />
            </div>

            <div>
                <x-input-label for="email" value="Correo electrónico" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" placeholder="ejemplo@correo.com" />
            </div>
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                <div class="flex items-start space-x-3">
                    <div class="w-6 h-6 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i class="fas fa-exclamation-triangle text-yellow-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-yellow-800 mb-2">
                            Tu dirección de correo electrónico no está verificada.
                        </p>
                        <button form="send-verification" 
                                class="inline-flex items-center px-3 py-1 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium rounded-lg transition-colors">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Reenviar verificación
                        </button>
                    </div>
                </div>
                @if (session('status') === 'verification-link-sent')
                    <div class="mt-3 bg-green-50 border border-green-200 rounded-lg p-3">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-check-circle text-green-600"></i>
                            <p class="text-sm text-green-800">Se ha enviado un nuevo enlace de verificación a tu correo electrónico.</p>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <div class="flex justify-end pt-6 border-t border-gray-200">
            <div class="flex items-center space-x-3">
                @if (session('status') === 'profile-updated')
                    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" 
                         class="flex items-center space-x-2 px-4 py-2 bg-green-100 text-green-800 rounded-lg">
                        <i class="fas fa-check-circle"></i>
                        <span class="text-sm font-medium">Guardado correctamente</span>
                    </div>
                @endif
                <x-primary-button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                    <i class="fas fa-save mr-2"></i>
                    Guardar cambios
                </x-primary-button>
            </div>
        </div>
    </form>
</section>

<style>
    section {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        padding: 2rem 1.5rem;
    }
    .flex.items-center.gap-4 {
        justify-content: flex-end;
    }
</style>
