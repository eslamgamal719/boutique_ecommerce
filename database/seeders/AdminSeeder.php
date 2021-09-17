<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(100)->create();   //create 100 user using factory

        $admin = Admin::create([
            'first_name'        => "Admin",
            'last_name'         => "System",
            'username'          => "admin",
            'email'             => 'admin@admin.com',
            'mobile'            => '96654784587',
            'user_image'        => 'avatar.png',
            'status'            => 1,
            'role_name'         => 'admin',
            'password'          => bcrypt('123123123'),
            'remember_token'    => \Str::random(10),
        ]);
        
        $roleAdmin      = Role::create(['guard_name' => 'admin', 'name' => 'admin']);
        $roleSupervisor = Role::create(['guard_name' => 'admin', 'name' => 'supervisor']);

        $permissions = Permission::all();
        $roleAdmin->syncPermissions($permissions);

        $admin->assignRole($roleAdmin);
    }
}
