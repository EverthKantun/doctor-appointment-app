<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        //Llamar a RoleSeeder 
        $this->call([
            RoleSeeder::class
        ]);
        //crear usuario de prueba cada que se ejecuten migraciones
        //php artisan migrate:fresh --seed
        User::factory()->create([
            'name' => 'Everth Kantún',
            'email' => 'prueba@gmail.mx',
            'password'=> bcrypt ('12345678')
        ]);
    }
}
