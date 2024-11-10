<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;
use App\Models\Empleado;
use App\Models\Persona;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create([
            'name' => 'superadmin',
            'email' => 'phenlinea@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        Admin::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678')
        ]);
        Empleado::create([
            'name' => 'empleado',
            'email' => 'empleado@gmail.com',
            'password' => bcrypt('12345678')
        ]);
        Persona::create([
            'name' => 'persona',
            'email' => 'persona@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        
    }
}
