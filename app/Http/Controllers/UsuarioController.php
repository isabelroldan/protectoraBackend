<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(){
        $usuarios = Usuario::all();
        return view('usuario.index', ['usuarios' => $usuarios]);
        
    }

    public function show($id){
        
        $usuario = Usuario::find($id);
        
        return view('usuario.show', ['usuario' => $usuario/*, 'estados' => $this->estados*/]);
    }

    public function showCreateView()
    {
        return view('usuario.create'/*, ['estados' => $this->estados]*/);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string',
            'email' => ['required', 'string'],
            'direccion' => 'required|string',
            'telefono' => 'required|string'
        ]);

        Usuario::create($validated);

        return redirect()->route('usuario.index');
    }

    public function showUpdateView($id)
    {
        $usuario = Usuario::find($id);
        return view('usuario.update', ['usuario' => $usuario/*, 'estados' => $this->estados*/]);
    }

    public function update(Request $request, string $id)
    {
        

        $usuario = Usuario::find($id);

        $validated = $request->validate([
            'nombre' => 'required|string',
            'email' => ['required', 'string'],
            'direccion' => 'required|string',
            'telefono' => 'required|string'
        ]);

        $usuario->update($validated);

        return redirect()->route('usuario.index');
    }

    public function delete(string $id)
    {
        Usuario::find($id)->delete();
        return redirect()->route('usuario.index');
    }
}
