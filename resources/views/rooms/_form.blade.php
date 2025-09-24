@csrf
@php
  $statuses = ['disponible' => 'Disponible', 'ocupada' => 'Ocupada', 'mantenimiento' => 'Mantenimiento'];
@endphp

<div class="mb-3">
  <label class="form-label">Nombre</label>
  <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
         value="{{ old('name', $room->name ?? '') }}" placeholder="Ej: Sala 7">
  @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Capacidad</label>
  <input type="number" name="capacity" min="1" class="form-control @error('capacity') is-invalid @enderror"
         value="{{ old('capacity', $room->capacity ?? 1) }}">
  @error('capacity') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Estado</label>
  <select name="status" class="form-select @error('status') is-invalid @enderror">
    <option value="">-- Selecciona --</option>
    @foreach ($statuses as $val => $label)
      <option value="{{ $val }}" @selected(old('status', $room->status ?? '') === $val)>{{ $label }}</option>
    @endforeach
  </select>
  @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
  <label class="form-label">Ubicación</label>
  <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
         value="{{ old('location', $room->location ?? '') }}" placeholder="Piso 2, Área Norte">
  @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="d-flex gap-2">
  <button class="btn btn-primary">Guardar</button>
  <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary">Cancelar</a>
</div>
