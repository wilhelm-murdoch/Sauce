<?php

	class Sauce_Router {
		static private $routes = array();
		private $path;
		private $regex;
		private $defaults;
		public function __construct($path, array $defaults = array(), array $regex = array()) {
			$this->path = $path;
			$this->defaults = $defaults;
			$this->regex = $regex;
		}

		static public function add($path, array $defaults = array(), array $regex = array()) {
			self::$routes[] = new self($path, $defaults, $regex);
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
			foreach($matches as $index => $value) {
				if(is_int($index) === false) {
					$parameters[$index] = $value;
				}
			}

			foreach($this->regex as $index => $regex) {
				if(isset($parameters[$index]) && preg_match("#^{$regex}$#i", $parameters[$index]) == false) {
					$parameters[$index] = null;
				}
			}

			foreach($this->defaults as $index => $value) {
				if(isset($parameters[$index]) === false || empty($parameters[$index])) {
					$parameters[$index] = $value;
				}
			}

			return $parameters;
		}

		protected function compilePathExpression($path) {
			$regexString = str_replace(array (
				'\(', '\)', '\<', '\>', '(', ')', '<', '>'
			), array (
				'(', ')', '<', '>', '(?:', ')?', '(?P<', '>[[:alnum:]_-]++)'
			), preg_quote($path));

			if($this->regex) {
				foreach($this->regex as $index => $value) {
					$regexString = str_replace("<{$index}>[:alnum:]_-]++", "<{$index}>{$value}", $regexString);
				}
			}

			return "#{$regexString}$#i";
		}
	}