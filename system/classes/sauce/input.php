<?php

	abstract class Sauce_Input {
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

		static private function isIndexClean($index) {
			return ((bool) preg_match('#^[a-z0-9:_\/-]+$#i', $index));
		}

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
			}
			while($clean != $input);

			do {
				$clean = $input;
				$input = preg_replace(array('/%0[0-8]/', '/[\x00-\x08]/','/%11/', '/\x0b/', '/%12/', '/\x0c/', '/%1[4-9]/', '/%2[0-9]/', '/%3[0-1]/', '/[\x0e-\x1f]/'), '', $input);
			}
			while ($clean != $input);

			return $input;
		}
	}