<?php
	/**
	 * core/sauce/controller.php
	 *
	 * Top-level controller for all other controllers derive from. Implements all required methods which
	 * can be overridden by derived controllers.
	 *
	 * @package Sauce
	 * @subpackage Core
	 * @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	 * @license GNU Lesser General Public License v3 <http://www.gnu.org/copyleft/lesser.html>
	 * @copyright Copyright (c) 2011, Daniel Wilhelm II Murdoch
	 * @since 0.1.0 'Prego'
	 * @link http://www.thedrunkenepic.com
	 */
	abstract class Sauce_Controller extends Subject implements Interface_Rest {
		/**
		 * Instance of Sauce_Request which represents the current request.
		 * @access Protected
		 * @var Object
		 */
		protected $Request;

		/**
		 * Instantiates class and defines instance variables.
		 *
		 * @param Object Sauce_Request $Request Instance of the current request.
		 * @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
		 * @access Public
		 * @return Void
		 */
		public function __construct(Sauce_Request $Request) {
			$this->Request = $Request;
		}

		/**
		 * Invoked immediately before the current controller's requested method.
		 *
		 * @param None
		 * @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
		 * @access Public
		 * @return Void
		 */
		public function before() {}

		/**
		 * Invoked immediately after the current controller's requested method.
		 *
		 * @param None
		 * @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
		 * @access Public
		 * @return Null
		 */
		public function after() {}

		/**
		 * Method which represents a GET HTTP request. This method can be used to
		 * request a specific object.
		 *
		 * @param None
		 * @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
		 * @access Public
		 * @return Void
		 * @uses Exception_HTTP_NotImplemented::__construct()
		 */
		public function get() {
			throw new Exception_HTTP_NotImplemented;
		}

		/**
		 * Method which represents a POST HTTP request. This method can be used to
		 * create a new object from scratch.
		 *
		 * @param None
		 * @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
		 * @access Public
		 * @return Void
		 * @uses Exception_HTTP_NotImplemented::__construct()
		 */
		public function post() {
			throw new Exception_HTTP_NotImplemented;
		}

		/**
		 * Method which represents a PUT HTTP request. This method can be used to
		 * update an entire existing object.
		 *
		 * @param None
		 * @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
		 * @access Public
		 * @return Void
		 * @uses Exception_HTTP_NotImplemented::__construct()
		 */
		public function put() {
			throw new Exception_HTTP_NotImplemented;
		}

		/**
		 * Method which represents a DELETE HTTP request. This method can be used to
		 * remove an existing object.
		 *
		 * @param None
		 * @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
		 * @access Public
		 * @return Void
		 * @uses Exception_HTTP_NotImplemented::__construct()
		 */
		public function delete() {
			throw new Exception_HTTP_NotImplemented;
		}

		/**
		 * Method which represents a OPTIONS HTTP request. This method can be used to
		 * display all currently supported API endpoints and associated methods.
		 *
		 * @param None
		 * @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
		 * @access Public
		 * @return Void
		 * @uses Exception_HTTP_NotImplemented::__construct()
		 */
		public function options() {
			throw new Exception_HTTP_NotImplemented;
		}

		/**
		 * Method which represents a PATCH HTTP request. This method can be used to
		 * update a portion of an existing object.
		 *
		 * @param None
		 * @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
		 * @access Public
		 * @return Void
		 * @uses Exception_HTTP_NotImplemented::__construct()
		 */
		public function patch() {
			throw new Exception_HTTP_NotImplemented;
		}

		/**
		 * Method which represents a TRACE HTTP request. This method can be used to
		 * ping back the current request.
		 *
		 * @param None
		 * @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
		 * @access Public
		 * @return Void
		 * @uses Exception_HTTP_NotImplemented::__construct()
		 */
		public function trace() {
			throw new Exception_HTTP_NotImplemented;
		}
	}