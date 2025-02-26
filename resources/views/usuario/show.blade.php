<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Usuario</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Menú -->
    @include('partials.menu')

    <!-- Título -->
    <header class="container">
        <h1>Detalle de Usuario</h1>
    </header>

    <!-- Detalle del Usuario -->
    <div class="detalle-usuario-container">
        <div class="detalle-usuario-card">
            <!-- Imagen por defecto -->
            <img src="{{ asset('images/persona.jpg') }}" alt="Usuario" class="detalle-usuario-img">

            <!-- Información del Usuario -->
            <div class="detalle-usuario-info">
                <h2>{{ $usuario->name }}</h2>
                <p><strong>Email:</strong> {{ $usuario->email }}</p>
                <p><strong>Dirección:</strong> {{ $usuario->direccion }}</p>
                <p><strong>Teléfono:</strong> {{ $usuario->telefono }}</p>
            </div>
        </div>

        <!-- Botón para volver -->
        <a href="{{ route('usuario.index') }}" class="btn btn-volver">Volver al Listado</a>
    </div>
</body>
</html>
