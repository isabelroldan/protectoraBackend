<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Mascota;
use App\Models\SolicitudDeAdopcion;
use Illuminate\Database\Eloquent\Factories\Factory;

class SolicitudDeAdopcionFactory extends Factory
{
    protected $model = SolicitudDeAdopcion::class;

    public function definition()
    {
        do {
            $usuario = User::inRandomOrder()->first();
            $mascota = Mascota::inRandomOrder()->first();
        } while (SolicitudDeAdopcion::where('usuario_id', $usuario->id)
                                    ->where('mascota_id', $mascota->id)
                                    ->exists());
        return [
            'usuario_id' => $usuario->id, 
            'mascota_id' => $mascota->id, 
            'fecha_solicitud' => $this->faker->date(),
            'estado' => $this->faker->randomElement(['pendiente', 'aprobada', 'rechazada']),
            'comentario' => $this->faker->sentence(),
        ];
    }
}


