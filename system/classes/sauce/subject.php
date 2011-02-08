<?php

	class Sauce_Subject implements SplSubject {
		protected $observers;
		public function __construct($className) {
			$this->observers = array();

			if(isset($subjectObserverMap[$className])) {
				foreach($subjectObserverMap[$className] as $observerClassName) {
					if(class_exists($observerClassName)) {
						$this->attach(new $observerClassName);
					}
				}
			}
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
	}
