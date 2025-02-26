<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(){
        $usuarios = User::all();
        return view('usuario.index', ['usuarios' => $usuarios]);
        
    }

    public function show($id){
        
        $usuario = User::find($id);
        
        return view('usuario.show', ['usuario' => $usuario/*, 'estados' => $this->estados*/]);
    }

    public function showCreateView()
    {
        return view('usuario.create'/*, ['estados' => $this->estados]*/);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
            'email' => ['required', 'string'],
            'direccion' => 'required|string',
            'telefono' => 'required|string'
        ]);

        $validated ['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('usuario.index');
    }

    public function showUpdateView($id)
    {
        $usuario = User::find($id);
        return view('usuario.update', ['usuario' => $usuario/*, 'estados' => $this->estados*/]);
    }

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
        
        if($validated['password']) {
            $validated ['password'] = Hash::make($validated['password']);
        }

        $usuario->update($validated);

        return redirect()->route('usuario.index');
    }

    public function delete(string $id)
    {
        User::find($id)->delete();
        return redirect()->route('usuario.index');
    }
}
