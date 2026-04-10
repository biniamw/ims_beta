<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $permissions = [
            
            'Category-View',
            'Category-Add',
            'Category-Edit',
            'Category-Delete',
            'UOM-View',
            'UOM-Add',
            'UOM-Edit',
            'UOM-Delete',
            'Item-View',
            'Item-Add',
            'Item-Edit',
            'Item-Delete',
            'Customer-View',
            'Customer-Add',
            'Customer-Edit',
            'Customer-Delete',
            'Customer-MRC',
            'Blacklist-View',
            'Blacklist-Add',
            'Blacklist-Edit',
            'Blacklist-Delete',
            'Store-View',
            'Store-Add',
            'Store-Edit',
            'Store-Delete',
            'Store-Location',
            'Brand-View',
            'Brand-Add',
            'Brand-Edit',
            'Brand-Delete',
            'sales-show',
            'sales-edit',
            'sales-add',
            'sales-delete',
            'sales-discount',

         ];

         foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
       }
    }
}
