<?php

$router->group([
	'middleware' => 'access.routeNeedsPermission:view-slider-management'
], function() use ($router) {

	get('slides/create', 'SlidesController@getImages')->name('admin.slides.pages');

	post('slides/create', 'SlidesController@postImages')->name('admin.slides.upload');

	get('slides/management', 'SlidesController@getAllSlides')-> name('admin.slides.all');

	get('slides/image', 'SlidesController@getAllSlidesImages')->name('frontend.guide.gallery');
	
	get('slides/delete/{id}', 'SlidesController@deleteSlides')->name('admin.slides.delete');
	get('slides/edit/{id}', 'SlidesController@editSlides')->name('admin.slides.edit');
	patch('slides/update/{id}', 'SlidesController@updateSlides')->name('admin.slides.update');
	
});