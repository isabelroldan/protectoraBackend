<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mascota;
use Illuminate\Http\Request;

class MascotaController extends Controller
{
    /**
     * Devuelve la lista de todas las mascotas en formato JSON con un codigo 200
     */
    public function index()
    {
        return response()->json(Mascota::all(), 200); 
    }

    /**
     * Almacena una nueva mascota en la base de datos
     * Devuelve la mascota que se ha creado con el codigo 201 (Created)
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
     * Muestra los detalles de una mascota específica por su ID con un código 200
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
     * Actualiza los datos de una mascota existente
     * Devuelve la mascota modificada con un 200
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
     * Elimina una mascota de la base de datos
     * Devuelve un 200 si el proceso se ha completado con éxito.
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
