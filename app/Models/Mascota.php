<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mascota extends Model
{
    use HasFactory;
    protected $table = 'mascotas';

    protected $fillable = ['nombre', 'especie', 'raza', 'edad', 'descripcion', 'estado'];

    public function solicitudes()
    {
        return $this->hasMany(SolicitudDeAdopcion::class, 'mascota_id');
    }
}