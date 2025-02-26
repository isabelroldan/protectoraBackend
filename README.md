# Proyecto de Adopción de Mascotas

## Índice
1. [Introducción](#introducción)
2. [Requisitos](#requisitos)
3. [Instalación](#instalación)
4. [Estructura del Proyecto](#estructura-del-proyecto)
5. [Base de Datos](#base-de-datos)
   - [Migraciones](#migraciones)
   - [Modelos](#modelos)
   - [Seeders](#seeders)
   - [Factories](#factories)
6. [Controladores](#controladores)
   - [Controladores Web](#controladores-web)
   - [Controladores API](#controladores-api)
7. [Vistas](#vistas)
8. [Rutas](#rutas)
9. [Autenticación](#autenticación)
10. [Tests](#tests)

## Introducción

Este proyecto es una plataforma de adopción de mascotas desarrollada con Laravel. Permite a los usuarios ver mascotas disponibles para adopción, hacer solicitudes de adopción y a los administradores gestionar todo el proceso.

## Requisitos

- PHP >= 7.4
- Composer
- SQLite


## Instalación

1. Clonar el repositorio:
git clone https://github.com/tu-usuario/proyecto-adopcion-mascotas.git


2. Instalar dependencias de PHP:
composer install


3. Copiar el archivo de configuración:
cp .env.example .env


4. Generar clave de aplicación:
php artisan key:generate


5. Configurar la base de datos en el archivo `.env`


6. Ejecutar migraciones y seeders:
php artisan migrate --seed


7. Iniciar el servidor de desarrollo:
php artisan serve

Otra forma es, que si tienes Docker instalado, descargues los dos Dockerfile y el docker-compose y ejecutes el comando en una terminal dentro de la ruta donde te lo has descargado "docker compose up". De esta forma tendrás tanto el frontend (React) como el backend (Laravel) que los clonará directamente de sus respectivos repositorios de GitHub y ahorá todo lo necesario para que sean funcionales, como poblar la base de datos con los seeder. Para iniciar sesión en el frontend con React te pedirá un usuario y contraseña que puedes usar "isabelroldancordoba@hotmail.com" como usuario y como contraseña "password".


## Estructura del Proyecto

El proyecto sigue la estructura estándar de Laravel, con algunas carpetas adicionales:

- `app/`: Contiene el código principal de la aplicación
- `Http/Controllers/`: Controladores de la aplicación
- `Http/Controllers/Api/`: Controladores para la API
- `Models/`: Modelos de Eloquent
- `database/`: Contiene migraciones, factories y seeders
- `resources/`: Contiene vistas, assets y archivos de lenguaje
- `routes/`: Contiene archivos de definición de rutas
- `tests/`: Contiene los tests automatizados

## Base de Datos

### Migraciones

Las migraciones se encuentran en `database/migrations/`. Definen la estructura de la base de datos. Principales migraciones:

- `create_users_table.php`: Tabla de usuarios
- `create_mascotas_table.php`: Tabla de mascotas
- `create_solicitud_de_adopciones_table.php`: Tabla de solicitudes de adopción

Para ejecutar las migraciones:
php artisan migrate


### Modelos

Los modelos se encuentran en `app/Models/`. Representan las tablas de la base de datos y definen las relaciones entre ellas:

- `User.php`: Modelo de usuario
- `Mascota.php`: Modelo de mascota
- `SolicitudDeAdopcion.php`: Modelo de solicitud de adopción

### Seeders

Los seeders se utilizan para poblar la base de datos con datos de prueba. Se encuentran en `database/seeders/`:

- `DatabaseSeeder.php`: Seeder principal que llama a los demás seeders
- `UserSeeder.php`: Crea usuarios de prueba
- `MascotaSeeder.php`: Crea mascotas de prueba
- `SolicitudDeAdopcionSeeder.php`: Crea solicitudes de adopción de prueba

Para ejecutar los seeders:
php artisan db:seed


### Factories

Los factories se utilizan para generar datos de prueba. Se encuentran en `database/factories/`:

- `UserFactory.php`: Factory para crear usuarios
- `MascotaFactory.php`: Factory para crear mascotas
- `SolicitudDeAdopcionFactory.php`: Factory para crear solicitudes de adopción

## Controladores

### Controladores Web

Los controladores web se encuentran en `app/Http/Controllers/`:

- `UsuarioController.php`: Gestiona las operaciones relacionadas con los usuarios
- `MascotaController.php`: Gestiona las operaciones relacionadas con las mascotas
- `SolicitudDeAdopcionController.php`: Gestiona las operaciones relacionadas con las solicitudes de adopción

### Controladores API

Los controladores de la API se encuentran en `app/Http/Controllers/Api/`:

- `UsuarioController.php`: Proporciona endpoints para operaciones CRUD de usuarios
- `MascotaController.php`: Proporciona endpoints para operaciones CRUD de mascotas
- `SolicitudDeAdopcionController.php`: Proporciona endpoints para operaciones CRUD de solicitudes de adopción

## Vistas

Las vistas se encuentran en `resources/views/`. Utilizan Blade como motor de plantillas:

- `layouts/`: Contiene las plantillas base
- `users/`: Vistas relacionadas con los usuarios
- `mascotas/`: Vistas relacionadas con las mascotas
- `solicitudes/`: Vistas relacionadas con las solicitudes de adopción

## Rutas

Las rutas se definen en los archivos dentro de `routes/`:

- `web.php`: Rutas para la interfaz web
- `api.php`: Rutas para la API

## Autenticación

La autenticación se maneja utilizando Laravel Sanctum para la API y el sistema de autenticación predeterminado de Laravel para la interfaz web.

## Tests

Los tests se encuentran en la carpeta `tests/`. Se utilizan PHPUnit y Laravel's testing utilities:

- `Feature/`: Contiene tests de feature que prueban múltiples componentes trabajando juntos
- `Unit/`: Contiene tests unitarios que prueban componentes individuales

Para ejecutar los tests:
php artisan test

