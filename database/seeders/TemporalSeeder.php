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
        $permission = Permission::create(['name' => 'inter.user.index', 'description' => 'Ver listado de vehiculos estacion internacional'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'inter.user.create', 'description' => 'Permite registrar vehiculo estacion internacional'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'inter.user.edit', 'description' => 'Permite editar vehiculo estacion internacional'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'inter.user.desactivar', 'description' => 'Permite desactivar vehiculo estacion internacional'])->syncRoles(['Admin']);
    }
}
