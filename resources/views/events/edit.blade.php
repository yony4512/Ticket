<x-app-layout>
    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Modal de Errores -->
            <x-error-modal :errors="$errors" />
            
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <!-- Header del formulario -->
                <div class="bg-gradient-to-r from-emerald-600 via-teal-600 to-green-600 px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white bg-opacity-20 rounded-xl flex items-center justify-center shadow-lg backdrop-blur-sm">
                                <i class="fas fa-edit text-white text-lg"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-white">Editar Evento</h2>
                                <p class="text-sm text-emerald-100">Modifica la información de tu evento</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 lg:p-8 bg-gradient-to-br from-slate-50 via-emerald-50 to-teal-50">
                    <!-- Mensaje de Restricción de Edición -->
                    <div class="mb-6 bg-gradient-to-r from-yellow-50 to-orange-50 border border-yellow-200 rounded-xl p-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-full flex items-center justify-center shadow-lg mr-4">
                                <i class="fas fa-exclamation-triangle text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-yellow-800 mb-1">¡Atención!</h3>
                                <p class="text-yellow-700">Este evento solo puede ser editado <strong>una vez</strong>. Después de guardar los cambios, no podrás modificar la información nuevamente.</p>
                            </div>
                        </div>
                    </div>
                    
                    <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Columna Izquierda -->
                            <div class="space-y-6">
                                <div>
                                    <x-input-label for="title" value="Título del Evento" />
                                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $event->title)" required placeholder="Ingrese el título del evento" />
                                </div>

                                <div>
                                    <x-input-label for="category" value="Categoría" />
                                    <select id="category" name="category" class="border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm block mt-1 w-full" required>
                                        <option value="">Seleccione una categoría</option>
                                        @foreach($categories as $value => $label)
                                            <option value="{{ $value }}" {{ old('category', $event->category) == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700">Ubicación</label>
                                    <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}" required
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                        placeholder="Dirección del evento">
                                </div>

                                <div>
                                    <label for="event_date" class="block text-sm font-medium text-gray-700">Fecha y Hora del Evento</label>
                                    <input type="datetime-local" name="event_date" id="event_date" 
                                        value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}" required
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>

                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700">Precio (S/.)</label>
                                    <input type="number" name="price" id="price" value="{{ old('price', $event->price) }}" step="0.01" min="0" required
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                        placeholder="0.00">
                                </div>

                                <div>
                                    <label for="capacity" class="block text-sm font-medium text-gray-700">Capacidad (opcional)</label>
                                    <input type="number" name="capacity" id="capacity" value="{{ old('capacity', $event->capacity) }}" min="1"
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                        placeholder="Número de asistentes">
                                </div>
                            </div>

                            <!-- Columna Derecha -->
                            <div class="space-y-6">
                                <div class="lg:col-span-2">
                                    <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                                    <textarea name="description" id="description" rows="8" required
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                        placeholder="Describa el evento en detalle">{{ old('description', $event->description) }}</textarea>
                                </div>

                                <div>
                                    <label for="image" class="block text-sm font-medium text-gray-700">Imagen del Evento</label>
                                    @if ($event->image_path)
                                        <div class="mt-2 mb-4">
                                            <img src="{{ Storage::url($event->image_path) }}" alt="Imagen actual" class="h-32 w-auto rounded-lg border border-gray-200">
                                            <p class="text-sm text-gray-500 mt-1">Imagen actual (dejar en blanco para mantener)</p>
                                        </div>
                                    @endif
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg bg-white">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500">
                                                    <span>Cambiar imagen</span>
                                                    <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                                </label>
                                                <p class="pl-1">o arrastrar y soltar</p>
                                            </div>
                                            <p class="text-xs text-gray-500">PNG, JPG, GIF hasta 2MB</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end pt-6 border-t border-gray-200">
                            <div class="flex space-x-3">
                                <a href="{{ route('events.show', $event) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                                    <i class="fas fa-times mr-2"></i>
                                    Cancelar
                                </a>
                                <button type="submit" 
                                        class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-emerald-600 via-teal-600 to-green-600 hover:from-emerald-700 hover:via-teal-700 hover:to-green-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                                    <i class="fas fa-save mr-2"></i>
                                    Actualizar Evento
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 