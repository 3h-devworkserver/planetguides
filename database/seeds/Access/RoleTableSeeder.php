<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon as Carbon;

class RoleTableSeeder extends Seeder {

	public function run() {

		if(env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		if(env('DB_DRIVER') == 'mysql')
			DB::table(config('access.roles_table'))->truncate();
		elseif(env('DB_DRIVER') == 'sqlite')
			DB::statement("DELETE FROM ".config('access.roles_table'));
		else //For PostgreSQL or anything else
			DB::statement("TRUNCATE TABLE ".config('access.roles_table')." CASCADE");

		//Create admin role, id of 1
		$role_model = config('access.role');
		$admin = new $role_model;
		$admin->name = 'Administrator';
		$admin->all = true;
		$admin->sort = 1;
		$admin->created_at = Carbon::now();
		$admin->updated_at = Carbon::now();
		$admin->save();

		//Create guide role,id = 2
		$role_model = config('access.role');
		$guide = new $role_model;
		$guide->name = 'Guide';
		$guide->sort = 2;
		$guide->created_at = Carbon::now();
		$guide->updated_at = Carbon::now();
		$guide->save();

		//Create traveller role,id = 3
		$role_model = config('access.role');
		$traveller = new $role_model;
		$traveller->name = 'Traveller';
		$traveller->sort = 3;
		$traveller->created_at = Carbon::now();
		$traveller->updated_at = Carbon::now();
		$traveller->save();

		//Create company role,id = 4
		$role_model = config('access.role');
		$company = new $role_model;
		$company->name = 'Company';
		$company->sort = 4;
		$company->created_at = Carbon::now();
		$company->updated_at = Carbon::now();
		$company->save();

		if(env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}
}
