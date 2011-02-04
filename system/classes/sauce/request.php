<?php

	class Sauce_Request implements Interface_Singleton, Interface_Factory {
		static private $instance = null;
		static private $permittedHttpMethods = array (
			'GET', 'PUT', 'POST', 'DELETE', 'OPTIONS', 'TRACE', 'PATCH'
		);

		public static $responses = array(
			100 => 'Continue',
			101 => 'Switching Protocols',
			200 => 'OK',
			201 => 'Created',
			202 => 'Accepted',
			203 => 'Non-Authoritative Information',
			204 => 'No Content',
			205 => 'Reset Content',
			206 => 'Partial Content',
			207 => 'Multi-Status',
			300 => 'Multiple Choices',
			301 => 'Moved Permanently',
			302 => 'Found',
			303 => 'See Other',
			304 => 'Not Modified',
			305 => 'Use Proxy',
			307 => 'Temporary Redirect',
			400 => 'Bad Request',
			401 => 'Unauthorized',
			402 => 'Payment Required',
			403 => 'Forbidden',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			406 => 'Not Acceptable',
			407 => 'Proxy Authentication Required',
			408 => 'Request Timeout',
			409 => 'Conflict',
			410 => 'Gone',
			411 => 'Length Required',
			412 => 'Precondition Failed',
			413 => 'Request Entity Too Large',
			414 => 'Request-URI Too Long',
			415 => 'Unsupported Media Type',
			416 => 'Requested Range Not Satisfiable',
			417 => 'Expectation Failed',
			422 => 'Unprocessable Entity',
			423 => 'Locked',
			424 => 'Failed Dependency',
			500 => 'Internal Server Error',
			501 => 'Not Implemented',
			502 => 'Bad Gateway',
			503 => 'Service Unavailable',
			504 => 'Gateway Timeout',
			505 => 'HTTP Version Not Supported',
			507 => 'Insufficient Storage',
			509 => 'Bandwidth Limit Exceeded'
		);

		protected static $method = 'GET';
		protected static $status = 200;

		public function __construct() {

		}

		static public function factory() {
			return new self;
		}

		static public function singleton() {
			if((self::$instance instanceof self) === false) {
				return self::$instance = new self;
			}
			return self::$instance;
		}

		static public function headers(array $headers = array()) {
			return $this;
		}

		static public function values(array $values = array()) {
			return $this;
		}

		private function __call($method, $parameters) {
			if(in_array($method, self::$permittedHttpMethods) === false) {
				throw new Exception_HTTP_MethodNotAllowed($method);
			}

			if($parameters == false || isset($parameters[0]) === false) {
				throw new Exception_HTTP_BadRequest('a route to evaluate was not specified.');
			}

			if(($matchedRoute = Route::matchAll($parameters[0])) === false) {
				throw new Exception_HTTP_NotFound("the specified route could not be matched.");
			}

			if(isset($matchedRoute['controller']) === false) {
				throw new Exception_HTTP_FailedDependency("controller not specified for route [{$matchedRoute['route']}]");
			}

			$Controller = new $matchedRoute['controller']($this);
			$Controller->before();
			$Controller->$method();
			$Controller->after();
			// does
			echo '<pre>';
			print_r($matchedRoute);

			return $this;
		}
		
		public function execute() {
			echo 'executing';
		}
	}