<?php

$router->group([
	'middleware' => 'access.routeNeedsPermission:view-booking-management'
], function() use ($router) {
	/**
	 * Booking Management
	 */
	Route::group(['prefix' => 'booking/{id}', 'where' => ['id' => '[0-9]+']], function () {
		//for verifying
		get('status/{status}', 'BookingController@status')
			->name('admin.booking.status')
			->where([
				'status' => '[0,1]'
			]);
		delete('delete', 'BookingController@delete')->name('admin.booking.delete');

		//for changing booking status to canceled
		get('cancel', 'BookingController@cancelBooking')->name('admin.booking.cancel');
		//for changing Guide payment attributes(amount and status)
		patch('guidepayment', 'BookingController@changeGuidePayment')->name('admin.booking.guidepayment');
		//for changing next Attributes (next_id and status)
		patch('next' , 'BookingController@changeNextAttributes');
	});
	// get('bookings/unapproved', 'BookingController@getUnapproved')->name('admin.bookings.unapproved');
	get('bookings/approved', 'BookingController@getApproved')->name('admin.bookings.approved');

	
	
});