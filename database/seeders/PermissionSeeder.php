<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $permissions = [
            'main',
            
            //categories permissions
            'manage_categories',  
            'show_categories',    //show all categories (index)
            'create_category',    
            'display_category',   //show one category (show)
            'update_category',    // edit category
            'delete_category',

            'manage_products',  
            'show_products',   
            'create_product',    
            'display_product',  
            'update_product',    
            'delete_product',

            'manage_tags',  
            'show_tags',   
            'create_tag',    
            'display_tag',  
            'update_tag',    
            'delete_tag',

        ];

        foreach($permissions as $permission) {
            Permission::create(['guard_name' => 'admin', 'name' => $permission]);
        }
    }
}
