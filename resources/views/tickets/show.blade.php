@php
    use App\Models\Event;
    use Illuminate\Support\Str;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalles de la Entrada') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Información del Evento -->
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $ticket->event->title }}</h3>
                        
                        @if($ticket->event->image_path)
                            <img src="{{ $ticket->event->image_url }}" alt="{{ $ticket->event->title }}" class="w-full h-64 object-cover rounded-lg mb-4">
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">{{ __('Fecha y Hora') }}</p>
                                <p class="text-lg">{{ $ticket->event->formatted_date }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">{{ __('Ubicación') }}</p>
                                <p class="text-lg">{{ $ticket->event->location }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">{{ __('Categoría') }}</p>
                                <p class="text-lg">{{ Event::categories()[$ticket->event->category] }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">{{ __('Organizador') }}</p>
                                <p class="text-lg">{{ $ticket->event->user->name }}</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <p class="text-sm font-medium text-gray-500">{{ __('Descripción') }}</p>
                            <p class="text-gray-700">{{ $ticket->event->description }}</p>
                        </div>
                    </div>

                    <!-- Información del Ticket -->
                    <div class="border-t pt-6">
                        <h4 class="text-xl font-semibold text-gray-900 mb-4">{{ __('Información de la Entrada') }}</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <p class="text-sm font-medium text-gray-500">{{ __('Código de Entrada') }}</p>
                                <p class="text-lg font-mono bg-gray-100 p-2 rounded">{{ $ticket->ticket_code }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">{{ __('Estado') }}</p>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $ticket->status_color }}-100 text-{{ $ticket->status_color }}-800">
                                    {{ $ticket->status_label }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">{{ __('Cantidad') }}</p>
                                <p class="text-lg">{{ $ticket->quantity }} {{ Str::plural('entrada', $ticket->quantity) }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">{{ __('Precio Unitario') }}</p>
                                <p class="text-lg">{{ $ticket->event->formatted_price }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">{{ __('Total Pagado') }}</p>
                                <p class="text-lg font-semibold text-green-600">S/. {{ number_format($ticket->total_price, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">{{ __('Fecha de Compra') }}</p>
                                <p class="text-lg">{{ $ticket->purchased_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        @if($ticket->notes)
                            <div class="mb-6">
                                <p class="text-sm font-medium text-gray-500">{{ __('Notas') }}</p>
                                <p class="text-gray-700 bg-gray-50 p-3 rounded">{{ $ticket->notes }}</p>
                            </div>
                        @endif

                        @if($ticket->used_at)
                            <div class="mb-6">
                                <p class="text-sm font-medium text-gray-500">{{ __('Fecha de Uso') }}</p>
                                <p class="text-lg">{{ $ticket->used_at->format('d/m/Y H:i') }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Acciones -->
                    <div class="border-t pt-6 flex flex-wrap gap-4">
                        <a href="{{ route('tickets.download', $ticket) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <i class="fas fa-download mr-2"></i>
                            {{ __('Descargar Entrada') }}
                        </a>

                        @if($ticket->canBeCancelled())
                            <form action="{{ route('tickets.cancel', $ticket) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" onclick="return confirm('¿Estás seguro de que quieres cancelar esta entrada?')">
                                    <i class="fas fa-times mr-2"></i>
                                    {{ __('Cancelar Entrada') }}
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('tickets.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <i class="fas fa-arrow-left mr-2"></i>
                            {{ __('Volver a Mis Entradas') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 