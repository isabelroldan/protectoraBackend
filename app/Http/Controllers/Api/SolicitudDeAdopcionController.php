<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\CambioEstadoSolicitud;
use App\Models\SolicitudDeAdopcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
     * @OA\Get(
     *     path="/solicitudes/paginadas",
     *     summary="Obtener solicitudes de adopción paginadas y filtradas",
     *     tags={"Solicitudes"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Número de página para paginación",
     *         required=false,
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Parameter(
     *         name="perPage",
     *         in="query",
     *         description="Número de elementos por página (siempre será 12)",
     *         required=false,
     *         @OA\Schema(type="integer", default=12, enum={12})
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Término de búsqueda para filtrar por usuario, mascota, estado o fecha (fecha en formato dd/mm/yyyy, dd-mm-yyyy o fragmentos de fecha como números)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista paginada de solicitudes",
     *         @OA\JsonContent(
     *             @OA\Property(property="current_page", type="integer"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/SolicitudDeAdopcion")
     *             ),
     *             @OA\Property(property="last_page", type="integer"),
     *             @OA\Property(property="per_page", type="integer"),
     *             @OA\Property(property="total", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=401, description="No autorizado")
     * )
     */
    public function paginated(Request $request)
    {
        $perPage = 12;
        $search = $request->input('search');

        // Detectar si search es fecha en formato dd/mm/yyyy o dd-mm-yyyy para convertirla a yyyy-mm-dd
        $fechaFormateada = null;
        if ($search) {
            if (preg_match('/^(\d{2})[\/\-](\d{2})[\/\-](\d{4})$/', $search, $matches)) {
                $fechaFormateada = $matches[3] . '-' . $matches[2] . '-' . $matches[1];
            }
        }

        $query = SolicitudDeAdopcion::with(['usuario', 'mascota'])
            ->when($search, function ($q) use ($search, $fechaFormateada) {
                $q->where(function ($subQuery) use ($search, $fechaFormateada) {
                    $subQuery->whereHas('usuario', function ($q2) use ($search) {
                        $q2->where('name', 'like', '%' . $search . '%');
                    })
                        ->orWhereHas('mascota', function ($q3) use ($search) {
                            $q3->where('nombre', 'like', '%' . $search . '%');
                        });

                    // Si es fecha exacta transformada, buscar por fecha exacta
                    if ($fechaFormateada) {
                        $subQuery->orWhereDate('fecha_solicitud', $fechaFormateada);
                    }

                    // Además buscar en la fecha_solicitud si contiene el número o texto (como string)
                    // Esto permite buscar por fragmentos como "16" dentro de la fecha (YYYY-MM-DD)
                    $subQuery->orWhere('fecha_solicitud', 'like', '%' . $search . '%');

                    // Buscar por estado parcialmente también
                    $subQuery->orWhere('estado', 'like', '%' . $search . '%');
                });
            });

        return response()->json($query->paginate($perPage), 200);
    }


    /**
     * @OA\Get(
     *     path="/api/mis-solicitudes",
     *     tags={"Solicitudes de Adopción"},
     *     summary="Obtener las solicitudes del usuario autenticado",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de solicitudes del usuario autenticado"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado"
     *     )
     * )
     */
    public function misSolicitudes(Request $request)
    {
        $usuario = $request->user();

        $solicitudes = SolicitudDeAdopcion::with(['usuario', 'mascota'])
            ->where('usuario_id', $usuario->id)
            ->get();

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

        // Cargar las relaciones necesarias (usuario, mascota)
        $solicitud->load('usuario', 'mascota');
        /** @var \App\Models\SolicitudDeAdopcion $solicitud */


        //dd($solicitud->usuario->email);
        // Enviar email
        Mail::to($solicitud->usuario->email)->send(new CambioEstadoSolicitud(solicitud: $solicitud));

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
