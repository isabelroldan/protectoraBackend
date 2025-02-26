<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Muestra un listado de todos los usuarios registrados en la base de datos.
     */
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
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

        $validated ['password'] = Hash::make($validated['password']);

        $usuario = User::create($validated);

        return response()->json($usuario, 201);
    }

    /**
     * Muestra los detalles de un usuario específico por su Id
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
     * Actualiza los datos de un usuario existente.
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
            //'password' => 'required|string',
            'direccion' => 'string',
            'telefono' => 'string',
        ]);

        /*if($validated['password']) {
            $validated ['password'] = Hash::make($validated['password']);
        }*/

        // Solo se encripta la contraseña si se ha proporcionado una nueva
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $usuario->update($validated);

        return response()->json($usuario, 200);
    }

    /**
     * Elimina un usuario de la base de datos.
     */
    public function destroy($id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404); //Si no lo encuentra devuelve un 404
        }

        $usuario->delete();

        return response()->json(['message' => 'Usuario eliminado'], 200);
    }
}
