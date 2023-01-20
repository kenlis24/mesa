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
        $permission = Permission::create(['name' => 'trab.user.index', 'description' => 'Ver listado de trabajadores'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'trab.user.create', 'description' => 'Permite crear un trabajador'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'trab.user.edit', 'description' => 'Permite editar un trabajador'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'trab.user.desactivar', 'description' => 'Permite desactivar un trabajador'])->syncRoles(['Admin']);
    }
}
