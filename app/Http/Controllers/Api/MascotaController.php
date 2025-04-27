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
     *     summary="Obtener mascotas paginadas",
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
     *     @OA\Response(
     *         response=200,
     *         description="Lista de mascotas paginada"
     *     )
     * )
     */
    public function paginated(Request $request)
    {
        $perPage = $request->get('per_page', 10); // Por defecto 10 por página
        $mascotas = Mascota::paginate($perPage);

        return response()->json($mascotas, 200);
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
