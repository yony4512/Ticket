@extends('layouts.admin')

@section('title', 'Ver Mensaje')
@section('subtitle', '<p class="text-sm text-gray-600">Detalle del mensaje recibido</p>')

@section('content')
<div class="space-y-6">
    <!-- Detalle del mensaje -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Mensaje de {{ $message->fromUser->name }}</h3>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.messages.index') }}" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Volver
                    </a>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <div class="space-y-4">
                <!-- Información del remitente -->
                <div class="flex items-center space-x-3 p-4 bg-gray-50 rounded-lg">
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-indigo-600 text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-900">{{ $message->fromUser->name }}</h4>
                        <p class="text-sm text-gray-500">{{ $message->fromUser->email }}</p>
                        <p class="text-xs text-gray-400">Miembro desde {{ $message->fromUser->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
                
                <!-- Detalles del mensaje -->
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Asunto</label>
                        <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md">{{ $message->subject }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mensaje</label>
                        <div class="bg-gray-50 p-4 rounded-md">
                            <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $message->message }}</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Envío</label>
                            <p class="text-sm text-gray-900">{{ $message->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $message->read_at ? 'green' : 'yellow' }}-100 text-{{ $message->read_at ? 'green' : 'yellow' }}-800">
                                {{ $message->read_at ? 'Leído' : 'No leído' }}
                            </span>
                        </div>
                    </div>
                    
                    @if($message->read_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Lectura</label>
                            <p class="text-sm text-gray-900">{{ $message->read_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Responder mensaje -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Responder Mensaje</h3>
        </div>
        
        <div class="p-6">
            <form method="POST" action="{{ route('admin.messages.reply', $message) }}" class="space-y-4">
                @csrf
                
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Asunto</label>
                    <input type="text" name="subject" id="subject" value="Re: {{ $message->subject }}" 
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Respuesta</label>
                    <textarea name="message" id="message" rows="6" 
                              class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                              placeholder="Escribe tu respuesta aquí..." required></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.messages.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors">
                        <i class="fas fa-reply mr-2"></i>
                        Enviar Respuesta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 