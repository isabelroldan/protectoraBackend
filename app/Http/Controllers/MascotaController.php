<?php

namespace App\Http\Controllers;
use App\Models\Mascota;
use Illuminate\Http\Request;

class MascotaController extends Controller
{
    private array $estados; //Lista de los estados que puede tener una mascota

    /**
     * En el constructor inicializo los estados
     */
    public function __construct() {
        $this->estados = [
            'disponible' => 'disponible', 
            'en proceso de adopción' => 'en proceso de adopción', 
            'adoptado' => 'adoptado'
        ];
    }

    /**
     * Muestra la lista de todas las mascotas
     */
    public function index(){
        $mascotas = Mascota::all();
        return view('mascota.index', ['mascotas' => $mascotas]);
        
    }

    /**
     * Muestra los detalles de una mascota específica
     */
    public function show($id){
        
        $mascota = Mascota::find($id);
        
        return view('mascota.show', ['mascota' => $mascota, 'estados' => $this->estados]);
    }

    /**
     * Muestra la vista de creación de una nueva mascota
     */
    public function showCreateView()
    {
        return view('mascota.create', ['estados' => $this->estados]);
    }

    /**
     * Almacena una nueva mascota en la base de datos
     */
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

    /**
     * Muestra la vista de edición de una mascota
     */
    public function showUpdateView($id)
    {
        $mascota = Mascota::find($id);
        return view('mascota.update', ['mascota' => $mascota, 'estados' => $this->estados]);
    }

    /**
     * Actualiza los datos de una mascota
     */
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

        $mascota->update($validated);

        return redirect()->route('mascota.index');
    }

    /**
     * Elimina una mascota de la base de datos
     */
    public function delete(string $id)
    {
        Mascota::find($id)->delete();
        return redirect()->route('mascota.index');
    }

}