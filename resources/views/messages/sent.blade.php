<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mensajes Enviados') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Mensajes Enviados</h1>
                    <p class="text-gray-600">Mensajes que has enviado al administrador</p>
                </div>
                <a href="{{ route('messages.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                    <i class="fas fa-plus mr-2"></i>
                    Nuevo Mensaje
                </a>
            </div>

            <!-- Tabs -->
            <div class="mb-6">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8">
                        <a href="{{ route('messages.index') }}" 
                           class="py-2 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            Recibidos
                        </a>
                        <a href="{{ route('messages.sent') }}" 
                           class="py-2 px-1 border-b-2 font-medium text-sm border-blue-500 text-blue-600">
                            Enviados ({{ $messages->total() }})
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Messages List -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                @if($messages->isEmpty())
                    <div class="p-8 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-paper-plane text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500 text-lg mb-2">No has enviado mensajes</p>
                        <p class="text-gray-400 text-sm mb-4">Comienza una conversación con el administrador</p>
                        <a href="{{ route('messages.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                            <i class="fas fa-plus mr-2"></i>
                            Enviar Mensaje
                        </a>
                    </div>
                @else
                    <div class="divide-y divide-gray-200">
                        @foreach($messages as $message)
                            <div class="p-6 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-user text-green-600"></i>
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-2">
                                                    <h4 class="text-sm font-medium text-gray-900">Para: Administrador</h4>
                                                    @if($message->read_at)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            Leído
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            No leído
                                                        </span>
                                                    @endif
                                                </div>
                                                <h5 class="text-sm font-semibold text-gray-900 mt-1">{{ $message->subject }}</h5>
                                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($message->message, 150) }}</p>
                                                <div class="flex items-center space-x-4 mt-2 text-xs text-gray-500">
                                                    <span>Enviado: {{ $message->created_at->format('d/m/Y H:i') }}</span>
                                                    @if($message->read_at)
                                                        <span>Leído: {{ $message->read_at->format('d/m/Y H:i') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('messages.show', $message) }}" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Paginación -->
                    @if($messages->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200">
                            {{ $messages->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-app-layout> 