<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mascota;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Mascotas",
 *     description="Operaciones relacionadas con mascotas"
 * )
 * @OA\Security(
 *     security={"bearerAuth": {}}
 * )
 */
class MascotaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/mascotas",
     *     summary="Obtener todas las mascotas",
     *     tags={"Mascotas"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de mascotas"
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Mascota::all(), 200);
    }

    /**
     * @OA\Get(
     *     path="/api/mascotas/paginadas",
     *     summary="Obtener mascotas paginadas con opción de búsqueda",
     *     tags={"Mascotas"},
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
     *         description="Cantidad de mascotas por página",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Texto de búsqueda (nombre, especie, raza, estado o edad exacta)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de mascotas paginada y/o filtrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="current_page", type="integer"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Mascota")),
     *             @OA\Property(property="last_page", type="integer"),
     *             @OA\Property(property="per_page", type="integer"),
     *             @OA\Property(property="total", type="integer")
     *         )
     *     )
     * )
     */
    public function paginated(Request $request)
    {
        $perPage = 12;
        $search = $request->get('search');

        $query = Mascota::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%$search%")
                    ->orWhere('especie', 'like', "%$search%")
                    ->orWhere('raza', 'like', "%$search%")
                    ->orWhere('estado', 'like', "%$search%")
                    ->orWhere('edad', $search); // edad exacta
            });
        }

        return response()->json($query->paginate($perPage), 200);
    }





    /**
     * @OA\Post(
     *     path="/api/mascotas",
     *     summary="Crear una nueva mascota",
     *     tags={"Mascotas"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre","especie","raza","edad","descripcion","estado"},
     *             @OA\Property(property="nombre", type="string"),
     *             @OA\Property(property="especie", type="string"),
     *             @OA\Property(property="raza", type="string"),
     *             @OA\Property(property="edad", type="integer"),
     *             @OA\Property(property="descripcion", type="string"),
     *             @OA\Property(property="estado", type="string", enum={"disponible","en proceso de adopción","adoptado"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Mascota creada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos inválidos"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string',
            'especie' => 'required|string',
            'raza' => 'required|string',
            'edad' => 'required|integer',
            'descripcion' => 'required|string',
            'estado' => 'required|string|in:disponible,en proceso de adopción,adoptado'
        ]);

        $mascota = Mascota::create($validated);

        return response()->json($mascota, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/mascotas/{id}",
     *     summary="Obtener una mascota por ID",
     *     tags={"Mascotas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Mascota encontrada"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Mascota no encontrada"
     *     )
     * )
     */
    public function show($id)
    {
        $mascota = Mascota::find($id);

        //Si no  la encuentra devuelve un 404, Not Found
        if (!$mascota) {
            return response()->json(['message' => 'Mascota no encontrada'], 404);
        }

        return response()->json($mascota, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/mascotas/{id}",
     *     summary="Actualizar una mascota",
     *     tags={"Mascotas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string"),
     *             @OA\Property(property="especie", type="string"),
     *             @OA\Property(property="raza", type="string"),
     *             @OA\Property(property="edad", type="integer"),
     *             @OA\Property(property="descripcion", type="string"),
     *             @OA\Property(property="estado", type="string", enum={"disponible","en proceso de adopción","adoptado"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Mascota actualizada"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Mascota no encontrada"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $mascota = Mascota::find($id);

        //Si no  la encuentra devuelve un 404, Not Found
        if (!$mascota) {
            return response()->json(['message' => 'Mascota no encontrada'], 404);
        }

        $validated = $request->validate([
            'nombre' => 'string',
            'especie' => 'string',
            'raza' => 'string',
            'edad' => 'integer',
            'descripcion' => 'string',
            'estado' => 'string|in:disponible,en proceso de adopción,adoptado'
        ]);

        $mascota->update($validated);

        return response()->json($mascota, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/mascotas/{id}",
     *     summary="Eliminar una mascota",
     *     tags={"Mascotas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Mascota eliminada"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Mascota no encontrada"
     *     )
     * )
     */
    public function destroy($id)
    {
        $mascota = Mascota::find($id);

        //Si no  la encuentra devuelve un 404, Not Found
        if (!$mascota) {
            return response()->json(['message' => 'Mascota no encontrada'], 404);
        }

        $mascota->delete(); //Elimina la mascota

        return response()->json(['message' => 'Mascota eliminada'], 200);
    }
}
