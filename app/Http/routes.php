<?php

/**
 * Switch between the included languages
 */
require(__DIR__ . "/Routes/Global/Lang.php");

/**
 * Frontend Routes
 * Namespaces indicate folder structure
 */

$router->group(['namespace' => 'Frontend'], function () use ($router)
{
	require(__DIR__ . "/Routes/Frontend/Access.php");
	require(__DIR__ . "/Routes/Frontend/Frontend.php");
	require(__DIR__ . "/Routes/Frontend/Guide/Frontend.php");
	require(__DIR__ . "/Routes/Frontend/Traveller/Frontend.php");
	require(__DIR__ . "/Routes/Frontend/Payment.php");
});
/**
 * Backend Routes
 * Namespaces indicate folder structure
 */
$router->group(['namespace' => 'Backend'], function () use ($router)
{
	$router->group(['prefix' => 'admin', 'middleware' => 'auth'], function () use ($router)
	{
		/**
		 * These routes need view-backend permission (good if you want to allow more than one group in the backend, then limit the backend features by different roles or permissions)
		 *
		 * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
		 */
		$router->group(['middleware' => 'access.routeNeedsPermission:view-backend'], function () use ($router)
		{
			require(__DIR__ . "/Routes/Backend/Dashboard.php");
			require(__DIR__ . "/Routes/Backend/Pages.php");
			require(__DIR__ . "/Routes/Backend/Access.php");
			require(__DIR__ . "/Routes/Backend/Settings.php");
			require(__DIR__ . "/Routes/Backend/Backend.php");
			require(__DIR__ . "/Routes/Backend/Booking.php");
			require(__DIR__ . "/Routes/Backend/Slides.php");
			require(__DIR__ . "/Routes/Backend/Miscellaneous.php");
			require(__DIR__ . "/Routes/Backend/Contactemail.php");

		});
	});

	// API routes
	$router->group(['prefix' => 'api', 'namespace' => 'Api'], function() use ($router)
	{
	    // DataTables
	    get('table/users', ['as'=>'api.table.users', 'uses'=>'DataTableController@getUsers']);
	    get('table/users/deactivated', ['as'=>'api.table.users.deactivated', 'uses'=>'DataTableController@getDeactivatedUsers']);
	    
	    get('table/users/guides', ['as'=>'api.table.users.guides', 'uses'=>'DataTableController@getGuides']);

	    get('table/users/travellers', ['as'=>'api.table.users.travellers', 'uses'=>'DataTableController@getTravellers']);

	    get('table/page', ['as'=>'api.table.page', 'uses'=>'DataTableController@getPages']);
	    get('table/page/deactivated', ['as'=>'api.table.page.deactivated', 'uses'=>'DataTableController@getDeactivatedPages']);

	     get('table/reviews/unapproved', ['as' => 'api.table.reviews.unapproved', 'uses' => 'DataTableController@getUnapprovedReviews']);
	    get('table/reviews/approved', ['as' => 'api.table.reviews.approved', 'uses' => 'DataTableController@getApprovedReviews']);
	    get('table/reviews/all', ['as' => 'api.table.reviews.all', 'uses' => 'DataTableController@getAllReviews']);

	    get('table/guide/reviews', ['as'=>'api.table.guide.reviews', 'uses'=>'DataTableController@getGuideReviews']);

	    get('table/license', ['as' => 'api.table.license', 'uses' => 'DataTableController@getLicense']);

	    get('table/bookings/approved', ['as' => 'api.table.bookings.approved', 'uses' => 'DataTableController@getApprovedBookings']);
	    get('table/bookings/unapproved', ['as' => 'api.table.bookings.unapproved', 'uses' => 'DataTableController@getUnapprovedBookings']);
	    
	    get('table/slides', ['as' => 'api.table.slides', 'uses' => 'DataTableController@getAllSlides']);
	    get('table/misc', ['as' => 'api.table.misc', 'uses' => 'DataTableController@getAllGuideArea']);
	    get('table/misclang', ['as' => 'api.table.misclang', 'uses' => 'DataTableController@getAllLanguage']);
	 //for useremails   
	    get('table/contactemail', ['as' => 'api.table.contactemail', 'uses' => 'DataTableController@getAllContactemail']);

	    
	});
});
Route::group(array('prefix' => "webservice"), function () {
Route::resource('guidesignup', 'Api\GAuthController@getApiSignup');
Route::resource('login', 'Api\GAuthController@getApiLogin');
Route::resource('contact', 'Api\GAuthController@getApiContact');
Route::resource('changepassword', 'Api\GAuthController@getApiChangePassword');
Route::resource('setguidebusydays', 'Api\GAuthController@getApiGuidebusydays');
Route::resource('saveprofileimage', 'Api\GAuthController@getApiProfileimage');
Route::resource('addcertificate', 'Api\GAuthController@getApiAddCertificate');
Route::resource('addgallery', 'Api\GAuthController@getApiAddGallery');
Route::resource('deletecertificate', 'Api\GAuthController@getApiDeleteCertificate');
Route::resource('deletegallery', 'Api\GAuthController@getApiDeleteGallery');
Route::resource('saveguideprofileinfo', 'Api\GAuthController@getApiSaveInfo');
Route::resource('addvideo', 'Api\GAuthController@getApiAddVideo');
Route::resource('deletevideo', 'Api\GAuthController@getApiDeleteVideo');
Route::resource('forgotpassword', 'Api\GAuthController@getForgetPassword');
});

Route::get('register/verify/{confirmation_code}', [
    'as' => 'confirmation_path',
    'uses' => 'Api\ApiRegistrationController@confirm'
]);

use Illuminate\Http\Request;

Route::post('callback/paypal/{guide_username}', [
	"uses" => "FrontEnd\PaypalpaymentController@afterPaymentCallback",
	'as' => 'finalize.after.payment',
	'middleware' => 'auth'
]);