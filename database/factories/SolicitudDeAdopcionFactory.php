<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuario;
use App\Models\Mascota;

class SolicitudDeAdopcionFactory extends Factory
{
    protected $model = \App\Models\SolicitudDeAdopcion::class;

    public function definition()
    {
        return [
            'usuario_id' => Usuario::inRandomOrder()->first()->id ?? Usuario::factory(), 
            'mascota_id' => Mascota::inRandomOrder()->first()->id ?? Mascota::factory(), 
            'fecha_solicitud' => $this->faker->date(),
            'estado' => $this->faker->randomElement(['pendiente', 'aprobada', 'rechazada']),
            'comentario' => $this->faker->sentence(),
        ];
    }
}

