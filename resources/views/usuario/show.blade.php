<!--<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />

    <title>El título de mi página</title>
    <link rel="stylesheet" href="style.css" />
  </head>

  <body>
    <h1>uSUARIO</h1>

    <form action="#" method="post">
        <label for="nombre"></label>
        <input type="text" id="nombre" name="nombre" value="{{$usuario->nombre}}" disabled>

        <label for="email"></label>
        <input type="text" id="email" name="email" value="{{$usuario->email}}" disabled>

        <label for="direccion"></label>
        <input type="text" id="direccion" name="direccion" value="{{$usuario->direccion}}" disabled>

        <label for="telefono"></label>
        <textarea id="telefono" name="telefono" rows="3"  disabled>{{$usuario->telefono}}</textarea>

    </form>
    
  </body>
</html>-->

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
