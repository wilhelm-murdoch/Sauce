<?php
	define('___SAUCE_APP_PATH',    realpath('app').DIRECTORY_SEPARATOR);
	define('___SAUCE_SYSTEM_PATH', realpath('core').DIRECTORY_SEPARATOR);
	define('___SAUCE_EXT', '.php');

	require_once ___SAUCE_SYSTEM_PATH.'classes/sauce/core.php';
	require_once ___SAUCE_SYSTEM_PATH.'classes/sauce.php';

	spl_autoload_register(array('Sauce', 'autoLoad'));

	require ___SAUCE_APP_PATH.'init'.___SAUCE_EXT;