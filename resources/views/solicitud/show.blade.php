<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Solicitud</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Menú -->
    @include('partials.menu')

    <!-- Título -->
    <header class="container">
        <h1>Detalle de Solicitud de Adopción</h1>
    </header>

    <!-- Detalle de la Solicitud -->
    <div class="detalle-solicitud-container">
        <div class="detalle-solicitud-card">
            <!-- Información de la Solicitud -->
            <div class="detalle-solicitud-info">
                <h2>Solicitud #{{ $solicitud->id }}</h2>
                <p><strong>Usuario:</strong> {{ $solicitud->usuario->nombre }}</p>
                <p><strong>Mascota:</strong> {{ $solicitud->mascota->nombre }}</p>
                <p><strong>Fecha de Solicitud:</strong> {{ \Carbon\Carbon::parse($solicitud->fecha_solicitud)->format('d/m/Y') }}</p>
                <p><strong>Estado:</strong> {{ ucfirst($solicitud->estado) }}</p>
                <p><strong>Comentario:</strong> {{ $solicitud->comentario ?: 'Sin comentario' }}</p>
            </div>
        </div>

        <!-- Botón para volver -->
        <a href="{{ route('solicitud.index') }}" class="btn btn-volver">Volver al Listado</a>
    </div>
</body>
</html>
