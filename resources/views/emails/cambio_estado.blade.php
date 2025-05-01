<!DOCTYPE html>
<!--<html>
<head>
    <meta charset="UTF-8">
    <title>Cambio de Estado</title>
</head>
<body>
    <h1>¡Hola {{ $solicitud->usuario->name }}!</h1>

    <p>El estado de tu solicitud de adopción para la mascota <strong>{{ $solicitud->mascota->nombre }}</strong> ha cambiado a: 
        <strong>{{ ucfirst($solicitud->estado) }}</strong>.
    </p>

    @if($solicitud->comentario)
        <p>Comentario adicional: {{ $solicitud->comentario }}</p>
    @endif

    <p>Gracias por confiar en nuestra protectora. ❤️</p>
</body>
</html>-->

<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambio de Estado de Solicitud</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fafafa;
            padding: 20px;
        }

        .detalle-solicitud-container {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        .detalle-solicitud-card {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            background-color: #fff;
            border: 2px solid #FFC382;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .mascota-img-container {
            flex: 1 1 250px;
            text-align: center;
        }

        .mascota-img-container img {
            max-width: 100%;
            border-radius: 10px;
        }

        .detalle-solicitud-info {
            flex: 2 1 400px;
            margin-left: 20px;
            text-align: left;
        }

        .detalle-solicitud-info h2 {
            font-size: 1.8rem;
            color: #FFC382;
            margin-bottom: 10px;
        }

        .detalle-solicitud-info p {
            margin: 8px 0;
        }

        .mensaje-estado {
            margin-top: 30px;
            padding: 15px;
            background-color: #ffe2c4;
            border-left: 5px solid #ffc382;
            border-radius: 8px;
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <div class="detalle-solicitud-container">
        <h1>¡Hola {{ $solicitud->usuario->name }}!</h1>

        <div class="detalle-solicitud-card">
            <!-- Imagen según especie -->
            <div class="mascota-img-container">
                @php
                    $especie = strtolower($solicitud->mascota->especie);
                    $imagen = match($especie) {
                        'perro', 'perra' => 'https://res.cloudinary.com/dbu0imtjv/image/upload/v1746095461/perro_ru5ldf.jpg',
                        'gato', 'gata' => 'https://res.cloudinary.com/dbu0imtjv/image/upload/v1746095452/gato_vps6tn.jpg',
                        default => 'https://res.cloudinary.com/dbu0imtjv/image/upload/v1746095438/default_qxxpkd.jpg',
                    };
                @endphp
                <img src="{{ $imagen }}" alt="Mascota">
            </div>

            <!-- Información -->
            <div class="detalle-solicitud-info">
                <h2>{{ $solicitud->mascota->nombre }}</h2>
                <p><strong>Especie:</strong> {{ ucfirst($solicitud->mascota->especie) }}</p>
                <p><strong>Estado de la solicitud:</strong> {{ ucfirst($solicitud->estado) }}</p>
                <!-- @if($solicitud->comentario)
                    <p><strong>Comentario adicional:</strong> {{ $solicitud->comentario }}</p>
                @endif -->
            </div>
        </div>

        <!-- Mensaje personalizado según estado -->
        <div class="mensaje-estado">
            @if($solicitud->estado === 'pendiente')
                Tu solicitud está siendo evaluada por nuestro equipo. Te informaremos pronto del resultado. ¡Gracias por tu interés en adoptar y por apoyar nuestra causa! 🐾
            @elseif($solicitud->estado === 'aprobada')
                ¡Felicidades! Tu solicitud ha sido aprobada. Pronto nos pondremos en contacto contigo para los próximos pasos. Gracias por darle una oportunidad a una vida mejor. ❤️
            @elseif($solicitud->estado === 'rechazada')
                Lamentamos informarte que tu solicitud no ha sido aprobada. Agradecemos sinceramente tu interés y te animamos a seguir participando en futuras oportunidades de adopción. 🐶🐱
            @else
                El estado de tu solicitud ha cambiado. Si tienes dudas, puedes contactarnos directamente.
            @endif
        </div>
    </div>
</body>
</html>
