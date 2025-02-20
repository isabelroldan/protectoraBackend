<!--<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />

    <title>El título de mi página</title>
    <link rel="stylesheet" href="style.css" />
  </head>

  <body>
    <h1>Mascota</h1>
    <form action="#" method="post">
    <label for="nombre"></label>
    <input type="text" id="nombre" name="nombre" value="{{$mascota->nombre}}" disabled>

    <label for="especie"></label>
    <input type="text" id="especie" name="especie" value="{{$mascota->especie}}" disabled>

    <label for="raza"></label>
    <input type="text" id="raza" name="raza" value="{{$mascota->raza}}" disabled>

    <label for="edad"></label>
    <input type="number" id="edad" name="edad" value="{{$mascota->edad}}" disabled>

    <label for="descripcion"></label>
    <textarea id="descripcion" name="descripcion" rows="3"  disabled>{{$mascota->descripcion}}</textarea>

    <label for="estado"></label>
    <select id="estado" name="estado" disabled>
    @foreach($estados as $clave => $estado)
        <option value="{{$clave}}" @selected($mascota->estado == $clave)>{{$estado}}</option>
        @endforeach
    </select>

</form>
  </body>
</html>-->

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
