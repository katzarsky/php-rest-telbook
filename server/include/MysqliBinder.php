<?php

class MysqliBinder extends Mysqli {
	
	public $response = null;
	
	public function __construct($host, $user, $password, $database) {
		parent::__construct($host, $user, $password, $database);
	}
	
	public function query($query, $resultmode = MYSQLI_STORE_RESULT) {
		$this->response->info('SQL: '.$query);
		$result = parent::query($query, $resultmode);
		if($result === false) {
			$this->response->error('SQL ERROR: '.$this->error);	
		}
		return $result;
	}
	
	public function querybind($template_query, $args=null) {
		$query = $this->bind($template_query, $args);
		return $this->query($query);
	}
	
	public function querybind_one($template_query, $args=null) {
		$result = $this->querybind($template_query, $args);
		$single = null;
		if($result) {
			$single = $result->fetch_object();
		}
		return $single;
	}

	public function querybind_all($template_query, $args=null) {
		$result = $this->querybind($template_query, $args);
		$all = [];
		if($result) {
			while($row = $result->fetch_object()) {
				$all[] = $row;
			}
		}
		return $all;		
	}
	
	public function bind($sql, $args=null) {
		if($args===null) {
			return $sql;
		}
		
		$fragments = explode('?', $sql);
		$bound_sql = '';
		
		for($i=0; $i<count($fragments)-1; $i++) {
			$arg = null;
			if(isset($args[$i])) $arg = $args[$i];
			$bound_sql .= $fragments[$i] . $this->escape($arg);
		}
		$bound_sql .= $fragments[$i];
		
		return $bound_sql;
	}
	
	public function escape($arg) {
		if(is_null($arg)) return 'NULL';
		if(is_string($arg)) return "'".$this->real_escape_string($arg)."'";
		if(is_numeric($arg)) return $arg+0;
		if(is_array($arg)) {
			$escaped = [];
			foreach($arg as $a) {
				$escaped[] = $this->escape($a);
			}
			return implode(', ', $escaped);
		}
		return '[UNKNOWN TYPE]';
	}
}
