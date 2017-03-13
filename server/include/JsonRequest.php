<?php

class JsonRequest {
	
	public $method = '';
	public $path = '';
	public $data = null;
	
	public function __construct() {
		// get the HTTP method, path and body of the request
		$this->method = $_SERVER['REQUEST_METHOD'];
		$this->path = trim($_SERVER['PATH_INFO'],'/');
		$this->data = json_decode(file_get_contents('php://input'));
	}
	
	private function match($route, $method=null) {
		if($method === null || $method == $this->method) {
			$reg_exp = '/^'.str_replace('/', '\/', $route).'$/';
			if(preg_match($reg_exp, $this->path)) {
				return true;
			}
		}
		return false;
	}

	public function segment($segment_index, $default=null) {
		$segments = explode('/', $this->path);
		if(isset($segments[$segment_index])) {
			return $segments[$segment_index];
		}
		return $default;
	}
	
	public function get($route) {
		return $this->match($route, 'GET');
	}

	public function put($route) {
		return $this->match($route, 'PUT');
	}
	
	public function post($route) {
		return $this->match($route, 'POST');
	}
	
	public function delete($route) {
		return $this->match($route, 'DELETE');
	}

	public function any($route) {
		return $this->match($route, null);
	}
}
