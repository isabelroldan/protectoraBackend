<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudDeAdopcion extends Model
{
    use HasFactory;

    //Nombre de la tabla de la base de datos, porque a diferencia de Mascota,en este caso, no coincidiría el plural
    protected $table = 'solicitud_de_adopciones';

    //Asignación masiva
    protected $fillable = ['usuario_id', 'mascota_id', 'fecha_solicitud', 'estado', 'comentario'];

    //Relación inversa ya que muchas solicitudes pueden pertenecer a un usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Otra relación inversa ya que muchas solicitudes pueden pertenecer a una mascota
    public function mascota()
    {
        return $this->belongsTo(Mascota::class, 'mascota_id');
    }
}