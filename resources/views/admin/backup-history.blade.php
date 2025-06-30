@extends('layouts.admin')

@section('title', 'Historial de Respaldos')

@section('content')
<div class="max-w-2xl mx-auto mt-10">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h1 class="text-2xl font-bold mb-4 text-gray-900">Historial de Respaldos</h1>
        <p class="text-gray-600 mb-6">Aquí se mostrarán los respaldos realizados del sistema. (Funcionalidad en desarrollo)</p>
        <a href="{{ route('admin.settings') }}" class="inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Volver a Configuración</a>
    </div>
</div>
@endsection 