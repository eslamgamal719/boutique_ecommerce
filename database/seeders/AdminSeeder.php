<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Str;
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
        $customer = User::create([
            'first_name' => 'Eslam',
            'last_name'  => 'Gamal',
            'username'   => 'eslam',
            'email' => 'eslam@gmail.com',
            'email_verified_at' => now(),
            'mobile' => '966500000002',
            'password' => bcrypt('123123123'),
            'status' => 1,
            'remember_token' => Str::random(10)]);
        
            
        /**
         *  Create 1000 fake users with their addresses
         */
        User::factory()->count(1000)->hasAddresses(1)->create();  


        $admin = Admin::create([
            'first_name'        => "Admin",
            'last_name'         => "System",
            'username'          => "admin",
            'email'             => 'admin@admin.com',
            'mobile'            => '96654784587',
            'status'            => 1,
            'role_name'         => 'admin',
            'password'          => bcrypt('123123123'),
            'remember_token'    => Str::random(10),
        ]);
        
        $roleAdmin      = Role::create(['guard_name' => 'admin', 'name' => 'admin']);
        $roleSupervisor = Role::create(['guard_name' => 'admin', 'name' => 'supervisor']);

        $permissions = Permission::all();
        $roleAdmin->syncPermissions($permissions);

        $admin->assignRole($roleAdmin);
    }
}
