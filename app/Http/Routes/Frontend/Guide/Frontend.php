<?php

/**
 * Frontend Controllers
 */

/**
 * These frontend controllers require the user to be logged in
 */

$router->group(['namespace' => 'Guide'], function () use ($router) {

	
	$router->group(['prefix' => 'guide', 'middleware' => 'auth'], function () use ($router) {
		$router->group(['middleware' => 'access.routeNeedsRole:Guide'], function () {

			get('profile', 'ProfileController@index')->name('frontend.guide.index');
			get('profile/edit', 'ProfileController@edit')->name('frontend.guide.edit');
			get('settings', 'GuideController@getSettings')->name('frontend.guide.settings');
			post('settings', 'GuideController@postSettings')->name('frontend.guide.postsettings');
			post('settings/email', 'GuideController@updateEmailSettings')->name('frontend.guide.updateEmailSettings');

			
		
			post('profile/address', 'ProfileController@updateAddress')->name('frontend.guide.profile.updateAddress');
			post('profile/experience', 'ProfileController@updateExperience')->name('frontend.guide.profile.updateExperience');
			post('profile/gender', 'ProfileController@updateGender')->name('frontend.guide.profile.updateGender');
			post('profile/mguidingarea', 'ProfileController@updateMguidingArea')->name('frontend.guide.profile.updateMguidingArea');
			post('profile/oguidingarea', 'ProfileController@updateOguidingArea')->name('frontend.guide.profile.updateOguidingArea');
			post('profile/about', 'ProfileController@updateAbout')->name('frontend.guide.profile.updateAbout');
			post('profile/language', 'ProfileController@updateLanguage')->name('frontend.guide.profile.updateLanguage');
			post('profile/specilization', 'ProfileController@updateSpecilization')->name('frontend.guide.profile.updateSpecilization');

			post('PickDisableDates','ProfileController@PickDisableDates')->name('frontend.guide.profile.PickDisableDates');

			post('profile/pic/upload', 'ProfileController@picUpload')->name('frontend.guide.profile.pic.upload');

			post('license/upload', 'ProfileController@licenseUpload')->name('frontend.guide.license.upload');
			post('license/deleted', 'ProfileController@licenseDelete')->name('frontend.guide.license.delete');
			post('banner/upload', 'ProfileController@bannerUpload')->name('frontend.guide.banner.upload');

			
			

			get('gallery/video', 'ProfileController@getVideo')->name('frontend.guide.video');
			get('gallery/image', 'ProfileController@getGallery')->name('frontend.guide.gallery');
			
			

			get('reviews', 'GuideController@getReviews')->middleware('access.routeNeedsPermission:view-reviews-page')->name('frontend.guide.reviews');
			get('review/approve/{id}/status/{status}', 'GuideController@approveReview')->middleware('access.routeNeedsPermission:approve-reviews')->name('frontend.guide.review.approve');
			get('review/delete/{id}', 'GuideController@deleteReview')->middleware('access.routeNeedsPermission:delete-reviews')->name('frontend.guide.review.delete');
			get('earning', 'GuideController@earnings')->name('guide.earnings');

		});
		//getting other guidearea
		post('get/otherGuidearea', 'ProfileController@getotherguidearea')->name('frontend.guide.get.otherGuidearea');
		post('edit/otherGuidearea', 'ProfileController@editotherguidearea')->name('frontend.guide.get.otherGuidearea');

		post('videos/delete', 'ProfileController@videoDelete')->name('frontend.guide.video.delete');
		post('myvideos/delete', 'ProfileController@myvideosDelete')->name('frontend.guide.video.delete');
		post('video/edit', 'ProfileController@galleryEdit')->name('frontend.guide.video.edit');
		post('video/upload', 'ProfileController@videoUpload')->name('frontend.guide.video.upload');
		post('videos/upload', 'ProfileController@addvideoUpload')->name('frontend.guide.video.upload');
		
		post('license/delete', 'ProfileController@addlicenseDelete')->name('frontend.guide.license.delete');
		post('gallery/delete', 'ProfileController@galleryDelete')->name('frontend.guide.gallery.delete');
		post('gallery/edit', 'ProfileController@galleryEdit')->name('frontend.guide.gallery.edit');
		post('gallery/upload', 'ProfileController@galleryUpload')->name('frontend.guide.gallery.upload');
		post('addgallery/upload', 'ProfileController@addgalleryUpload')->name('frontend.guide.addgallery.upload');


		post('booking/editavailabilitys', 'ProfileController@postEditeAvability')->name('frontend.guide.edit.availability');
	});
	get('guide/{username}/gallery/video', 'ProfileController@getUserVideo')->name('frontend.guide.user.video');
	get('guide/{username}/gallery/image', 'ProfileController@getUserGallery')->name('frontend.guide.user.gallery');
	get('guide/{username}', 'GuideController@getProfile')->name('frontend.guide.profile');
	post('guide/{username}', 'GuideController@postReview')->name('frontend.guide.review');


	//post('booking/availability', 'BookingController@postAvability')->name('frontend.guide.booking.process');

	
});