<?php

	//http://mysite.com/rest/user/234

	Route::add('rest/user(/<id>)', array(
		'id' => '[0-9]+'
	), array(
		'controller' => 'Controller_User'
	));

	Route::add('rest/user(/<id>(/<entity>))', array(
		'id' => '[0-9]+'
	), array(
		'controller' => 'Controller_User'
	));

	try {
		Request::factory()->GET('rest/user/34')->execute();
		/**
		 * Request::factory()->GET('rest/user/34')
		 *                   ->headers(array(
		 *                       'Accept' => 'application/json'
		 *                   ))
		 *                   ->values(array())
		 *                   ->execute();
		 */
	} catch(Exception $Exception) {
		echo $Exception->getMessage();
	}