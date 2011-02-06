<?php

//	abstract class Router_Route {
//		protected $route;
//		protected $patterns;
//		protected $defaults;
//		private $components;
//		public function __construct($route, array $patterns = null, array $defaults = array()) {
//			$this->route = preg_replace('#[/|\\\]+#i', '/', trim($route, '\/'));
//			$this->patterns = $patterns;
//			$this->defaults = $defaults;
//		}
//		public function components() {
//			if(is_null($this->components)) {
//				preg_match_all('{([^/]+)?}', $this->route, $this->components);
//			}
//			return $this->components;
//		}
//		public function  __toString() {
//			return $this->route;
//		}
//	}
//
//	class Router_Route_Standard extends Router_Route {
//		public function __construct($route, array $patterns = null, array $defaults = array()) {
//			parent::__construct($route, $patterns, $defaults);
//		}
//	}
//
//	class Router {
//		const __REGEX_COMPONENT_REPLACE = '{([^/]+)}';
//		const __REGEX_COMPONENT_MATCH = '{([^/]+)?}';
//		public $routes;
//		public function __construct() {
//			$this->routes = array();
//		}
//		public function add(Router_Route $Route) {
//			$this->routes[spl_object_hash($Route)] = $Route;
//		}
//		public function match($uri) {
//			$uri = preg_replace('#[/|\\\]+#i', '/', trim($uri, '\/'));
//			foreach($this->routes as $Route) {
//				if(preg_replace(self::__REGEX_COMPONENT_REPLACE,'*',$Route) == preg_replace(self::__REGEX_COMPONENT_REPLACE,'*',$uri)){
//					preg_match_all(self::__REGEX_COMPONENT_MATCH, $uri, $uriComponents);
//					$routeComponents = $Route->components();
//					$arguments = array();
//					foreach($uriComponents[0] as $index => $component) {
//						if($component && strpos($routeComponents[0][$index],':') !== false) {
//							$arguments[substr($routeComponents[0][$index],1)] = $component;
//						}
//					}
//				}
//			}
//			print_r($arguments);
//		}
//	}
//
//	$Router = new Router;
//
//	$Router->add(new Router_Route_Standard('/user/:user_id'));
//
//	$Router->match('/user/234');
//
//	exit();

	define('___SAUCE_APP_PATH',    realpath('application').DIRECTORY_SEPARATOR);
	define('___SAUCE_SYSTEM_PATH', realpath('system').DIRECTORY_SEPARATOR);
	define('___SAUCE_EXT', '.php');

	require_once ___SAUCE_SYSTEM_PATH.'classes/sauce/core.php';
	require_once ___SAUCE_SYSTEM_PATH.'classes/sauce.php';

	spl_autoload_register(array('Sauce', 'autoLoad'));

	require ___SAUCE_APP_PATH.'init'.___SAUCE_EXT;