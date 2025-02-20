<!--<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />

    <title>El título de mi página</title>
    <link rel="stylesheet" href="style.css" />
  </head>

  <body>
    <h1>Usuario</h1>

    <form action="{{route("usuario.create" )}}" method="post">
    @csrf
    
    <label for="nombre">Nombre: </label>
    <input type="text" id="nombre" name="nombre"><br/>

    @error('nombre')
    <span style="color:red">{{ $message }}</span><br/>
    @enderror

    <label for="email">Email: </label>
    <input type="text" id="email" name="email"><br/>

    @error('email')
    <span style="color:red">{{ $message }}</span><br/>
    @enderror
    

    <label for="direccion">Dirección: </label>
    <input type="text" id="direccion" name="direccion"><br/>

    @error('direccion')
    <span style="color:red">{{ $message }}</span><br/>
    @enderror

    <label for="telefono">Teléfono: </label>
    <textarea id="telefono" name="telefono" rows="3"></textarea><br/>

    @error('telefono')
    <span style="color:red">{{ $message }}</span><br/>
    @enderror

    <button type="submit">Crear</button>

</form>
  </body>
</html>-->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Usuario</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Menú -->
    @include('partials.menu')

    <!-- Título -->
    <header class="container">
        <h1>Crear Nuevo Usuario</h1>
    </header>

    <!-- Formulario -->
    <div class="form-container">
        <form action="{{ route('usuario.create') }}" method="post" class="form">
            @csrf

            <!-- Nombre -->
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}">
            @error('nombre')
                <span class="error">{{ $message }}</span>
            @enderror

            <!-- Email -->
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" value="{{ old('email') }}">
            @error('email')
                <span class="error">{{ $message }}</span>
            @enderror

            <!-- Dirección -->
            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" value="{{ old('direccion') }}">
            @error('direccion')
                <span class="error">{{ $message }}</span>
            @enderror

            <!-- Teléfono -->
            <label for="telefono">Teléfono:</label>
            <textarea id="telefono" name="telefono" rows="3">{{ old('telefono') }}</textarea>
            @error('telefono')
                <span class="error">{{ $message }}</span>
            @enderror

            <!-- Botón de Enviar -->
            <button type="submit" class="btn-submit">Crear Usuario</button>
        </form>

        <!-- Botón para volver -->
        <a href="{{ route('usuario.index') }}" class="btn btn-volver">Volver al Listado</a>
    </div>
</body>
</html>
