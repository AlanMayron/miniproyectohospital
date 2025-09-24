<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name','Hospital') }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg bg-white border-bottom mb-3">
  <div class="container">
    <a class="navbar-brand fw-bold" href="{{ route('rooms.index') }}">Hospital</a>
    <div class="ms-auto">
      <a class="btn btn-primary" href="{{ route('rooms.create') }}">Nueva sala</a>
    </div>
  </div>
</nav>

<div class="container">
  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @yield('content')
</div>
</body>
</html>
