<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Solicitud de Adopción</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Menú -->
    @include('partials.menu')

    <!-- Título -->
    <header class="container">
        <h1>Crear Nueva Solicitud de Adopción</h1>
    </header>

    <!-- Formulario -->
    <div class="form-container">
        <form action="{{ route('solicitud.create') }}" method="post" class="form">
            @csrf

            <!-- Usuario -->
            <label for="usuario_id">Usuario:</label>
            <select id="usuario_id" name="usuario_id">
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" {{ old('usuario_id') == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->nombre }}
                    </option>
                @endforeach
            </select>
            @error('usuario_id')
                <span class="error">{{ $message }}</span>
            @enderror

            <!-- Mascota -->
            <label for="mascota_id">Mascota:</label>
            <select id="mascota_id" name="mascota_id">
                @foreach($mascotas as $mascota)
                    <option value="{{ $mascota->id }}" {{ old('mascota_id') == $mascota->id ? 'selected' : '' }}>
                        {{ $mascota->nombre }}
                    </option>
                @endforeach
            </select>
            @error('mascota_id')
                <span class="error">{{ $message }}</span>
            @enderror

            <!-- Fecha de Solicitud -->
            <label for="fecha_solicitud">Fecha de Solicitud:</label>
            <input type="date" id="fecha_solicitud" name="fecha_solicitud" value="{{ old('fecha_solicitud') }}">
            @error('fecha_solicitud')
                <span class="error">{{ $message }}</span>
            @enderror

            <!-- Estado -->
            <label for="estado">Estado:</label>
            <select id="estado" name="estado">
                @foreach($estados as $clave => $estado)
                    <option value="{{ $clave }}" {{ old('estado') == $clave ? 'selected' : '' }}>
                        {{ ucfirst($estado) }}
                    </option>
                @endforeach
            </select>
            @error('estado')
                <span class="error">{{ $message }}</span>
            @enderror

            <!-- Comentario -->
            <label for="comentario">Comentario:</label>
            <textarea id="comentario" name="comentario" rows="3">{{ old('comentario') }}</textarea>
            @error('comentario')
                <span class="error">{{ $message }}</span>
            @enderror

            <!-- Botón de Enviar -->
            <button type="submit" class="btn-submit">Crear Solicitud</button>
        </form>

        <!-- Botón Volver -->
        <a href="{{ route('solicitud.index') }}" class="btn btn-volver">Volver al Listado</a>
    </div>
</body>
</html>
