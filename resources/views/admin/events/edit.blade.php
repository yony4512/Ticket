@extends('layouts.admin')

@section('title', 'Editar Evento')
@section('subtitle')
    <div class="flex items-center text-blue-700 text-base font-semibold mb-2">
        <i class="fas fa-edit mr-2"></i>
        Modifica la información del evento
    </div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 via-purple-800 to-indigo-900 bg-clip-text text-transparent">
                Editar Evento
            </h1>
            <p class="text-gray-600 mt-2">Modifica la información del evento: {{ $event->title }}</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.events.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                <i class="fas fa-arrow-left mr-2"></i>
                Volver a Eventos
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="glass-effect rounded-xl p-6 shadow-lg border border-gray-200">
        <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Título -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-heading mr-2 text-blue-600"></i>
                        Título del Evento
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                        placeholder="Ingresa el título del evento">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Categoría -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-tag mr-2 text-green-600"></i>
                        Categoría
                    </label>
                    <select name="category" id="category" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        @foreach($categories as $key => $category)
                            <option value="{{ $key }}" {{ old('category', $event->category) == $key ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Estado -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-toggle-on mr-2 text-purple-600"></i>
                        Estado
                    </label>
                    <select name="status" id="status" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        <option value="active" {{ old('status', $event->status) == 'active' ? 'selected' : '' }}>Activo</option>
                        <option value="inactive" {{ old('status', $event->status) == 'inactive' ? 'selected' : '' }}>Inactivo</option>
                        <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ubicación -->
                <div class="md:col-span-2">
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-map-marker-alt mr-2 text-red-600"></i>
                        Ubicación
                    </label>
                    <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                        placeholder="Dirección del evento">
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fecha y Hora -->
                <div class="md:col-span-2">
                    <label for="event_date" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-alt mr-2 text-blue-600"></i>
                        Fecha y Hora del Evento
                    </label>
                    <input type="datetime-local" name="event_date" id="event_date" 
                        value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                    @error('event_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Precio -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-dollar-sign mr-2 text-green-600"></i>
                        Precio (S/.)
                    </label>
                    <input type="number" name="price" id="price" value="{{ old('price', $event->price) }}" step="0.01" min="0" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                        placeholder="0.00">
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Capacidad -->
                <div>
                    <label for="capacity" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-users mr-2 text-purple-600"></i>
                        Capacidad
                    </label>
                    <input type="number" name="capacity" id="capacity" value="{{ old('capacity', $event->capacity) }}" min="1"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                        placeholder="Número de asistentes">
                    @error('capacity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-align-left mr-2 text-indigo-600"></i>
                        Descripción
                    </label>
                    <textarea name="description" id="description" rows="6" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                        placeholder="Describe el evento en detalle">{{ old('description', $event->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Imagen -->
                <div class="md:col-span-2">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-image mr-2 text-pink-600"></i>
                        Imagen del Evento
                    </label>
                    @if ($event->image_path)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Imagen actual:</p>
                            <img src="{{ $event->image_url }}" alt="Imagen actual" class="h-32 w-auto rounded-lg border border-gray-200">
                        </div>
                    @endif
                    <input type="file" name="image" id="image" accept="image/*"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="mt-1 text-sm text-gray-500">Deja en blanco para mantener la imagen actual</p>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Botones -->
            <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.events.show', $event) }}" 
                    class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </a>
                <button type="submit" 
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <i class="fas fa-save mr-2"></i>
                    Actualizar Evento
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

<style>
    .glass-effect {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
</style> 