@extends('layouts.app')

@section('content')
  <div class="card shadow-sm">
    <div class="card-body">
      <h5 class="mb-3">Nueva sala</h5>
      <form method="POST" action="{{ route('rooms.store') }}">
        @include('rooms._form')
      </form>
    </div>
  </div>
@endsection
