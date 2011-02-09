<?php

	interface Interface_Rest {
		public function get();
		public function post();
		public function put();
		public function delete();
		public function options();
		public function patch();
		public function trace();
	}