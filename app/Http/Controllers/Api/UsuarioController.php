<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UsuarioController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/usuarios",
     *     summary="Lista todos los usuarios",
     *     description="Devuelve todos los usuarios registrados en la base de datos.",
     *     operationId="listarUsuarios",
     *     tags={"Usuarios"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Listado de usuarios obtenido exitosamente."
     *     )
     * )
     */
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    /**
     * @OA\Get(
     *     path="/api/usuarios/paginados",
     *     summary="Obtener usuarios paginados con opción de búsqueda",
     *     tags={"Usuarios"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Número de página",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Cantidad de usuarios por página",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Texto de búsqueda (nombre, email, dirección o teléfono)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuarios paginada y/o filtrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="current_page", type="integer"),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="email", type="string"),
     *                 @OA\Property(property="direccion", type="string"),
     *                 @OA\Property(property="telefono", type="string"),
     *                 @OA\Property(property="rol", type="string"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )),
     *             @OA\Property(property="last_page", type="integer"),
     *             @OA\Property(property="per_page", type="integer"),
     *             @OA\Property(property="total", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Acceso denegado (solo administradores)"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor"
     *     )
     * )
     */
    public function paginated(Request $request)
    {
        $perPage = 12;
        $search = $request->get('search');

        $query = User::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('direccion', 'like', "%$search%")
                    ->orWhere('telefono', 'like', "%$search%");
            });
        }

        return response()->json($query->paginate($perPage), 200);
    }



    /**
     * @OA\Post(
     *     path="/api/usuarios",
     *     summary="Crear un nuevo usuario",
     *     description="Crea y almacena un nuevo usuario.",
     *     operationId="crearUsuario",
     *     tags={"Usuarios"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password","direccion","telefono"},
     *             @OA\Property(property="name", type="string", example="Juan Pérez"),
     *             @OA\Property(property="email", type="string", example="juan@example.com"),
     *             @OA\Property(property="password", type="string", example="password123"),
     *             @OA\Property(property="direccion", type="string", example="Calle Falsa 123"),
     *             @OA\Property(property="telefono", type="string", example="123456789")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuario creado exitosamente."
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación."
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'direccion' => 'required|string',
            'telefono' => 'required|string',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $usuario = User::create($validated);

        return response()->json($usuario, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/usuarios/{id}",
     *     summary="Mostrar un usuario",
     *     description="Devuelve los detalles de un usuario específico.",
     *     operationId="mostrarUsuario",
     *     tags={"Usuarios"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del usuario",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Datos del usuario."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado."
     *     )
     * )
     */
    public function show($id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json($usuario, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/usuarios/{id}",
     *     summary="Actualizar un usuario",
     *     description="Actualiza los datos de un usuario existente.",
     *     operationId="actualizarUsuario",
     *     tags={"Usuarios"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del usuario a actualizar",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Juan Actualizado"),
     *             @OA\Property(property="email", type="string", example="juanactualizado@example.com"),
     *             @OA\Property(property="password", type="string", example="newpassword123"),
     *             @OA\Property(property="direccion", type="string", example="Calle Nueva 456"),
     *             @OA\Property(property="telefono", type="string", example="987654321")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario actualizado exitosamente."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado."
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $validated = $request->validate([
            'name' => 'string|max:255',
            'email' => "email|unique:users,email,$id",
            'direccion' => 'string',
            'telefono' => 'string',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $usuario->update($validated);

        return response()->json($usuario, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/usuarios/{id}",
     *     summary="Eliminar un usuario",
     *     description="Elimina un usuario de la base de datos.",
     *     operationId="eliminarUsuario",
     *     tags={"Usuarios"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del usuario a eliminar",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario eliminado exitosamente."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado."
     *     )
     * )
     */
    public function destroy($id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $usuario->delete();

        return response()->json(['message' => 'Usuario eliminado'], 200);
    }
}
