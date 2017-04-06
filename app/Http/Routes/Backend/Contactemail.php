<?php

$router->group([
	'middleware' => 'access.routeNeedsPermission:view-contactemail-management'
], function() use ($router) {

	get('contactemail', 'ContactemailController@index');
	get('contactemail/{id}/reply', 'ContactemailController@showReplyContactEmail');
	patch('contactemail/reply/{id}', 'ContactemailController@sendReplyContactEmail');
	
});