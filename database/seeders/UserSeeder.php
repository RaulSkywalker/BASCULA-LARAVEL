<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleNormal = Role::create(['name' => 'usuarioapp']);

        User::create([
            'name' => 'profe',
            'email' => "admin@app.lan",
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
            ]
        )->assignRole($roleAdmin);
        $usuariosAdmin = User::factory(4)->create();
        $usuariosNormales = User::factory(50)->create();


        foreach($usuariosAdmin as $usuario) {
            $usuario->assignRole($roleAdmin);
        }
        foreach($usuariosNormales as $usuario) {
            $usuario->assignRole($roleNormal);
        }



    }
}
