<?php
	/**
	 * Exception for 'HTTP Version Not Supported' HTTP responses.
	 *
	 * @package Sauce
	 * @subpackage System/Classes/Exception/HTTP
	 * @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	 */
	class Exception_HTTP_HTTPVersionNotSupported extends Exception_Core {
		/**
		 * Instantiates class and defines instance variables.
		 *
		 * @param String $message A custom message to append to the HTTP response.
		 * @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
		 * @access Public
		 * @return Void
		 * @uses Exception_Core::__construct()
		 */
		public function __construct($message = null) {
			parent::__construct(Request::$responses[505].(is_null($message) === false ? ": {$message}" : ''), 505);
		}
	}