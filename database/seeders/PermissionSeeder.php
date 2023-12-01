<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'create_role' ,'update_role','delete_role','show_roles',
            'create_user' ,'update_user','delete_user','show_users','generate_temp_link',
            'create_category' ,'update_category','delete_category','show_categories',
            'approve_article' ,'update_article','delete_article','show_articles','create_article'
        ] ;
        foreach ($permissions as $permission) {
        Permission::create(
            [
                'name'=> $permission,
                'guard_name'=>'web'
            ]
        ) ;
        }
    }
}
