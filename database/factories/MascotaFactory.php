<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MascotaFactory extends Factory
{
    protected $model = \App\Models\Mascota::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->firstName, 
            'especie' => $this->faker->randomElement(['perro', 'gato']), 
            'raza' => $this->faker->word, 
            'edad' => $this->faker->numberBetween(1, 20), 
            'descripcion' => $this->faker->sentence, 
            'estado' => $this->faker->randomElement(['disponible', 'en proceso de adopción', 'adoptado']), 
        ];
    }
}

