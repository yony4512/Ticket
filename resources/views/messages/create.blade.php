<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Enviar Mensaje') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Enviar Mensaje al Administrador</h1>
                        <p class="text-gray-600">Comunícate directamente con el administrador del sistema</p>
                    </div>
                    <a href="{{ route('messages.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver
                    </a>
                </div>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Nuevo Mensaje</h3>
                </div>
                
                <div class="p-6">
                    <form method="POST" action="{{ route('messages.store') }}" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-heading mr-2 text-blue-600"></i>
                                Asunto
                            </label>
                            <input type="text" name="subject" id="subject" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                   placeholder="Asunto del mensaje"
                                   value="{{ old('subject') }}">
                            @error('subject')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-comment mr-2 text-blue-600"></i>
                                Mensaje
                            </label>
                            <textarea name="message" id="message" rows="8" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                      placeholder="Escribe tu mensaje aquí...">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('messages.index') }}" 
                               class="px-6 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-all duration-200">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Enviar Mensaje
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Box -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i class="fas fa-info-circle text-blue-600 text-sm"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-blue-800">Información</h4>
                        <p class="text-sm text-blue-700 mt-1">
                            Tu mensaje será enviado directamente al administrador del sistema. 
                            Recibirás una notificación cuando el administrador responda.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 