<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SolicitudDeAdopcion;
use Illuminate\Http\Request;

class SolicitudDeAdopcionController extends Controller
{
    /**
     * Devuelve la lista de todas las solicitudes de adopción con sus relaciones de usuario y mascota
     */
    public function index()
    {
        $solicitudes = SolicitudDeAdopcion::with(['usuario', 'mascota'])->get();

        return response()->json($solicitudes, 200);
    }

    /**
     * Almacena una nueva solicitud de adopción
     * Devuelve un 201, Created
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
     * Muestra los detalles de una solicitud específica por su Id
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
     * Actualiza los datos de una solicitud de adopción existente
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
     * Elimina una solicitud de adopción de la base de datos.
     */
    public function destroy($id)
    {
        $solicitud = SolicitudDeAdopcion::find($id);

        if (!$solicitud) {
            return response()->json(['message' => 'Solicitud no encontrada'], 404);
        }

        $solicitud->delete(); //Lo elimina

        return response()->json(['message' => 'Solicitud eliminada'], 200);
    }
}
