@extends('layouts.app')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Rooms') }}
</h2>
@endsection

@section('content')
<div class="py-6" x-data="{ editId: null }">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

    {{-- Flash --}}
    @if(session('ok'))
      <div class="p-3 bg-green-50 text-green-700 rounded border border-green-200">{{ session('ok') }}</div>
    @endif
    @if(session('error'))
      <div class="p-3 bg-red-50 text-red-700 rounded border border-red-200">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
      <div class="p-3 bg-red-50 text-red-700 rounded border border-red-200">
        <ul class="list-disc list-inside text-sm">
          @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
      </div>
    @endif

    {{-- Alta rápida --}}
    <div class="bg-white p-6 rounded shadow">
      <h3 class="text-lg font-semibold mb-4">Nueva sala</h3>
      <form method="POST" action="{{ route('rooms.store') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        @csrf
        <div>
          <label class="block text-sm text-gray-700 mb-1">Nombre</label>
          <input name="name" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('name') }}">
        </div>
        <div>
          <label class="block text-sm text-gray-700 mb-1">Capacidad</label>
          <input name="capacity" type="number" min="0" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('capacity', 0) }}">
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm text-gray-700 mb-1">Descripción</label>
          <input name="description" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('description') }}">
        </div>
        <div class="md:col-span-4 flex items-center justify-end gap-3">
          <button class="px-3 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 text-sm">Guardar</button>
        </div>
      </form>
    </div>

    {{-- Lista de salas --}}
    <div class="space-y-4">
      @forelse($rooms as $room)
        <div class="bg-white p-5 rounded shadow" x-data="{ open: false }">
          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
              <div class="flex items-center gap-3">
                <h4 class="text-lg font-semibold text-gray-900">{{ $room->name }}</h4>
                {{-- Badge de uso --}}
                @php
                  $pct = $room->utilization;
                  $color = $pct >= 100 ? 'bg-red-100 text-red-700' : ($pct >= 80 ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700');
                @endphp
                <span class="px-2 py-0.5 text-xs rounded {{ $color }}">{{ $pct }}%</span>
              </div>
              <div class="text-sm text-gray-600">
                Capacidad: <span class="font-medium">{{ $room->capacity }}</span> —
                Ocupación: <span class="font-medium">{{ $room->occupancy }}</span>
              </div>
              @if($room->description)
                <div class="text-sm text-gray-500 mt-1">{{ $room->description }}</div>
              @endif
            </div>

            <div class="flex items-center gap-2">
              {{-- Check-in / Check-out --}}
              <form method="POST" action="{{ route('rooms.checkin', $room) }}">
                @csrf
                <button class="px-3 py-1.5 rounded bg-emerald-600 text-white text-sm hover:bg-emerald-700">+1</button>
              </form>
              <form method="POST" action="{{ route('rooms.checkout', $room) }}">
                @csrf
                <button class="px-3 py-1.5 rounded bg-slate-600 text-white text-sm hover:bg-slate-700">-1</button>
              </form>

              {{-- Editar inline: toggle --}}
              <button @click="open = !open; editId = {{ $room->id }};"
                      class="px-3 py-1.5 rounded border text-gray-700 hover:bg-gray-50 text-sm">
                Editar
              </button>

              {{-- Eliminar --}}
              <form method="POST" action="{{ route('rooms.destroy', $room) }}"
                    onsubmit="return confirm('¿Eliminar sala {{ $room->name }}?');">
                @csrf @method('DELETE')
                <button class="px-3 py-1.5 rounded bg-red-600 text-white text-sm hover:bg-red-700">
                  Eliminar
                </button>
              </form>
            </div>
          </div>

          {{-- Form de edición inline --}}
          <div x-show="open" x-cloak class="mt-4 border-t pt-4">
            <form method="POST" action="{{ route('rooms.update', $room) }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
              @csrf @method('PUT')
              <div>
                <label class="block text-sm text-gray-700 mb-1">Nombre</label>
                <input name="name" required value="{{ old('name', $room->name) }}"
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
              </div>
              <div>
                <label class="block text-sm text-gray-700 mb-1">Capacidad</label>
                <input name="capacity" type="number" min="{{ $room->occupancy }}" required
                       value="{{ old('capacity', $room->capacity) }}"
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <p class="text-xs text-gray-500 mt-1">No puede ser menor a la ocupación actual ({{ $room->occupancy }}).</p>
              </div>
              <div class="md:col-span-2">
                <label class="block text-sm text-gray-700 mb-1">Descripción</label>
                <input name="description" value="{{ old('description', $room->description) }}"
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
              </div>
              <div class="md:col-span-4 flex items-center justify-end gap-3">
                <button class="px-3 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 text-sm">Actualizar</button>
              </div>
            </form>
          </div>
        </div>
      @empty
        <div class="p-6 bg-white rounded shadow">
          <p class="text-gray-600">No hay salas registradas.</p>
        </div>
      @endforelse
    </div>

  </div>
</div>
@endsection
