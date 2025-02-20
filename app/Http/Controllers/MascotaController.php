<?php

namespace App\Http\Controllers;
use App\Models\Mascota;
use Illuminate\Http\Request;

class MascotaController extends Controller
{
    private array $estados;

    public function __construct() {
        $this->estados = [
            'disponible' => 'disponible', 
            'en proceso de adopción' => 'en proceso de adopción', 
            'adoptado' => 'adoptado'
        ];
    }

    public function index(){
        $mascotas = Mascota::all();
        return view('mascota.index', ['mascotas' => $mascotas]);
        
    }

    public function show($id){
        
        $mascota = Mascota::find($id);
        
        return view('mascota.show', ['mascota' => $mascota, 'estados' => $this->estados]);
    }

    public function showCreateView()
    {
        return view('mascota.create', ['estados' => $this->estados]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string',
            'especie' => ['required', 'string'],
            'raza' => 'required|string',
            'edad' => 'required|numeric',
            'descripcion' => 'required|string',
            'estado' => 'required|string'
        ]);

        Mascota::create($validated);

        return redirect()->route('mascota.index');
    }

    public function showUpdateView($id)
    {
        $mascota = Mascota::find($id);
        return view('mascota.update', ['mascota' => $mascota, 'estados' => $this->estados]);
    }

    public function update(Request $request, string $id)
    {
        

        $mascota = Mascota::find($id);

        $validated = $request->validate([
            'nombre' => 'required|string',
            'especie' => ['required', 'string'],
            'raza' => 'required|string',
            'edad' => 'required|numeric',
            'descripcion' => 'required|string',
            'estado' => 'required|string'
        ]);

        //$mascota-> $validated;

        //$mascota->update($request->all());

        $mascota->update($validated);

        return redirect()->route('mascota.index');
    }

    public function delete(string $id)
    {
        //Mascota::destroy($id);
        Mascota::find($id)->delete();
        return redirect()->route('mascota.index');
    }

}