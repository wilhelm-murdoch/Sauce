<?php

	class Sauce_Route {
		const REGEX_SEGMENT = '[^/.,;?\n]++';
		static private $routes = array();
		private $path;
		private $regex;
		private $defaults;
		public function __construct($path, array $regex = array(), array $defaults = array()) {
			$this->path = $path;
			$this->regex = $regex;
			$this->defaults = $defaults;
		}

		static public function add($path, array $regex = array(), array $options = array()) {
			self::$routes[] = new self($path, $regex, $options);
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
			if(preg_match($this->compile(), $url, $matches) == false) {
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

			return $parameters;
		}

		protected function compile()
		{
			// The URI should be considered literal except for keys and optional parts
			// Escape everything preg_quote would escape except for : ( ) < >
			$regex = preg_replace('#[.\\+*?[^\\]${}=!|]#', '\\\\$0', $this->path);

			if (strpos($regex, '(') !== FALSE)
			{
				// Make optional parts of the URI non-capturing and optional
				$regex = str_replace(array('(', ')'), array('(?:', ')?'), $regex);
			}

			// Insert default regex for keys
			$regex = str_replace(array('<', '>'), array('(?P<', '>'.Route::REGEX_SEGMENT.')'), $regex);

			if ( ! empty($this->regex))
			{
				$search = $replace = array();
				foreach ($this->regex as $key => $value)
				{
					$search[]  = "<{$key}>".Route::REGEX_SEGMENT;
					$replace[] = "<$key>$value";
				}

				// Replace the default regex with the user-specified regex
				$regex = str_replace($search, $replace, $regex);
			}

			return '#^'.$regex.'$#uDi';
		}
	}