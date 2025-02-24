<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Hash;
use Illuminate\Database\Seeder;
use Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(100)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'isabelroldancordoba@hotmail.com',
            'email_verified_at' => now(),
            'direccion' => "calle falsa 123", 
            'telefono' => "666666666", 
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        $this->call([
            MascotaSeeder::class, // Seeder para mascotas
            SolicitudDeAdopcionSeeder::class, // Seeder para solicitudes de adopción
        ]);
    }
}
