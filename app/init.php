<?php

	Router::add('welcome', array(
		'controller' => 'Controller_Welcome'
	));

	$_GET    = Input::clean($_GET);
	$_POST   = Input::clean($_POST);
	$_COOKIE = Input::clean($_COOKIE);

	try {
		echo $Request = Request::singleton('welcome')->execute()->result();
	} catch(Exception $Exception) {
		echo '<pre>';
		echo $Exception->getMessage();
	}