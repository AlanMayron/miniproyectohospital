@extends('layouts.app')

@section('content')
  <div class="card shadow-sm">
    <div class="card-body">
      <h5 class="mb-3">Editar sala</h5>
      <form method="POST" action="{{ route('rooms.update', $room) }}">
        @method('PUT')
        @include('rooms._form', ['room' => $room])
      </form>
    </div>
  </div>
@endsection
