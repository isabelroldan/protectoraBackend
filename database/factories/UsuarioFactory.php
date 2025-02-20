<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UsuarioFactory extends Factory
{
    protected $model = \App\Models\Usuario::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->name, 
            'email' => $this->faker->unique()->safeEmail, 
            'direccion' => $this->faker->address, 
            'telefono' => $this->faker->phoneNumber, 
        ];
    }
}

