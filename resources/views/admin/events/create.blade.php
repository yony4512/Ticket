@extends('layouts.admin')

@section('title', 'Crear Evento')
@section('subtitle')
    <div class="flex items-center text-blue-700 text-base font-semibold mb-2">
        <i class="fas fa-plus-circle mr-2"></i>
        Crea un nuevo evento para el sistema
    </div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 via-purple-800 to-indigo-900 bg-clip-text text-transparent">
                Crear Nuevo Evento
            </h1>
            <p class="text-gray-600 mt-2">Crea un nuevo evento para el sistema</p>
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
    <div class="glass-effect rounded-2xl p-8 shadow-xl border border-gray-200">
        <form method="POST" action="{{ route('admin.events.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Título -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-heading mr-2 text-indigo-600"></i>
                        Título del Evento
                    </label>
                    <input type="text" name="title" id="title" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                           placeholder="Título del evento"
                           value="{{ old('title') }}">
                    @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Categoría -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-tag mr-2 text-indigo-600"></i>
                        Categoría
                    </label>
                    <select name="category" id="category" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                        <option value="">Selecciona una categoría</option>
                        <option value="concierto" {{ old('category') == 'concierto' ? 'selected' : '' }}>Concierto</option>
                        <option value="conferencia" {{ old('category') == 'conferencia' ? 'selected' : '' }}>Conferencia</option>
                        <option value="deportivo" {{ old('category') == 'deportivo' ? 'selected' : '' }}>Deportivo</option>
                        <option value="cultural" {{ old('category') == 'cultural' ? 'selected' : '' }}>Cultural</option>
                        <option value="teatro" {{ old('category') == 'teatro' ? 'selected' : '' }}>Teatro</option>
                        <option value="otros" {{ old('category') == 'otros' ? 'selected' : '' }}>Otros</option>
                    </select>
                    @error('category')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fecha y Hora -->
                <div>
                    <label for="event_date" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar mr-2 text-indigo-600"></i>
                        Fecha y Hora
                    </label>
                    <input type="datetime-local" name="event_date" id="event_date" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                           value="{{ old('event_date') }}">
                    @error('event_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Precio -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-dollar-sign mr-2 text-indigo-600"></i>
                        Precio
                    </label>
                    <input type="number" name="price" id="price" step="0.01" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                           placeholder="0.00"
                           value="{{ old('price') }}">
                    @error('price')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Capacidad -->
                <div>
                    <label for="capacity" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-users mr-2 text-indigo-600"></i>
                        Capacidad
                    </label>
                    <input type="number" name="capacity" id="capacity" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                           placeholder="100"
                           value="{{ old('capacity') }}">
                    @error('capacity')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ubicación -->
                <div class="md:col-span-2">
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-map-marker-alt mr-2 text-indigo-600"></i>
                        Ubicación
                    </label>
                    <input type="text" name="location" id="location" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                           placeholder="Dirección del evento"
                           value="{{ old('location') }}">
                    @error('location')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-align-left mr-2 text-indigo-600"></i>
                        Descripción
                    </label>
                    <textarea name="description" id="description" rows="6" required
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                              placeholder="Describe el evento...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4 pt-6">
                <a href="{{ route('admin.events.index') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-all duration-200">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                    <i class="fas fa-save mr-2"></i>
                    Crear Evento
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 