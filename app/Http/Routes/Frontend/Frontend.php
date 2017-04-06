<?php

/**
 * Frontend Controllers
 */
get('/', 'FrontendController@index')->name('home');
get('/{page}','FrontendController@page')->name('page');
get('/search/results', 'SearchController@index')->name('search.index');
get('autocomplete/search', 'SearchController@autocompletesearch');
get('paymentpaypal', 'PaypalPaymentController@store');
//get('paymentpaypal/paypalipn', 'PaypalPaymentController@paypalipn');
post('paymentpaypal/paypalipn', 'PaypalPaymentController@paypalipn');

$router->group(['namespace' => 'Traveller'], function () use ($router)
{
post('traveller/booking/process', 'TravellerController@postBookingDetails')->name('frontend.guide.booking.process');
	
get('traveller/booking/process', 'TravellerController@postBookingProcess');

post('traveller/booking/paypal', 'TravellerController@submitPaypal')->name('frontend.guide.paypal.post');
get('traveller/booking/paypal', 'TravellerController@submitPaypal');

});
//('paymentpaypal/paymentform', 'PaypalPaymentController@paymentform')->name('paymentpaypal.index');

get('macros', 'FrontendController@macros');

get('paypalipn', 'PaypalipnlistnerController@index');


