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
		
	} catch(Exception $Exception) {

	}