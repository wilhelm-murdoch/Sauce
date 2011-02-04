<?php

	class Sauce_Route {
		static private $routes = array();
		private $path;
		private $regex;
		private $defaults;
		public function __construct($path, array $regex = array(), array $defaults = array()) {
			$this->path = $path;
			$this->regex = $regex;
			$this->defaults = $defaults;
		}

		static public function add($path, array $regex = array(), array $defaults = array()) {
			self::$routes[] = new self($path, $regex, $defaults);
		}

		static public function matchAll($url) {
			foreach(self::$routes as $Route) {
				if($parameters = $Route->matches($url)) {
					return $parameters;
				}
			}
			return false;
		}

		public function matches($url) {
			if(preg_match($this->compilePathExpression($this->path), preg_replace('#[/|\\\]+#i', '/', trim($url, '\/')), $matches) == false) {
				return false;
			}

			$parameters = array();
			foreach($matches as $key => $value) {
				if(is_int($key) === false) {
					$parameters[$key] = $value;
				}
			}

			foreach($this->defaults as $key => $value) {
				if(isset($parameters[$key]) === false || empty($parameters[$key])) {
					$parameters[$key] = $value;
				}
			}

			$parameters['route'] = $this->path;

			return $parameters;
		}

		protected function compilePathExpression($path) {
			$regex = str_replace(array (
				'\(', '\)', '\<', '\>', '(', ')', '<', '>'
			), array (
				'(', ')', '<', '>', '(?:', ')?', '(?P<', '>[^/.,;?\n]++)'
			), preg_quote($path));

			if($this->regex) {
				foreach($this->regex as $key => $value) {
					$regex = str_replace("<{$key}>[^/.,;?\n]++", "<{$key}>{$value}", $regex);
				}
			}

			return "#^{$regex}$#uDi";
		}
	}