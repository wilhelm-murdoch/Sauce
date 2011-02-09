<?php
	/**
	 * core/sauce/input.php
	 *
	 * Santizes input in order to protect the system from cross site scripting (XSS) attacks.
	 *
	 * @package Sauce
	 * @subpackage Core
	 * @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	 * @license GNU Lesser General Public License v3 <http://www.gnu.org/copyleft/lesser.html>
	 * @copyright Copyright (c) 2011, Daniel Wilhelm II Murdoch
	 * @since 0.1.0 'Prego'
	 * @link http://www.thedrunkenepic.com
	 */
	abstract class Sauce_Input {
		/**
		 * Can be used to clean a single string at a time or an entire array containing key => value pairs. Will also protect against malformed
		 * keys if an array is passed. If a malformed key is detected, it will be removed from the specified input array.
		 *
		 * @param String, Array $input The desired input to santize
		 * @param Boolean $xss Whether to run it through XSS cleaning
		 * @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
		 * @access Public
		 * @return String, Array
		 * @uses Sauce_Input::isIndexClean($index);
		 * @uses Sauce_Input::cleanXss($value, $xss);
		 * @static
		 */
		static public function clean($input, $xss = true) {
			if(is_array($input)) {
				foreach($input as $index => $value) {
					if(is_array($value)) {
						if(self::isIndexClean($index) === false) {
							unset($input[$index]);
						} else {
							$input[$index] = self::clean($value, $xss);
						}
					} else {
						if(self::isIndexClean($index) === false) {
							unset($input[$index]);
						} else {
							$input[$index] = self::cleanXss($value, $xss);
						}
					}
				}
				return $input;
			}
			return self::cleanXss($input);
		}

		/**
		 * Checks if the specified array index is valid.
		 *
		 * @param String, Integer $index The array index to check.
		 * @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
		 * @access Private
		 * @return Boolean
		 * @static
		 */
		static private function isIndexClean($index) {
			return ((bool) preg_match('#^[a-z0-9:_\/-]+$#i', $index));
		}

		/**
		 * Adds a new file path for method fileSearch to search through.
		 *
		 * @param String $directory Absolute path to the desired directory
		 * @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
		 * @access Public
		 * @return Void
		 * @uses Exception_HTTP_InternalServerError::__construct($message);
		 * @static
		 */
		static public function cleanXss($input) {
			$input = html_entity_decode($input, ENT_COMPAT, 'utf-8');
			$input = preg_replace('#(&\#*\w+)[\x00-\x20]\+;#U',"$1;", $input);
			$input = preg_replace('#(&\#x*)([0-9A-F]\+);*#iu',"$1$2;", $input);
			$input = preg_replace('#(<[^>]+[\s\r\n\"\'])(on|xmlns)[^>]*>#iU',"$1>", $input);
			$input = preg_replace('#([a-z]\*)[\x00-\x20]\*=[\x00-\x20]\*([\`\'\"]\*)[\\x00-\x20]\*j[\x00-\x20]\*a[\x00-\x20]\*v[\x00-\x20]\*a[\x00-\x20]\*s[\x00-\x20]\*c[\x00-\x20]\*r[\x00-\x20]\*i[\x00-\x20]\*p[\x00-\x20]\*t[\x00-\x20]\*:#iU', '$1=$2nojavascript...', $input);
			$input = preg_replace('#([a-z]\*)[\x00-\x20]\*=([\'\"]\*)[\x00-\x20]\*v[\x00-\x20]\*b[\x00-\x20]\*s[\x00-\x20]\*c[\x00-\x20]\*r[\x00-\x20]\*i[\x00-\x20]\*p[\x00-\x20]\*t[\x00-\x20]\*:#iU', '$1=$2novbscript...', $input);
			$input = preg_replace('#</*\w+:\w[^>]*>#i', '', $input);

			do {
				$clean = $input;
				$input = preg_replace('#</*(applet|meta|xml|blink|link|style|script|embed|object|iframe|frame|frameset|ilayer|layer|bgsound|title|base)[^>]*>#i','',$input);
			} while($clean != $input);

			do {
				$clean = $input;
				$input = preg_replace(array('/%0[0-8]/', '/[\x00-\x08]/','/%11/', '/\x0b/', '/%12/', '/\x0c/', '/%1[4-9]/', '/%2[0-9]/', '/%3[0-1]/', '/[\x0e-\x1f]/'), '', $input);
			} while ($clean != $input);

			return $input;
		}
	}