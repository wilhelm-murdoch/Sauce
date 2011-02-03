<?php

	define('___SAUCE_APP_PATH',    realpath('application' ).DIRECTORY_SEPARATOR );
	define('___SAUCE_SYSTEM_PATH', realpath('system' ).DIRECTORY_SEPARATOR );
	define('___SAUCE_EXT', 'php');

	require_once ___SAUCE_SYSTEM_PATH.'classes/sauce/core.php';
	require_once ___SAUCE_SYSTEM_PATH.'classes/sauce.php';

	spl_autoload_register(array('Sauce', 'autoLoad'));

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

	echo '<pre>';
	print_r(Route::matchAll('blest/users/34'));