<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Usuarios</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Menú -->
    @include('partials.menu')

    <!-- Título -->
    <header class="container">
        <h1>Listado de Usuarios</h1>
    </header>

    <!-- Botón Añadir Usuario -->
    <div class="container">
        <a href="{{ route('usuario.showCreateView') }}" class="btn btn-submit">Añadir Usuario</a>
    </div>

    <!-- Lista de Usuarios -->
    <div class="usuarios-container">
        @forelse($usuarios as $usuario)
            <div class="usuario-card">
                <!-- Imagen por defecto -->
                <div class="usuario-img-container">
                    <img src="{{ asset('images/persona.jpg') }}" alt="Usuario" class="usuario-img">
                </div>

                <!-- Información del Usuario -->
                <div class="usuario-info">
                    <h2>{{ $usuario->name }}</h2>
                    <p><strong>Email:</strong> {{ $usuario->email }}</p>
                    <p><strong>Dirección:</strong> {{ $usuario->direccion }}</p>
                    <p><strong>Teléfono:</strong> {{ $usuario->telefono }}</p>

                    <!-- Acciones -->
                    <div class="acciones">
                        <a href="{{ route('usuario.show', ['id' => $usuario->id]) }}" class="btn btn-ver">Ver Detalle</a>
                        <a href="{{ route('usuario.showUpdateView', ['id' => $usuario->id]) }}" class="btn btn-editar">Editar</a>
                        <form action="{{ route('usuario.delete', ['id' => $usuario->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-borrar">Borrar</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p style="text-align:center;">No hay usuarios registrados.</p>
        @endforelse
    </div>
</body>
</html>
