<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mascota extends Model
{
    use HasFactory;
    
    //Defino el nombre de la tabla aunque no sería necesario por que sigue la convención de nombres ed Laravel 
    protected $table = 'mascotas';

    //Permito la asignación masiva de atributos
    protected $fillable = ['nombre', 'especie', 'raza', 'edad', 'descripcion', 'estado'];

    //Defino la relación de uno a muchos porque una mascota puede tener múltiples solicitudes de adepción
    public function solicitudes()
    {
        return $this->hasMany(SolicitudDeAdopcion::class, 'mascota_id');
    }
}