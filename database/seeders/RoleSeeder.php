<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Usuario']);

        $permission = Permission::create(['name' => 'admin.user.index', 'description' => 'Ver listado de Usuarios'])->syncRoles([$role1, $role2]);
        $permission = Permission::create(['name' => 'admin.user.create', 'description' => 'Crear Usuarios'])->syncRoles([$role1]);
        $permission = Permission::create(['name' => 'admin.user.edit', 'description' => 'Editar Usuarios'])->syncRoles([$role1, $role2]);
        $permission = Permission::create(['name' => 'admin.user.destroy', 'description' => 'Eliminar Usuarios'])->syncRoles([$role1]);

        $permission = Permission::create(['name' => 'admin.role.index', 'description' => 'Ver listado de Roles'])->syncRoles([$role1]);
        $permission = Permission::create(['name' => 'admin.role.create', 'description' => 'Crear Roles'])->syncRoles([$role1]);
        $permission = Permission::create(['name' => 'admin.role.edit', 'description' => 'Editar Roles'])->syncRoles([$role1]);
        $permission = Permission::create(['name' => 'admin.role.destroy', 'description' => 'Eliminar Roles'])->syncRoles([$role1]);

        $permission = Permission::create(['name' => 'insti.user.index', 'description' => 'Ver listado de Instituciones'])->syncRoles([$role1]);
        $permission = Permission::create(['name' => 'insti.user.consul', 'description' => 'Permite consultar las Instituciones'])->syncRoles([$role1]);
        $permission = Permission::create(['name' => 'insti.user.create', 'description' => 'Crear Instituciones'])->syncRoles([$role1]);
        $permission = Permission::create(['name' => 'insti.user.edit', 'description' => 'Editar Institución'])->syncRoles([$role1]);
        $permission = Permission::create(['name' => 'insti.user.desactivar', 'description' => 'desactivar Institución'])->syncRoles([$role1]);

        $permission = Permission::create(['name' => 'program.user.index', 'description' => 'Ver listado de Programaciones'])->syncRoles([$role1]);
        $permission = Permission::create(['name' => 'program.user.consul', 'description' => 'Permite consultar las Programaciones'])->syncRoles([$role1]);
        $permission = Permission::create(['name' => 'program.user.create', 'description' => 'Crear Programación'])->syncRoles([$role1]);
        $permission = Permission::create(['name' => 'program.user.edit', 'description' => 'Editar Programación'])->syncRoles([$role1]);
        $permission = Permission::create(['name' => 'program.user.desactivar', 'description' => 'desactivar Programación'])->syncRoles([$role1]);

        $permission = Permission::create(['name' => 'proflo.user.index', 'description' => 'Ver listado de Programación flotas'])->syncRoles([$role1]);
        $permission = Permission::create(['name' => 'proflo.user.desactivar', 'description' => 'Asigna y actualiza Programación flotas'])->syncRoles([$role1]);

        $permission = Permission::create(['name' => 'asiginsti.admin.index', 'description' => 'Ver listado para asignar institución al usuario'])->syncRoles([$role1]);
        $permission = Permission::create(['name' => 'asiginsti.admin.desactivar', 'description' => 'Asigna y actualiza asignación institución al usuario'])->syncRoles([$role1]);

        $permission = Permission::create(['name' => 'despacho.user.index', 'description' => 'Ver listado programacion aprobado para despacho'])->syncRoles([$role1]);
        $permission = Permission::create(['name' => 'despacho.user.edit', 'description' => 'Editar el despacho al usuario'])->syncRoles([$role1]);
    }
}
