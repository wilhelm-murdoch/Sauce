<?php

	abstract class Controller_Core implements SplObserver, SplSubject, Interface_Rest {
		protected $observers;
		public function __construct() {
			$this->observers = array();
		}
		public function attach(SplObserver $Observer) {
			$this->observers[spl_object_hash($Observer)] = $Observer;
		}
		public function detach(SplObserver $Observer) {
			unset($this->observers[spl_object_hash($Observer)]);
		}
		public function notify() {
			foreach($this->observers as $Observer) {
				$Observer->update($this);
			}
		}
		public function update(SplSubject $Subject) {

		}
		public function before() {

		}
		public function after() {

		}
		public function get() {
			throw new Exception_HTTP_NotImplemented;
		}
		public function post() {
			throw new Exception_HTTP_NotImplemented;
		}
		public function put() {
			throw new Exception_HTTP_NotImplemented;
		}
		public function delete() {
			throw new Exception_HTTP_NotImplemented;
		}
		public function options() {
			throw new Exception_HTTP_NotImplemented;
		}
		public function patch() {
			throw new Exception_HTTP_NotImplemented;
		}
		public function trace() {
			throw new Exception_HTTP_NotImplemented;
		}
	}