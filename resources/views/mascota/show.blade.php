<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Mascota</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Menú -->
    @include('partials.menu')

    <!-- Título -->
    <header class="container">
        <h1>Detalle de Mascota</h1>
    </header>

    <!-- Detalle de Mascota -->
    <div class="detalle-mascota-container">
        <div class="detalle-mascota-card">
            <!-- Imagen según especie -->
            @if($mascota->especie === 'perro' || $mascota->especie === 'perra' || $mascota->especie === 'Perro' || $mascota->especie === 'Perra')
                <img src="{{ asset('images/perro.jpg') }}" alt="Perro" class="detalle-mascota-img">
            @elseif($mascota->especie === 'gato' || $mascota->especie === 'gata' || $mascota->especie === 'Gato' || $mascota->especie === 'Gata')
                <img src="{{ asset('images/gato.jpg') }}" alt="Gato" class="detalle-mascota-img">
            @else
                <img src="{{ asset('images/default.jpg') }}" alt="Mascota" class="detalle-mascota-img">
            @endif

            <!-- Información de la mascota -->
            <div class="detalle-mascota-info">
                <h2>{{ $mascota->nombre }}</h2>
                <p><strong>Especie:</strong> {{ ucfirst($mascota->especie) }}</p>
                <p><strong>Raza:</strong> {{ $mascota->raza }}</p>
                <p><strong>Edad:</strong> {{ $mascota->edad }} años</p>
                <p><strong>Descripción:</strong> {{ $mascota->descripcion }}</p>
                <p><strong>Estado:</strong> {{ ucfirst($estados[$mascota->estado]) }}</p>
            </div>
        </div>

        <!-- Botón para volver -->
        <a href="{{ route('mascota.index') }}" class="btn btn-volver">Volver al Listado</a>
    </div>
</body>
</html>
