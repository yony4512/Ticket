<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ver Mensaje') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Mensaje</h1>
                        <p class="text-gray-600">Detalles del mensaje</p>
                    </div>
                    <a href="{{ route('messages.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver
                    </a>
                </div>
            </div>

            <!-- Message Details -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $message->subject }}</h3>
                </div>
                
                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Sender Info -->
                        <div class="flex items-center space-x-3 p-4 bg-gray-50 rounded-lg">
                            <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-indigo-600 text-lg"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">
                                    @if($message->from_user_id === auth()->id())
                                        Tú
                                    @else
                                        Administrador
                                    @endif
                                </h4>
                                <p class="text-sm text-gray-500">
                                    @if($message->from_user_id === auth()->id())
                                        {{ auth()->user()->email }}
                                    @else
                                        admin@example.com
                                    @endif
                                </p>
                                <p class="text-xs text-gray-400">{{ $message->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        
                        <!-- Message Content -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mensaje</label>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $message->message }}</p>
                            </div>
                        </div>
                        
                        <!-- Status -->
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $message->read_at ? 'green' : 'yellow' }}-100 text-{{ $message->read_at ? 'green' : 'yellow' }}-800">
                                    {{ $message->read_at ? 'Leído' : 'No leído' }}
                                </span>
                            </div>
                            @if($message->read_at)
                                <div class="text-sm text-gray-500">
                                    Leído: {{ $message->read_at->format('d/m/Y H:i') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reply Form (only if message is from admin) -->
            @if($message->from_user_id !== auth()->id())
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Responder</h3>
                    </div>
                    
                    <div class="p-6">
                        <form method="POST" action="{{ route('messages.store') }}" class="space-y-4">
                            @csrf
                            <input type="hidden" name="to_user_id" value="{{ $message->from_user_id }}">
                            
                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Asunto</label>
                                <input type="text" name="subject" id="subject" value="Re: {{ $message->subject }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                            
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Respuesta</label>
                                <textarea name="message" id="message" rows="6" 
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                          placeholder="Escribe tu respuesta aquí..." required></textarea>
                            </div>
                            
                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('messages.index') }}" 
                                   class="px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-all duration-200">
                                    Cancelar
                                </a>
                                <button type="submit" 
                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                                    <i class="fas fa-reply mr-2"></i>
                                    Enviar Respuesta
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout> 