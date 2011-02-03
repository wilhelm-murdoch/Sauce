<?php

	class Sauce_Request implements Interface_Singleton, Interface_Factory {
		static private $instance = null;
		static private $permittedHttpMethods = array (
			'GET', 'PUT', 'POST', 'DELETE', 'OPTIONS'
		);

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

		private function __call($method, $parameters) {
			return $this;
		}
		
		public function execute() {

		}
	}