<?php

class DirectorUtils extends DirectorWrapper {
	
	function is_video($fn) {
		if (eregi('\.flv|\.mov|\.mp4|\.m4a|\.m4v|\.3gp|\.3g2', $fn)) {
			return true;
		} else {
			return false;
		}
	}
	
	function is_image($filename) {
		if (!$this->is_video($filename)) {
			return true;
		} else {
			return false;
		}
	}
	
	function is_mobile() {
		 return preg_match('/(iPhone|iPad|Android 2)/',  $_SERVER['HTTP_USER_AGENT']);
	}
	
	function truncate($string, $limit = 40, $tail = '...') {
		if (strlen($string) > $limit) {
			$string = substr($string, 0, $limit) . $tail;
		}
		return $string;
	}
	
	public function convert_line_breaks($string, $br = true) {
		$string = preg_replace("/(\r\n|\n|\r)/", "\n", $string);
		$string = preg_replace("/\n\n+/", "\n\n", $string);
		$string = preg_replace('/\n?(.+?)(\n\n|\z)/s', "<p>$1</p>\n", $string);
		if ($br) {
			$string = preg_replace('|(?<!</p>)\s*\n|', "<br />\n", $string);
		}
		return $string;
	}
}

?>