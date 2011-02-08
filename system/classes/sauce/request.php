<?php

	class Sauce_Request implements Interface_Singleton, Interface_Factory {
		static private $instance = null;
		const __HTTP_GET = 'GET';
		const __HTTP_PUT= 'PUT';
		const __HTTP_POST = 'POST';
		const __HTTP_DELETE = 'DELETE';
		const __HTTP_OPTIONS = 'OPTIONS';
		const __HTTP_TRACE = 'TRACE';
		const __HTTP_PATCH = 'PATCH';
		static private $permittedHttpMethods = array (
			self::__HTTP_GET, 
			self::__HTTP_PUT,
			self::__HTTP_POST,
			self::__HTTP_DELETE,
			self::__HTTP_OPTIONS,
			self::__HTTP_TRACE,
			self::__HTTP_PATCH
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

		protected $uri;
		protected $method;
		protected $status;
		protected $controller;
		protected $action;
		public $result;
		public $parameters;

		public function __construct($uri = null, $method = self::__HTTP_GET) {
			if(in_array($method, self::$permittedHttpMethods) === false) {
				throw new Exception_HTTP_MethodNotAllowed($method);
			}
			$this->uri = $uri;
			$this->method = $method;
			$this->statuc = 200;
			$this->controller = null;
			$this->action = $method;
			$this->result = null;
			$this->parameters = null;
		}

		static public function factory($uri = null, $method = self::__HTTP_GET) {
			return new self($uri, $method);
		}

		static public function singleton($uri = null, $method = self::__HTTP_GET) {
			if((self::$instance instanceof self) === false) {
				return self::$instance = new self($uri, $method);
			}
			return self::$instance;
		}

		public function headers(array $headers = array()) {
			return $this;
		}

		public function values(array $values = array()) {
			return $this;
		}

		public function result() {
			return $this->result;
		}

		public function execute() {
			if(is_null($this->uri)) {
				throw new Exception_HTTP_BadRequest('a URI to evaluate was not specified.');
			}

			if(($this->parameters = Router::matchAll($this->uri)) === false) {
				throw new Exception_HTTP_NotFound('the specified route could not be matched.');
			}

			if(isset($this->parameters['controller']) === false) {
				throw new Exception_HTTP_FailedDependency('controller not specified for route ['.$this->parameters['route'].']');
			}

			$this->controller = $this->parameters['controller'];
			$this->action = strtolower($method);

			unset($this->parameters['controller'], $this->parameters['action'], $this->parameters['route']);

			try {
				$Controller = new $this->controller($this);
				$Controller->before();
				$Controller->{$this->method}();
				$Controller->after();
			} catch(Exception $Exception) {
				// logging should go here
				// rethrow exception

				throw $Exception;
			}

			return $this;
		}
	}