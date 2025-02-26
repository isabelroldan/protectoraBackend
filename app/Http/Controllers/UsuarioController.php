<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Muestra la lista de todos los usuarios
     */
    public function index()
    {
        $usuarios = User::all();
        return view('usuario.index', ['usuarios' => $usuarios]);

    }

    /**
     * Muestra los detalles de un usuario específico
     */
    public function show($id)
    {

        $usuario = User::find($id);

        return view('usuario.show', ['usuario' => $usuario]);
    }

    /**
     * Muestra la vista para crear un nuevo usuario
     */
    public function showCreateView()
    {
        return view('usuario.create');
    }

    /**
     * Almacena un nuevo usuario en la base de datos
     */
    public function store(Request $request)
    {
        //Valido los datos que recibo del formulario
        $validated = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
            'email' => ['required', 'string'],
            'direccion' => 'required|string',
            'telefono' => 'required|string'
        ]);

        //Encriptamos la contraseña antes de guardarla
        $validated['password'] = Hash::make($validated['password']);

        //Creo un usuario con los datos después de validarlos
        User::create($validated);

        //Redirijo al índice de los usuarios
        return redirect()->route('usuario.index');
    }

    /**
     * Muestra la vista de edición de un usuario
     */
    public function showUpdateView($id)
    {
        $usuario = User::find($id);
        return view('usuario.update', ['usuario' => $usuario]);
    }

    /**
     * Actualiza los datos de un usuario
     */
    public function update(Request $request, string $id)
    {

        $usuario = User::find($id);

        $validated = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
            'email' => ['required', 'string'],
            'direccion' => 'required|string',
            'telefono' => 'required|string'
        ]);

        // Solo se encripta la contraseña si se ha proporcionado una nueva
        if ($validated['password']) {
            $validated['password'] = Hash::make($validated['password']);
        }

        // Actualizamos los datos del usuario
        $usuario->update($validated);

        return redirect()->route('usuario.index');
    }

    /**
     * Elimina un usuario de la base de datos
     */
    public function delete(string $id)
    {
        User::find($id)->delete();
        return redirect()->route('usuario.index');
    }
}
