<?php

$router->group([
	'middleware' => 'access.routeNeedsPermission:view-mainguidearea-management'
], function() use ($router) {
	get('miscellaneous/commission', 'BookingController@commission')->name('admin.commission');

	get('miscellaneous/addguide', 'MiscellaneousController@getArea')->name('admin.guidearea.pages');

	post('miscellaneous/addguide', 'MiscellaneousController@postAddPlace')->name('admin.guidearea.upload');

	get('miscellaneous/guidAreaemanagement', 'MiscellaneousController@getAllGuidearea')->name('admin.miscellaneous.getAllarea');
	
	get('miscellaneous/guidearea/delete/{id}', 'MiscellaneousController@deleteGuideArea')->name('admin.miscellaneous.guidAreaDelete');
	get('miscellaneous/guidearea/edit/{id}', 'MiscellaneousController@editGuideArea')->name('admin.miscellaneous.editAreaDelete');
	patch('miscellaneous/updateGuidearea/{id}', 'MiscellaneousController@updateGuidearea')->name('admin.guidearea.update');
	

	get('miscellaneous/addlanguage', 'MiscellaneousController@getLanguage')->name('admin.language.pages');
	post('miscellaneous/addlanguage', 'MiscellaneousController@postLanguage')->name('admin.language.pages');
	
	get('miscellaneous/languagemanagement', 'MiscellaneousController@getAllLanguage')-> name('admin.miscellaneous.getAllLanguage');

	get('miscellaneous/language/delete/{id}', 'MiscellaneousController@deletelanguage')->name('admin.miscellaneous.languagedelete');
	get('miscellaneous/language/edit/{id}', 'MiscellaneousController@editLanguage')->name('admin.miscellaneous.editlanguage');
	patch('miscellaneous/updateLanguage/{id}', 'MiscellaneousController@updateLanguage')->name('admin.language.update');
});