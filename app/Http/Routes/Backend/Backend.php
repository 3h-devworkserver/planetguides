<?php

	get('reviews/unapproved', 'ReviewController@getUnapprovedReviews')-> name('admin.reviews.unapproved');
	get('reviews/all', 'ReviewController@getAllReviews')-> name('admin.reviews.all');
	get('reviews/status/{id}', 'ReviewController@changeStatusReviews')-> name('admin.reviews.status');
	get('reviews/delete/{id}', 'ReviewController@deleteReview')-> name('admin.reviews.delete');


	get('license','LicenseController@getAllLicense')->name('backend.license.all');
	get('license/{id}','LicenseController@getLicense')->name('backend.license');
	post('license/delete', 'LicenseController@deleteLicense')->name('backend.license.delete');


