<?php
	/**
	 * Exception for 'Payment Required' HTTP responses.
	 *
	 * @package Sauce
	 * @subpackage System/Classes/Exception/HTTP
	 * @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	 */
	class Exception_HTTP_PaymentRequired extends Exception_Core {
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
			parent::__construct(Request::$responses[402].(is_null($message) === false ? ": {$message}" : ''), 402);
		}
	}