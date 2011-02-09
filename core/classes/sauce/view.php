<?php

	class Sauce_View {
		private $template;
		private $properties;
		private $views;
		public function __construct($template) {
			if(($this->template = Sauce::fileSearch('views', $template)) === false) {
				throw new Exception_HTTP_InternalServerError("view {$template} cannot be found");
			}
			$this->properties = array();
			$this->views = array();
		}

		public function bind($property, $value = null) {
			if(is_array($property)) {
				$this->properties = array_merge($this->properties, $property);
				return $this;
			}
			$this->properties[$property] = $value;
			return $this;
		}

		public function attach($alias, View $View) {
			$this->views[$alias] = $View;
			return $this;
		}

		public function remove($alias, View $View) {
			if(isset($this->properties[$alias])) {
				unset($this->properties[$alias]);
			}
			return $this;
		}

		public function render() {
			foreach($this->views as $alias => $View) {
				$View->bind($this->properties);
				$this->properties[$alias] = $View->render();
			}
			ob_start();
			require_once $this->template;
			$output = ob_get_contents();
			ob_end_clean();

			return $output;
		}

		public function __get($property) {
			return isset($this->properties[$property]) ? $this->properties[$property] : null;
		}

		public function  __set($property, $value) {
			$this->bind($property, $value);
		}
	}