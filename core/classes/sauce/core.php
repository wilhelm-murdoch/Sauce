<?php
	/**
	 * core/sauce/core.php
	 *
	 * Contains environmental properties and autoloading methods for all other classes.
	 *
	 * @package Sauce
	 * @subpackage Core
	 * @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	 * @license GNU Lesser General Public License v3 <http://www.gnu.org/copyleft/lesser.html>
	 * @copyright Copyright (c) 2011, Daniel Wilhelm II Murdoch
	 * @since 0.1.0 'Prego'
	 * @link http://www.thedrunkenepic.com
	 */
	abstract class Sauce_Core {
		/**
		 * Build name of the current version of Sauce.
		 * @access Public
		 * @var Constant
		 * @static
		 */
		const __BUILD_NAME = 'Prego';

		/**
		 * Version of the current build of Sauce.
		 * @access Public
		 * @var Constant
		 * @static
		 */
		const __BUILD_VERSION = '0.1.0';

		/**
		 * Static array which contains absolute file paths for searching a cascading file system.
		 * @access Private
		 * @var Array
		 * @static
		 */
		static private $fileSearchPaths = array(___SAUCE_APP_PATH, ___SAUCE_SYSTEM_PATH);

		/**
		 * A psuedo-constructor which sets up environmental variables.
		 *
		 * @param None
		 * @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
		 * @access Public
		 * @return Void
		 * @static
		 */
		static public function bootstrap(array $config = array()) {}

		/**
		 * Simple autoloading method setup by PHP's spl_autoload_register() function. Uses standardized class names
		 * to determine their location within the file system. Calls Sauce_Core::fileSearch() method to locate the
		 * requested class within the cascading file system.
		 *
		 * @param String $className The name of the desired class.
		 * @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
		 * @access Public
		 * @return Boolean
		 * @uses Sauce_Core::fileSearch($directory)
		 * @static
		 */
		static public function autoLoad($className){
			if($filePath = self::fileSearch('classes', str_replace('_', DIRECTORY_SEPARATOR, strtolower($className)))) {
				require_once $filePath;
				return true;
			}
			return false;
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
		static public function addFileSearchPath($directory) {
			if(is_dir($directory) === false) {
				throw new Exception_HTTP_InternalServerError("The directory '{$directory}' could not be added.");
			}
			self::$fileSearchPaths[] = $directory;
			return true;
		}

		/**
		 * Iterates through self::$fileSearchPaths array to locate the desired file.
		 *
		 * @param String $directory The directory relative to any of the paths declared within self::$fileSearchPaths
		 * @param String $file The name of the file to search
		 * @param String $extension If not specified within the $file parameter, the file extension will go here. If set to NULL, Sauce will use the system default extension.
		 * @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
		 * @access Public
		 * @return String, False
		 * @static
		 */
		static public function fileSearch($directory, $file, $extension = null){
			$filePath = $directory.DIRECTORY_SEPARATOR.$file.(is_null($extension) ? ___SAUCE_EXT : ".{$extention}");
			foreach(self::$fileSearchPaths as $fileSearchPath){
				if(file_exists($fileSearchPath.$filePath)) {
					return $fileSearchPath.$filePath;
				}
			}

			return false;
		}
	}