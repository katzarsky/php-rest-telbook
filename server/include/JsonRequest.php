<?php

class JsonRequest {
	
	public $method = '';
	public $path = '';
	public $body = null;
	public $data = null;
	
	public function __construct() {
		// get the HTTP method, path and body of the request
		$this->method = $_SERVER['REQUEST_METHOD'];
		$this->path = trim($_SERVER['PATH_INFO'],'/');

		if(in_array($this->method, ['POST','PUT','PATCH'])) {
			$this->body = file_get_contents('php://input');
			$content_type = $_SERVER["CONTENT_TYPE"] ?? null;

			if($content_type == 'application/json') {
				$this->data = json_decode($this->body);
			}
		}
	}
	
	public function is($method, $route) {
		if($method === null || $method == $this->method) {
			return preg_match('#^'.$route.'$#', $this->path);
		}
		return false;
	}

	public function segment($segment_index, $default=null) {
		$segments = explode('/', $this->path);
		return $segments[$segment_index] ?? $default;
	}
}
