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
        $permission = Permission::create(['name' => 'vehi.user.index', 'description' => 'Ver listado de vehiculos'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'vehi.user.create', 'description' => 'Permite crear un vehiculo'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'vehi.user.edit', 'description' => 'Permite editar un vehiculo'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'vehi.user.desactivar', 'description' => 'Permite desactivar un vehiculo'])->syncRoles(['Admin']);

        $permission = Permission::create(['name' => 'perso.user.index', 'description' => 'Ver listado de personas'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'perso.user.create', 'description' => 'Permite crear una persona'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'perso.user.edit', 'description' => 'Permite editar una persona'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'perso.user.desactivar', 'description' => 'Permite desactivar una persona'])->syncRoles(['Admin']);
    }
}
