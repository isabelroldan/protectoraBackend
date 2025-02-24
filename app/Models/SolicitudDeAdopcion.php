<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudDeAdopcion extends Model
{
    use HasFactory;
    protected $table = 'solicitud_de_adopciones';


    protected $fillable = ['usuario_id', 'mascota_id', 'fecha_solicitud', 'estado', 'comentario'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function mascota()
    {
        return $this->belongsTo(Mascota::class, 'mascota_id');
    }
}