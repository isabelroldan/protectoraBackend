<!--<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />

    <title>El título de mi página</title>
    <link rel="stylesheet" href="style.css" />
  </head>

  <body>
    <h1>Usuario</h1>
    <form action="{{route("usuario.update", $usuario->id )}}" method="post">
    @csrf
    
    <label for="nombre">Nombre: </label>
    <input type="text" id="nombre" name="nombre" value="{{$usuario->nombre}}"> <br/>

    @error('nombre')
    <span style="color:red">{{ $message }}</span><br/>
    @enderror

    <label for="email"></label>
    <input type="text" id="email" name="email" value="{{$usuario->email}}"><br/>

    @error('email')
    <span style="color:red">{{ $message }}</span><br/>
    @enderror

    <label for="direccion"></label>
    <input type="text" id="direccion" name="direccion" value="{{$usuario->direccion}}"><br/>

    @error('direccion')
    <span style="color:red">{{ $message }}</span><br/>
    @enderror

    <label for="telefono"></label>
    <textarea id="telefono" name="telefono" rows="3">{{$usuario->telefono}}</textarea><br/>

    @error('telefono')
    <span style="color:red">{{ $message }}</span><br/>
    @enderror

    <button type="submit">Modificar</button>

</form>
  </body>
</html>-->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Menú -->
    @include('partials.menu')

    <!-- Título -->
    <header class="container">
        <h1>Editar Usuario</h1>
    </header>

    <!-- Formulario -->
    <div class="form-container">
        <form action="{{ route('usuario.update', $usuario->id) }}" method="post" class="form">
            @csrf

            <!-- Nombre -->
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" value="{{ $usuario->name }}">
            @error('name')
                <span class="error">{{ $message }}</span>
            @enderror

            <!-- Email -->
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" value="{{ $usuario->email }}">
            @error('email')
                <span class="error">{{ $message }}</span>
            @enderror

            <label for="password">Contraseña:</label>
            <input type="text" id="password" name="password" value="{{ old('password') }}">
            @error('password')
                <span class="error">{{ $message }}</span>
            @enderror

            <!-- Dirección -->
            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" value="{{ $usuario->direccion }}">
            @error('direccion')
                <span class="error">{{ $message }}</span>
            @enderror

            <!-- Teléfono -->
            <label for="telefono">Teléfono:</label>
            <textarea id="telefono" name="telefono" rows="3">{{ $usuario->telefono }}</textarea>
            @error('telefono')
                <span class="error">{{ $message }}</span>
            @enderror

            <!-- Botón de Enviar -->
            <button type="submit" class="btn-submit">Modificar Usuario</button>

        </form>

        <!-- Botón para volver -->
        <a href="{{ route('usuario.index') }}" class="btn btn-volver">Volver al Listado</a>
    </div>
</body>
</html>
