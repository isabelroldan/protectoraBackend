<?php

use App\Models\User;
use App\Models\Usuario;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('telefono')->after('email');
            $table->string('direccion')->after('telefono');            
        });

        $this->seed();

    }
    

    private function seed(): void{
        $usuarios = collect(Usuario::all());
        $usuarios = $usuarios->map(function ($usuario) {
            $usuario = $usuario->toArray();
            $usuario['name'] = $usuario['nombre'];
            $usuario['password'] = Hash::make('password');
            unset($usuario['nombre']);
            return $usuario;
        });
        $usuarios->each(function ($usuario) {
            User::create($usuario);
        });
    }
};
