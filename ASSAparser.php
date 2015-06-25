<?php
class ASSAparser {
	public function parse($content) {
		// Remove all comment
		$content = preg_replace('/;.*?$/m', '', $content);
		// Create a empty array
		$assa = array();
		// Block processing
		if (preg_match_all('/\[(.+?)\](.+?)(?=\[|$)/s', $content, $matches)) {
			for ($i=0;$i<count($matches);$i++) {
				$assa[$matches[1][$i]] = $this->processing($matches[2][$i]);
			}
		}
		// Result
		return (Object) $assa;
	}
	public function plainText($text) {
		return preg_replace('/\{.+?\}/', '', $text);
	}
	private function processing($content) {
		// Remove empty line
		$content = preg_replace('/($\s*$)|(^\s*^)/m', '', $content);
		// Explode content to array
		$lines = explode("\n", $content);
		// Create an empty array
		$result = array();
		// Init format
		$format = array();
		$formatted = 0;
		// Scan lines
		foreach($lines as $line) {
			if (preg_match_all('/^(.+?)\:(.+?)$/', $line, $matches)) {
				$type = $matches[1][0];
				$cnt = preg_replace('/^\s+?|\s+?$/', '', $matches[2][0]);
				// (1) If format
				if ($type == 'Format') {
					$tmp = explode(",", $cnt);
					foreach($tmp as $key) {
						$format[] = preg_replace('/^\s+?|\s+?$/', '', $key);
					}
					$formatted = count($format);
					continue;
				}
				if ($formatted) {
					$tmp = explode(",", $cnt);
					if($formatted != count($tmp)) continue;
					$cnt = array(
						'type' => $type
					);
					$i = 0;
					foreach($tmp as $val) {
						$cnt[$format[$i++]] = preg_replace('/^\s+?|\s+?$/', '', $val);
					}
					$result[$type][] = (Object) $cnt;
				} else {
					$result[$type] = $cnt;
				}
			}
		}
		return (Object) $result;
	}
}
