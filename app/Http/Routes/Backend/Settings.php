<?php

$router->group(['middleware' => 'access.routeNeedsPermission:settings-management'], function() use ($router)
{
	/**
	 * Settings Management
	 */
	get('settings', ['as' => 'admin.setting', 'uses' => 'SettingController@getSettings']);
	patch('setting/{setting}', ['as' => 'admin.setting.update', 'uses' => 'SettingController@patchSettings']);

	get('service/charge', ['as' => 'backend.service.charge', 'uses' => 'SettingController@getServiceCharge']);
	post('service/charge', ['as' => 'backend.service.charge.update', 'uses' => 'SettingController@postServiceCharge']);
	
	$router->group(['prefix' => 'settings'], function () {
		get('reset-email', ['as' => 'admin.setting.resetEmail', 'uses' => 'SettingController@getResetEmailSettings']);
		post('reset-email', ['as' => 'admin.setting.resetEmail.update', 'uses' => 'SettingController@postResetEmailSettings']);

		get('confirm-email', ['as' => 'admin.setting.confirmEmail', 'uses' => 'SettingController@getConfirmEmailSettings']);
		post('confirm-email', ['as' => 'admin.setting.confirmEmail.update', 'uses' => 'SettingController@postConfirmEmailSettings']);
		get('success-email', ['as' => 'admin.setting.successEmail', 'uses' => 'SettingController@getSuccessEmailSettings']);
		post('success-email', ['as' => 'admin.setting.successEmail.update', 'uses' => 'SettingController@postSuccessEmailSettings']);
		get('notify-email', ['as' => 'admin.setting.notifyEmail', 'uses' => 'SettingController@getNotifyEmailSettings']);
		post('notify-email', ['as' => 'admin.setting.notifyEmail.update', 'uses' => 'SettingController@postNotifyEmailSettings']);
	});
	

});