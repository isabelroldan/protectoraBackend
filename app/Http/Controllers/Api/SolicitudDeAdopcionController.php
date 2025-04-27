<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SolicitudDeAdopcion;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Solicitudes de Adopción",
 *     description="Operaciones relacionadas con las solicitudes de adopción"
 * )
 */
class SolicitudDeAdopcionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/solicitudes",
     *     tags={"Solicitudes de Adopción"},
     *     summary="Listar todas las solicitudes de adopción",
     *     @OA\Response(
     *         response=200,
     *         description="Listado de solicitudes de adopción"
     *     )
     * )
     */
    public function index()
    {
        $solicitudes = SolicitudDeAdopcion::with(['usuario', 'mascota'])->get();

        return response()->json($solicitudes, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/solicitudes",
     *     tags={"Solicitudes de Adopción"},
     *     summary="Crear una nueva solicitud de adopción",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"usuario_id","mascota_id","fecha_solicitud","estado"},
     *             @OA\Property(property="usuario_id", type="integer", example=1),
     *             @OA\Property(property="mascota_id", type="integer", example=1),
     *             @OA\Property(property="fecha_solicitud", type="string", format="date", example="2025-05-01"),
     *             @OA\Property(property="estado", type="string", enum={"pendiente", "aprobada", "rechazada"}, example="pendiente"),
     *             @OA\Property(property="comentario", type="string", example="Me encantaría adoptar a esta mascota")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Solicitud de adopción creada"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'mascota_id' => 'required|exists:mascotas,id',
            'fecha_solicitud' => 'required|date',
            'estado' => 'required|string|in:pendiente,aprobada,rechazada',
            'comentario' => 'nullable|string',
        ]);

        $solicitud = SolicitudDeAdopcion::create($validated);

        return response()->json($solicitud, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/solicitudes/{id}",
     *     tags={"Solicitudes de Adopción"},
     *     summary="Obtener una solicitud de adopción específica",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la solicitud de adopción",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles de la solicitud de adopción"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Solicitud no encontrada"
     *     )
     * )
     */
    public function show($id)
    {
        $solicitud = SolicitudDeAdopcion::with(['usuario', 'mascota'])->find($id);

        if (!$solicitud) {
            return response()->json(['message' => 'Solicitud no encontrada'], 404);
        }

        return response()->json($solicitud, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/solicitudes/{id}",
     *     tags={"Solicitudes de Adopción"},
     *     summary="Actualizar una solicitud de adopción",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la solicitud a actualizar",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="usuario_id", type="integer", example=1),
     *             @OA\Property(property="mascota_id", type="integer", example=1),
     *             @OA\Property(property="fecha_solicitud", type="string", format="date", example="2025-05-01"),
     *             @OA\Property(property="estado", type="string", enum={"pendiente", "aprobada", "rechazada"}, example="aprobada"),
     *             @OA\Property(property="comentario", type="string", example="Comentario actualizado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Solicitud de adopción actualizada"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Solicitud no encontrada"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $solicitud = SolicitudDeAdopcion::find($id);

        if (!$solicitud) {
            return response()->json(['message' => 'Solicitud no encontrada'], 404);
        }

        $validated = $request->validate([
            'usuario_id' => 'exists:users,id',
            'mascota_id' => 'exists:mascotas,id',
            'fecha_solicitud' => 'date',
            'estado' => 'string|in:pendiente,aprobada,rechazada',
            'comentario' => 'nullable|string',
        ]);

        $solicitud->update($validated);

        return response()->json($solicitud, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/solicitudes/{id}",
     *     tags={"Solicitudes de Adopción"},
     *     summary="Eliminar una solicitud de adopción",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la solicitud a eliminar",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Solicitud de adopción eliminada"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Solicitud no encontrada"
     *     )
     * )
     */
    public function destroy($id)
    {
        $solicitud = SolicitudDeAdopcion::find($id);

        if (!$solicitud) {
            return response()->json(['message' => 'Solicitud no encontrada'], 404);
        }

        $solicitud->delete();

        return response()->json(['message' => 'Solicitud eliminada'], 200);
    }
}
