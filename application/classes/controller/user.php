<?php

	class Controller_User extends Controller {
		public function __construct(Sauce_Request $Request) {
			parent::__construct($Request);
		}
		public function get() {
			echo '<pre>';
			print_r($this->Request->parameters);
			echo __METHOD__;
		}
		public function put() {
			echo __METHOD__;
		}
	}