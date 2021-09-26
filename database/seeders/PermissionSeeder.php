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

            'show_countries',   
            'create_country',    
            'display_country',  
            'update_country',    
            'delete_country',

            'show_states',   
            'create_state',    
            'display_state',  
            'update_state',    
            'delete_state',

            'show_cities',   
            'create_city',    
            'display_city',  
            'update_city',    
            'delete_city',

            'show_customer_addresses',   
            'create_customer_address',    
            'display_customer_address',  
            'update_customer_address',    
            'delete_customer_address',

            'show_shipping_companies',   
            'create_shipping_company',    
            'display_shipping_company',  
            'update_shipping_company',    
            'delete_shipping_company',

        ];

        foreach($permissions as $permission) {
            Permission::create(['guard_name' => 'admin', 'name' => $permission]);
        }
    }
}
