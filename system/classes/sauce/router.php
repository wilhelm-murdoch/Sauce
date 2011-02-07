<?php

	class Sauce_Router {
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
			if(preg_match($this->compilePathExpression($this->path), preg_replace('#[/|\\\]+#i', '/', trim($url, '\/')), $matches) === false) {
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
			$regex = str_replace(array (
				'\(', '\)', '\<', '\>', '(', ')', '<', '>'
			), array (
				'(', ')', '<', '>', '(?:', ')?', '(?P<', '>[[:alnum:]_-]++)'
			), preg_quote($path));

			if($this->regex) {
				foreach($this->regex as $key => $value) {
					$regex = str_replace("<{$key}>[:alnum:]_-]++", "<{$key}>{$value}", $regex);
				}
			}

			return "#^{$regex}$#i";
		}
	}