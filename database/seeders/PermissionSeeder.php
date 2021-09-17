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
            'show_categories',    //show all categories (index)
            'create_category',    
            'display_category',   //show one category (show)
            'update_category',    // edit category
            'delete_category',

            'show_products',   
            'create_product',    
            'display_product',  
            'update_product',    
            'delete_product',

            'show_tags',   
            'create_tag',    
            'display_tag',  
            'update_tag',    
            'delete_tag',

            'show_coupons',   
            'create_coupon',    
            'display_coupon',  
            'update_coupon',    
            'delete_coupon',

            'show_reviews',   
            'create_review',    
            'display_review',  
            'update_review',    
            'delete_review',

            'show_customers',   
            'create_customer',    
            'display_customer',  
            'update_customer',    
            'delete_customer',

            'show_supervisors',   
            'create_supervisor',    
            'display_supervisor',  
            'update_supervisor',    
            'delete_supervisor',

        ];

        foreach($permissions as $permission) {
            Permission::create(['guard_name' => 'admin', 'name' => $permission]);
        }
    }
}
