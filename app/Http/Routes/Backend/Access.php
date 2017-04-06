<?php

$router->group([
	'prefix' => 'access',
	'namespace' => 'Access',
	'middleware' => 'access.routeNeedsPermission:view-access-management'
], function() use ($router)
{
	/**
	 * User Management
	 */
	$router->group(['namespace' => 'User'], function() use ($router) {
		patch('traveller/update/{id}', 'UserController@updateTraveller')->name('admin.access.travellers.update');
		resource('users', 'UserController', ['except' => ['show']]);
		get('users/deactivated', 'UserController@deactivated')->name('admin.access.users.deactivated');
		get('users/banned', 'UserController@banned')->name('admin.access.users.banned');
		get('users/deleted', 'UserController@deleted')->name('admin.access.users.deleted');
		get('account/confirm/resend/{user_id}', 'UserController@resendConfirmationEmail')->name('admin.account.confirm.resend');
		post('admin/profile/pic/upload', 'UserController@picUpload')->name('backend.admin.profile.pic.upload');

//added to upload traveller profile pic
		post('traveller/{id}/profile/pic/upload', 'UserController@picUploadTraveller')->name('backend.traveller.profile.pic.upload');
		
		get('users/guide', 'UserController@getGuides')->name('admin.access.users.guide');
		get('users/traveller', 'UserController@getTravellers')->name('admin.access.users.traveller');
		get('users/generaluser', 'UserController@getGeneralUsers')->name('admin.access.users.generaluser');
		get('add/guide', 'UserController@getAddGuide')->name('admin.access.addguide.create');
		post('add/license', 'UserController@postLicence')->name('backend.guide.license.upload');

//approve certificate from unapproved license management
		get('guide/{id}/certify', 'UserController@certifyGuide');

		post('update/certification', 'UserController@postCertification')->name('backend.guide.certify.update');
		post('update/profile', 'UserController@postProfilePic')->name('backend.guide.profile.update');

		post('booking/availability', 'UserController@postAvailability')->name('backend.guide.availability.store');
		post('booking/editavailability', 'UserController@postEditAvailability')->name('backend.guide.availability.update');

		
		
		/**
		 * Specific User
		 */
		$router->group(['prefix' => 'user/{id}', 'where' => ['id' => '[0-9]+']], function () {
			//var_dump('a'); die()
			get('delete', 'UserController@delete')->name('admin.access.user.delete-permanently');
			get('restore', 'UserController@restore')->name('admin.access.user.restore');
			get('mark/{status}', 'UserController@mark')->name('admin.access.user.mark')->where(['status' => '[0,1,2]']);
			get('password/change', 'UserController@changePassword')->name('admin.access.user.change-password');
			post('password/change', 'UserController@updatePassword')->name('admin.access.user.change-password');
		});
	});

	/**
	 * Role Management
	 */
	$router->group(['namespace' => 'Role'], function() use ($router) {
		resource('roles', 'RoleController', ['except' => ['show']]);
	});

	/**
	 * Permission Management
	 */
	$router->group(['prefix' => 'roles', 'namespace' => 'Permission'], function() use ($router)
	{
		resource('permission-group', 'PermissionGroupController', ['except' => ['index', 'show']]);
		resource('permissions', 'PermissionController', ['except' => ['show']]);

		$router->group(['prefix' => 'groups'], function () {
			post('update-sort', 'PermissionGroupController@updateSort')->name('admin.access.roles.groups.update-sort');
		});
	});
});
