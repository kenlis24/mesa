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
        $permission = Permission::create(['name' => 'despaxesta.user.index', 'description' => 'Ver listado programacion por estación de servicio para despacho'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'despaxesta.user.edit', 'description' => 'Editar el despacho por estación al usuario'])->syncRoles(['Admin']);
    }
}
