<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SolicitudDeAdopcion;
use Illuminate\Http\Request;

class SolicitudDeAdopcionController extends Controller
{
    public function index()
    {
        $solicitudes = SolicitudDeAdopcion::with(['usuario', 'mascota'])->get();
        
        return response()->json($solicitudes, 200);
    }

    
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

    public function show($id)
    {
        $solicitud = SolicitudDeAdopcion::with(['usuario', 'mascota'])->find($id);

        if (!$solicitud) {
            return response()->json(['message' => 'Solicitud no encontrada'], 404);
        }

        return response()->json($solicitud, 200);
    }

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
