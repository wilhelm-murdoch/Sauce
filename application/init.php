<?php

	Route::add('rest/user(/<id>)', array(
		'id' => '[0-9]+'
	), array(
		'controller' => 'user'
	));

	Route::add('blest/users(/<id>)', array(
		'id' => '[0-9]+'
	), array(
		'controller' => 'users'
	));

	try {
		/**
		 * Request::factory()->GET('rest/user/34')
		 *                   ->headers(array(
		 *                       'Accept' => 'application/json'
		 *                   ))
		 *                   ->values(array())
		 *                   ->execute();
		 */
	} catch(Exception $Exception) {

	}