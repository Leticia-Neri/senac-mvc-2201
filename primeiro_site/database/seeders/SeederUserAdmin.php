<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class SeederUserAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([ // create user admin
            'name' => 'Leonardo',
            'email' => 'leonardo@leonardo.com',
            'password' => bcrypt('123456')]);

        $role = Role::create(['name' => 'Admin']); // create a new role called admin
        $permissions = Permission::pluck('id','id')->all(); // get all permissions id
        $role->syncPermissions($permissions); // assign all permissions to admin role
        $user->assignRole([$role->id]); // assign role to user

    }
}
