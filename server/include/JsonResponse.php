<?php

class JsonResponse {
	public $code = null; // 200 by default for HTTP protocol
	public $messages = [];
	
	public function error($text) {		
		$this->messages[] = (object) ['type' => 'error', 'text' => $text];
	}

	public function info($text) {
		$this->messages[] = (object) ['type' => 'info', 'text' => $text];
	}
	
	public function code($http_code) {
		$this->code = $http_code;
	}
	
	public function hasErrors() {
		$errors = 0;
		foreach($this->messages as $m) {
			if($m->type == 'error') {
				$errors++;
			}
		}
		return ($errors > 0);
	}
	
	public function render() {
		header("Content-Type: application/json; charset=utf-8");
		if($this->code !== null) {
			http_response_code($this->code);
		}
		$flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT;
		return json_encode($this, $flags);
	}
}
