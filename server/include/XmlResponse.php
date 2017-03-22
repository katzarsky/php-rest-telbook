<?php

class XmlResponse extends JsonResponse{	
	public function render() {
		header("Content-Type: application/xml; charset=utf-8");
		if($this->code === null) {
			$this->code = 200;
		}
		else {
			http_response_code($this->code);
		}
		
		return 
			'<?xml version="1.0" encoding="UTF-8"?>'."\n".
			$this->xml_encode('data', $this);
	}
	
	private function xml_encode($name, $var) {
		$xml = "<$name>";
		if(is_object($var) || (is_array($var) && $this->is_assoc($var))) {
			foreach($var as $k => $v){
				$xml .= "\n".$this->xml_encode($k, $v);
			}
		}
		else if(is_array($var)) {
			foreach($var as $v){
				$xml .= "\n".$this->xml_encode($name.'-item', $v);
			}
		}
		else {
			$xml .= $this->xml_escape($var);
		}
		$xml .= "</$name>";
		return $xml;
	}
	
	private function is_assoc($arr) {
		if ([] === $arr) return false;
		return array_keys($arr) !== range(0, count($arr) - 1);
	}
	
	private function xml_escape($val) {
		return htmlspecialchars($val, ENT_QUOTES);
	}
}