<?php

	class Sauce_Core {
		static private $fileSearchPaths = array(___SAUCE_APP_PATH, ___SAUCE_SYSTEM_PATH);
		static public function autoLoad($className){
			try {
				if($filePath = self::fileSearch('classes', str_replace('_', DIRECTORY_SEPARATOR, strtolower($className)))) {
					require_once $filePath;
					return true;
				}
			}
			catch (Exception $Exception) { }

			return false;
		}

		static public function fileSearch($directory, $file, $extension = null){
			if(is_null($extension)) {
				$file .= '.'.___SAUCE_EXT;
			} else {
				$file .= ".{$extention}";
			}

			$filePath = $directory.DIRECTORY_SEPARATOR.$file;

			foreach(self::$fileSearchPaths as $fileSearchPath){
				if(file_exists($fileSearchPath.$filePath)) {
					return $fileSearchPath.$filePath;
				}
			}

			return false;
		}
	}