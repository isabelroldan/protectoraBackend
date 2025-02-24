<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mascota;
use Illuminate\Http\Request;

class MascotaController extends Controller
{
    public function index()
    {
        return response()->json(Mascota::all(), 200); 


    }

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

    public function show($id)
    {
        $mascota = Mascota::find($id);

        if (!$mascota) {
            return response()->json(['message' => 'Mascota no encontrada'], 404);
        }

        return response()->json($mascota, 200);
    }

    public function update(Request $request, $id)
    {
        $mascota = Mascota::find($id);

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

    public function destroy($id)
    {
        $mascota = Mascota::find($id);

        if (!$mascota) {
            return response()->json(['message' => 'Mascota no encontrada'], 404);
        }

        $mascota->delete();

        return response()->json(['message' => 'Mascota eliminada'], 200);
    }
}
