<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class TemporalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = Permission::create(['name' => 'perso.user.asigauto', 'description' => 'Permite asignar un vehiculo a una persona'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'perso.user.asiginti', 'description' => 'Permite asignar una institución a una persona'])->syncRoles(['Admin']);
    }
}
