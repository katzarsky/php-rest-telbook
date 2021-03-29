<?php

class JsonResponse {
	public $code = 200;
	public $messages = [];
	private $rendered = false;
	
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
		foreach($this->messages as $m) {
			if($m->type == 'error') {
				return true;
			}
		}
		return false;
	}
	
	public function render() {
		if($this->rendered) return;
		$this->rendered = true;
		header("Content-Type: application/json; charset=utf-8");
		http_response_code($this->code);
		$flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT;
		return json_encode($this, $flags);
	}
}
