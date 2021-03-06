<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PermissionGroupTableSeeder extends Seeder {

    public function run() {

        if(env('DB_DRIVER') == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        if(env('DB_DRIVER') == 'mysql')
        {
            DB::table(config('access.permission_group_table'))->truncate();
        } elseif(env('DB_DRIVER') == 'sqlite') {
            DB::statement("DELETE FROM ".config('access.permission_group_table'));
        } else { //For PostgreSQL or anything else
            DB::statement("TRUNCATE TABLE ".config('access.permission_group_table')." CASCADE");
        }

        /**
         * Create the Access groups
         */

        $group_model = config('access.group');
        $access = new $group_model;
        $access->name = 'Access';
        $access->sort = 1;
        $access->created_at = Carbon::now();
        $access->updated_at = Carbon::now();
        $access->save();

        $group_model = config('access.group');
        $user = new $group_model;
        $user->name = 'User';
        $user->sort = 3;
        
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->save();

        $group_model = config('access.group');
        $role = new $group_model;
        $role->name = 'Role';
        $role->sort = 4;
        
        $role->created_at = Carbon::now();
        $role->updated_at = Carbon::now();
        $role->save();

        $group_model = config('access.group');
        $permission = new $group_model;
        $permission->name = 'Permission';
        $permission->sort = 5;
       
        $permission->created_at = Carbon::now();
        $permission->updated_at = Carbon::now();
        $permission->save();

        $group_model = config('access.group');
        $pages = new $group_model;
        $pages->name = 'Page';
        $pages->sort = 2;
        $pages->created_at = Carbon::now();
        $pages->updated_at = Carbon::now();
        $pages->save();

        if(env('DB_DRIVER') == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
