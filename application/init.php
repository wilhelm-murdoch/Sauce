<?php

	//http://mysite.com/rest/user/234
echo '<pre>';
print_r($_SERVER);
	Router::add('rest/user(/<id>)', array(
		'id' => '[0-9]+'
	), array(
		'controller' => 'Controller_User'
	));

	try {
		Request::factory('rest/user/34', Request::__HTTP_PUT)->execute();
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