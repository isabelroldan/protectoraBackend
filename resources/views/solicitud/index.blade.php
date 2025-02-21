<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Solicitudes</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @include('partials.menu')

    <header class="container">
        <h1>Listado de Solicitudes de Adopción</h1>
    </header>

    <div class="container">
        <a href="{{ route('solicitud.showCreateView') }}" class="btn btn-submit">Crear Nueva Solicitud</a>
    </div>

    <div class="usuarios-container">
    @if(isset($solicitudes) && $solicitudes->isNotEmpty())
    @foreach($solicitudes as $solicitud)
        <div class="usuario-card">
            <div class="usuario-info">
                <h2>Solicitud #{{ $solicitud->id }}</h2>
                <p><strong>Usuario:</strong> {{ $solicitud->usuario?->name ?? 'Usuario no disponible' }}</p>
                <p><strong>Mascota:</strong> {{ $solicitud->mascota->nombre }}</p>
                <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($solicitud->fecha_solicitud)->format('d/m/Y') }}</p>
                <p><strong>Estado:</strong> {{ ucfirst($solicitud->estado) }}</p>

                <div class="acciones">
                    <a href="{{ route('solicitud.show', ['id' => $solicitud->id]) }}" class="btn btn-ver">Ver Detalle</a>
                    <a href="{{ route('solicitud.showUpdateView', ['id' => $solicitud->id]) }}" class="btn btn-editar">Editar</a>
                    <form action="{{ route('solicitud.delete', ['id' => $solicitud->id]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-borrar">Borrar</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@else
    <p>No hay solicitudes registradas.</p>
@endif

    </div>
</body>
</html>
