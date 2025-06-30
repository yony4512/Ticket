@extends('layouts.admin')

@section('title', 'Mensajes Recibidos')


@section('content')
<div class="space-y-6">
    <!-- Lista de mensajes -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Mensajes ({{ $messages->total() }})</h3>
        </div>
        
        <div class="divide-y divide-gray-200">
            @forelse($messages as $message)
                <div class="p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-indigo-600"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $message->fromUser->name }}</h4>
                                        <span class="text-sm text-gray-500">{{ $message->fromUser->email }}</span>
                                        @if($message->isUnread())
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Nuevo
                                            </span>
                                        @endif
                                    </div>
                                    <h5 class="text-sm font-semibold text-gray-900 mt-1">{{ $message->subject }}</h5>
                                    <p class="text-sm text-gray-600 mt-1">{{ Str::limit($message->message, 150) }}</p>
                                    <div class="flex items-center space-x-4 mt-2 text-xs text-gray-500">
                                        <span>{{ $message->created_at->format('d/m/Y H:i') }}</span>
                                        @if($message->read_at)
                                            <span>Leído: {{ $message->read_at->format('d/m/Y H:i') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.messages.show', $message) }}" class="text-indigo-600 hover:text-indigo-900">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500">
                    No tienes mensajes recibidos
                </div>
            @endforelse
        </div>
        
        <!-- Paginación -->
        @if($messages->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $messages->links() }}
            </div>
        @endif
    </div>
</div>
@endsection 