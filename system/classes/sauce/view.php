<?php

	class Sauce_View {
		private $template;
		private $properties;
		private $views;
		public function __construct($template) {
			$this->template = $template;
			$this->properties = array();
			$this->views = array();
		}

		public function bind($property, $value) {
			$this->properties[$property] = $value;
		}

		public function add(View $View) {
			$this->views[spl_object_hash($View)] = $View;
		}

		public function remove(View $View) {
			$hash = spl_object_hash($View);
			if(isset($this->properties[$hash])) {
				unset($this->properties[$hash]);
			}
		}

		public function render() {
			
		}
	}