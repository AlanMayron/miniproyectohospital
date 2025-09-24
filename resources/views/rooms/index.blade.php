@extends('layouts.app')

@section('content')
  <div class="card shadow-sm">
    <div class="card-body">
      {{-- Buscador --}}
      <form method="GET" class="row g-2 mb-3">
        <div class="col-md-8">
          <input
            type="text"
            name="q"
            value="{{ $q }}"
            class="form-control"
            placeholder="Buscar por nombre o ubicación..."
          >
        </div>
        <div class="col-md-4 d-flex gap-2">
          <button class="btn btn-outline-primary" type="submit">Buscar</button>
          <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary">Limpiar</a>
        </div>
      </form>

      {{-- Toggle: Ver eliminadas / Ver activas --}}
      <div class="d-flex gap-2 mb-3">
        @if (empty($showTrashed))
          <a class="btn btn-outline-dark"
             href="{{ route('rooms.index', array_filter(['q' => $q, 'trashed' => 1])) }}">
            Ver eliminadas
          </a>
        @else
          <a class="btn btn-outline-secondary"
             href="{{ route('rooms.index', array_filter(['q' => $q])) }}">
            Ver activas
          </a>
        @endif
      </div>

      {{-- Tabla --}}
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Ubicación</th>
              <th>Capacidad</th>
              <th>Estado</th>
              <th class="text-end">Acciones</th>
            </tr>
          </thead>
          <tbody>
          @forelse ($rooms as $room)
            <tr>
              <td>{{ $room->id }}</td>
              <td class="fw-medium">{{ $room->name }}</td>
              <td>{{ $room->location ?? '—' }}</td>
              <td>{{ $room->capacity }}</td>
              <td>
                @php
                  $badge = [
                    'disponible' => 'text-bg-success',
                    'ocupada' => 'text-bg-warning',
                    'mantenimiento' => 'text-bg-secondary',
                  ][$room->status] ?? 'text-bg-light';
                @endphp
                <span class="badge {{ $badge }}">{{ ucfirst($room->status) }}</span>
              </td>
              <td class="text-end">
                @if (empty($showTrashed))
                  {{-- Acciones para activas --}}
                  <a href="{{ route('rooms.edit', $room) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                  <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('¿Eliminar la sala {{ $room->name }}?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                  </form>
                @else
                  {{-- Acciones para eliminadas: Restaurar (y opcionalmente eliminar definitivo) --}}
                  <form action="{{ route('rooms.restore', $room->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('¿Restaurar la sala {{ $room->name }}?')">
                    @csrf
                    <button class="btn btn-sm btn-outline-success">Restaurar</button>
                  </form>

                  {{-- (Opcional) Eliminar definitivamente:
                  <form action="{{ route('rooms.force-delete', $room->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('⚠️ Esta acción no se puede deshacer. ¿Eliminar definitivamente?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Eliminar definitivamente</button>
                  </form>
                  --}}
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted">Sin resultados.</td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>

      {{-- Paginación --}}
      <div>
        {{ $rooms->links() }}
      </div>
    </div>
  </div>
@endsection

