<section>
    <header class="mb-6">
        <div class="flex items-center space-x-3 mb-4">
            <div class="w-10 h-10 bg-gradient-to-br from-green-600 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-lock text-white text-lg"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold bg-gradient-to-r from-gray-900 via-green-800 to-emerald-800 bg-clip-text text-transparent">
                    Actualizar Contraseña
                </h2>
                <p class="text-gray-600 mt-1">Utiliza una contraseña larga y aleatoria para mantener tu cuenta segura</p>
            </div>
        </div>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <x-input-label for="update_password_current_password" value="Contraseña actual" />
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" placeholder="Ingrese su contraseña actual" />
            </div>

            <div>
                <x-input-label for="update_password_password" value="Nueva contraseña" />
                <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" placeholder="Ingrese una nueva contraseña" oninput="medirFortaleza(this.value)" />
                <div id="password-strength" class="mt-2 text-sm font-medium"></div>
            </div>
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" value="Confirmar nueva contraseña" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" placeholder="Repita la nueva contraseña" />
        </div>

        <!-- Indicador de fortaleza de contraseña mejorado -->
        <div class="bg-gray-50 rounded-xl p-4">
            <div class="flex items-center space-x-3 mb-3">
                <i class="fas fa-shield-alt text-gray-600"></i>
                <span class="text-sm font-medium text-gray-700">Recomendaciones de seguridad:</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-gray-600">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-check-circle text-green-500" id="length-check"></i>
                    <span>Al menos 8 caracteres</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-check-circle text-green-500" id="uppercase-check"></i>
                    <span>Una letra mayúscula</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-check-circle text-green-500" id="lowercase-check"></i>
                    <span>Una letra minúscula</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-check-circle text-green-500" id="number-check"></i>
                    <span>Un número</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-check-circle text-green-500" id="special-check"></i>
                    <span>Un carácter especial</span>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-6 border-t border-gray-200">
            <div class="flex items-center space-x-3">
                @if (session('status') === 'password-updated')
                    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" 
                         class="flex items-center space-x-2 px-4 py-2 bg-green-100 text-green-800 rounded-lg">
                        <i class="fas fa-check-circle"></i>
                        <span class="text-sm font-medium">Contraseña actualizada correctamente</span>
                    </div>
                @endif
                <x-primary-button class="bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                    <i class="fas fa-key mr-2"></i>
                    Guardar contraseña
                </x-primary-button>
            </div>
        </div>
    </form>
</section>

<script>
function medirFortaleza(password) {
    const barra = document.getElementById('password-strength');
    const checks = {
        length: document.getElementById('length-check'),
        uppercase: document.getElementById('uppercase-check'),
        lowercase: document.getElementById('lowercase-check'),
        number: document.getElementById('number-check'),
        special: document.getElementById('special-check')
    };
    
    let fortaleza = 0;
    let mensaje = '';
    let color = '';
    
    // Verificar cada criterio
    const hasLength = password.length >= 8;
    const hasUppercase = /[A-Z]/.test(password);
    const hasLowercase = /[a-z]/.test(password);
    const hasNumber = /[0-9]/.test(password);
    const hasSpecial = /[^A-Za-z0-9]/.test(password);
    
    // Actualizar iconos
    checks.length.className = hasLength ? 'fas fa-check-circle text-green-500' : 'fas fa-times-circle text-gray-400';
    checks.uppercase.className = hasUppercase ? 'fas fa-check-circle text-green-500' : 'fas fa-times-circle text-gray-400';
    checks.lowercase.className = hasLowercase ? 'fas fa-check-circle text-green-500' : 'fas fa-times-circle text-gray-400';
    checks.number.className = hasNumber ? 'fas fa-check-circle text-green-500' : 'fas fa-times-circle text-gray-400';
    checks.special.className = hasSpecial ? 'fas fa-check-circle text-green-500' : 'fas fa-times-circle text-gray-400';
    
    // Calcular fortaleza
    if (hasLength) fortaleza++;
    if (hasUppercase) fortaleza++;
    if (hasLowercase) fortaleza++;
    if (hasNumber) fortaleza++;
    if (hasSpecial) fortaleza++;
    
    // Determinar mensaje y color
    switch (fortaleza) {
        case 0:
        case 1:
            mensaje = 'Muy débil'; color = 'text-red-600'; break;
        case 2:
            mensaje = 'Débil'; color = 'text-orange-500'; break;
        case 3:
            mensaje = 'Aceptable'; color = 'text-yellow-600'; break;
        case 4:
            mensaje = 'Fuerte'; color = 'text-green-600'; break;
        case 5:
            mensaje = 'Muy fuerte'; color = 'text-green-800'; break;
    }
    
    if (password.length > 0) {
        barra.textContent = 'Fortaleza: ' + mensaje;
        barra.className = 'mt-2 text-sm font-medium ' + color;
    } else {
        barra.textContent = '';
        barra.className = 'mt-2 text-sm';
    }
}
</script>

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
