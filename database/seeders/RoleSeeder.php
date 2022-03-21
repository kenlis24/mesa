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

        $permission = Permission::create(['name' => 'admin.user.index','description' => 'Ver listado de Usuarios'])->syncRoles([$role1, $role2]);
        $permission = Permission::create(['name' => 'admin.user.create','description' => 'Crear Usuarios'])->syncRoles([$role1]);
        $permission = Permission::create(['name' => 'admin.user.edit','description' => 'Editar Usuarios'])->syncRoles([$role1, $role2]);
        $permission = Permission::create(['name' => 'admin.user.destroy','description' => 'Eliminar Usuarios'])->syncRoles([$role1]);

        $permission = Permission::create(['name' => 'admin.role.index','description' => 'Ver listado de Roles'])->syncRoles([$role1]);
        $permission = Permission::create(['name' => 'admin.role.create','description' => 'Crear Roles'])->syncRoles([$role1]);
        $permission = Permission::create(['name' => 'admin.role.edit','description' => 'Editar Roles'])->syncRoles([$role1]);
        $permission = Permission::create(['name' => 'admin.role.destroy','description' => 'Eliminar Roles'])->syncRoles([$role1]);
    }
}
