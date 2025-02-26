<?php

namespace App\Http\Controllers;

use App\Models\SolicitudDeAdopcion;
use App\Models\Mascota;
use App\Models\User;
use Illuminate\Http\Request;

class SolicitudDeAdopcionController extends Controller
{
    private array $estados; //Lista de estados posibles que puede tner una solicitud de adopción

    /**
     * En el contructor inicializo los estados de una solicitud
     */
    public function __construct()
    {
        $this->estados = [
            'pendiente' => 'Pendiente',
            'aprobada' => 'Aprobada',
            'rechazada' => 'Rechazada'
        ];
    }

    /**
     * Muestra todas las solicitudes de adopción con datos de usuario y mascota
     */
    public function index()
    {
        $solicitudes = SolicitudDeAdopcion::with(['usuario', 'mascota'])->get();
        return view('solicitud.index', ['solicitudes' => $solicitudes]);
    }

    /**
     * Muestra los detalles de una solicitud específica
     */
    public function show($id)
    {
        $solicitud = SolicitudDeAdopcion::with(['usuario', 'mascota'])->findOrFail($id);
        return view('solicitud.show', ['solicitud' => $solicitud, 'estados' => $this->estados]);
    }

    /**
     * Muestra el formulario para crear una nueva solicitud de adopción
     */
    public function showCreateView()
    {
        $usuarios = User::all(); // Obtengo todos los usuarios
        $mascotas = Mascota::all(); // Obtengo todas las mascotas
        $estados = [
            'pendiente' => 'Pendiente',
            'aprobada' => 'Aprobada',
            'rechazada' => 'Rechazada'
        ]; // Estados disponibles, que aceptamos en nuestra base de datos

        return view('solicitud.create', [
            'usuarios' => $usuarios,
            'mascotas' => $mascotas,
            'estados' => $estados
        ]);
    }

    /**
     * Almacena una nueva solicitud de adopción
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'mascota_id' => 'required|exists:mascotas,id',
            'fecha_solicitud' => 'required|date',
            'estado' => 'required|string|in:pendiente,aprobada,rechazada',
            'comentario' => 'nullable|string'
        ]);

        SolicitudDeAdopcion::create($validated);

        return redirect()->route('solicitud.index');
    }

    /**
     * Muestra la vista de actualización de una solicitud
     */
    public function showUpdateView($id)
    {
        $solicitud = SolicitudDeAdopcion::findOrFail($id);
        $usuarios = User::all();
        $mascotas = Mascota::all();
        return view('solicitud.update', [
            'solicitud' => $solicitud,
            'usuarios' => $usuarios,
            'mascotas' => $mascotas,
            'estados' => $this->estados
        ]);
    }

    /**
     * Actualiza una solicitud de adopción
     */
    public function update(Request $request, string $id)
    {
        $solicitud = SolicitudDeAdopcion::findOrFail($id);

        $validated = $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'mascota_id' => 'required|exists:mascotas,id',
            'fecha_solicitud' => 'required|date',
            'estado' => 'required|string|in:pendiente,aprobada,rechazada',
            'comentario' => 'nullable|string'
        ]);

        $solicitud->update($validated);

        return redirect()->route('solicitud.index');
    }

    /**
     * Elimina una solicitud de adopción
     */
    public function delete(string $id)
    {
        SolicitudDeAdopcion::findOrFail($id)->delete();
        return redirect()->route('solicitud.index');
    }
}

