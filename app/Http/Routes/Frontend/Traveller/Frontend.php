<?php

/**
 * Frontend Controllers
 */


/**
 * These frontend controllers require the user to be logged in
 */

$router->group(['namespace' => 'Traveller'], function () use ($router)
{
    

    
$router->group(['middleware' => 'access.routeNeedsRole:Traveller'], function ()
{
	get('traveller/profile', 'ProfileController@index')->name('frontend.traveller.profile');

	get('traveller/dashboard', 'ProfileController@dashboard')->name('frontend.traveller.dashboard');

	get('traveller/settings', 'ProfileController@settings')->name('frontend.traveller.settings');
	
	post('traveller/settings', 'ProfileController@settingsUpdate')->name('frontend.traveller.settings.update');

	post('traveller/settings/email', 'ProfileController@emailUpdate')->name('frontend.traveller.settings.emailupdate');

	patch('traveller/profile/update', 'ProfileController@update')->name('frontend.traveller.profile.update');

	post('traveller/profile/pic/upload', 'ProfileController@picUpload')->name('frontend.traveller.profile.pic.upload');

	get('traveller/activity', 'TravellerController@getActivity')->name('frontend.traveller.activity');

	get('traveller/cancel/booking/{booking_id}', 'TravellerController@cancelBooking')->name('frontend.traveller.cancel.booking');

	get('traveller/favorites', 'TravellerController@showFavorites')->name('frontend.traveller.favotites');

	get('traveller/favorite/add/{guide_id}', 'TravellerController@addFavorite')->name('frontend.traveller.add.favorites');

	get('traveller/favorite/remove/{guide_id}', 'TravellerController@removeFavorite')->name('frontend.traveller.delete.favorites');

	get('traveller/payment-process', 'TravellerController@getPaymentProcess')->name('frontend.guide.payment');

	
});


});