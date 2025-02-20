<!--<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />

    <title>El título de mi página</title>
    <link rel="stylesheet" href="style.css" />
  </head>

  <body>
    <h1>Mascotitas</h1>
    
    <button><a href="{{route("mascota.showCreateView" )}}">Añadir mascota</a></button>

    <ul>
        @forelse($mascotas as $mascota)
            <li>{{$mascota->nombre}} -- Edad: {{$mascota->edad}} años {{$mascota->especie}} Acciones 
              <button><a href="{{route("mascota.show",['id' => $mascota->id] )}}">Ver detalle</a></button>
              <button><a href="{{route("mascota.showUpdateView",['id' => $mascota->id] )}}">Editar</a></button>
              <form action="{{ route('mascota.delete', $mascota->id) }}" method="POST">
                  @csrf
                  @method('delete')
                  <button type="submit" class="btn btn-outline-danger">Borrar</button>
              </form>
            </li> 
        @empty
            <li>La lista de perritos esta vacía</li>   
        @endforelse  
    </ul>
  </body>
</html>-->


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Mascotas</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Menú -->
    @include('partials.menu')

    <!-- Título -->
    <header class="container">
        <h1>Listado de Mascotas</h1>
    </header>

    <!-- Lista de Mascotas -->
    <div class="mascotas-container">
        @forelse($mascotas as $mascota)
            <div class="mascota-card">
                <!-- Imagen según especie -->
                @if($mascota->especie === 'perro' || $mascota->especie === 'perra' || $mascota->especie === 'Perro' || $mascota->especie === 'Perra')
                    <div class="mascota-img-container">
                        <img src="{{ asset('images/perro.jpg') }}" alt="Perro" class="mascota-img">
                    </div>
                @elseif($mascota->especie === 'gato' || $mascota->especie === 'gata' || $mascota->especie === 'Gato' || $mascota->especie === 'Gata')
                    <div class="mascota-img-container">
                        <img src="{{ asset('images/gato.jpg') }}" alt="Gato" class="mascota-img">
                    </div>
                @else
                    <div class="mascota-img-container">
                        <img src="{{ asset('images/default.jpg') }}" alt="Mascota" class="mascota-img">
                    </div>
                @endif

                <!-- Información de la mascota -->
                <div class="mascota-info">
                    <h2>{{ $mascota->nombre }}</h2>
                    <p><strong>Especie:</strong> {{ ucfirst($mascota->especie) }}</p>
                    <p><strong>Raza:</strong> {{ $mascota->raza }}</p>
                    <p><strong>Edad:</strong> {{ $mascota->edad }} años</p>
                    <p><strong>Descripción:</strong> {{ $mascota->descripcion }}</p>
                    <p><strong>Estado:</strong> {{ ucfirst($mascota->estado) }}</p>

                    <!-- Acciones -->
                    <div class="acciones">
                        <a href="{{ route('mascota.show', ['id' => $mascota->id]) }}" class="btn btn-ver">Ver Detalle</a>
                        <a href="{{ route('mascota.showUpdateView', ['id' => $mascota->id]) }}" class="btn btn-editar">Editar</a>
                        <form action="{{ route('mascota.delete', ['id' => $mascota->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-borrar">Borrar</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p style="text-align:center;">No hay mascotas registradas.</p>
        @endforelse
    </div>
</body>
</html>

