<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = ['nombre', 'email', 'direccion', 'telefono'];

    public function solicitudes()
    {
        return $this->hasMany(SolicitudDeAdopcion::class, 'user_id');
    }
}