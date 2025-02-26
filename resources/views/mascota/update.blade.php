<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Mascota</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Menú -->
    @include('partials.menu')

    <!-- Título -->
    <header class="container">
        <h1>Editar Mascota</h1>
    </header>

    <!-- Formulario -->
    <div class="form-container">
        <form action="{{ route('mascota.update', $mascota->id) }}" method="post" class="form">
            @csrf

            <!-- Nombre -->
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="{{ $mascota->nombre }}">
            @error('nombre')
                <span class="error">{{ $message }}</span>
            @enderror

            <!-- Especie -->
            <label for="especie">Especie:</label>
            <input type="text" id="especie" name="especie" value="{{ $mascota->especie }}">
            @error('especie')
                <span class="error">{{ $message }}</span>
            @enderror

            <!-- Raza -->
            <label for="raza">Raza:</label>
            <input type="text" id="raza" name="raza" value="{{ $mascota->raza }}">
            @error('raza')
                <span class="error">{{ $message }}</span>
            @enderror

            <!-- Edad -->
            <label for="edad">Edad:</label>
            <input type="number" id="edad" name="edad" value="{{ $mascota->edad }}">
            @error('edad')
                <span class="error">{{ $message }}</span>
            @enderror

            <!-- Descripción -->
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="3">{{ $mascota->descripcion }}</textarea>
            @error('descripcion')
                <span class="error">{{ $message }}</span>
            @enderror

            <!-- Estado -->
            <label for="estado">Estado:</label>
            <select id="estado" name="estado">
                @foreach($estados as $clave => $estado)
                    <option value="{{ $clave }}" @selected($mascota->estado == $clave)>{{ $estado }}</option>
                @endforeach
            </select>
            @error('estado')
                <span class="error">{{ $message }}</span>
            @enderror

            <!-- Botón de Enviar -->
            <button type="submit" class="btn-submit">Modificar Mascota</button>

        </form>

        <!-- Botón para volver -->
        <a href="{{ route('mascota.index') }}" class="btn btn-volver">Volver al Listado</a>
    </div>
</body>
</html>
