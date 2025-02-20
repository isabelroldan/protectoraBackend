<?php

namespace Database\Seeders;

use App\Models\SolicitudDeAdopcion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SolicitudDeAdopcionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SolicitudDeAdopcion::factory(30)->create();
    }
}
