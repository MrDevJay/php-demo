<?php
class Session{
	
	private $session_db;
	
	public function __construct($mysqli){
		
		$this->session_db = $mysqli;
		
		$this->session_db->query("CREATE TABLE IF NOT EXISTS sessions (
				id varchar(32) NOT NULL,
				access int(10) unsigned DEFAULT NULL,
				data text,
				PRIMARY KEY (id))");
		
		session_set_save_handler(
			array($this, "_open"),
			array($this, "_close"),
			array($this, "_read"),
			array($this, "_write"),
			array($this, "_destroy"),
			array($this, "_gc")
		);
		session_start();
	}
	
	/**
	 * Open
	 */
	public function _open(){
		// If successful
		if($this->session_db){
			// Return True
			return true;
		}
		// Return False
		return false;
	}
	
	/**
	 * Close
	 */
	public function _close(){
		// Close the database connection
		// If successful
		if($this->session_db->close()){
			// Return True
			return true;
		}
		// Return False
		return false;
	}
	
	/**
	 * Read
	 */
	public function _read($id){
		// Set query
		$query = 'SELECT data FROM sessions WHERE id = ?';
		$stmt = $this->session_db->prepare($query);
		$stmt->bind_param('s', $id);

		// Attempt execution
		// If successful
		if($stmt->execute()){
			$stmt->bind_result($col1);
			$stmt->fetch();
			return $col1;
		}else{
			// Return an empty string
			return '';
		}
	}
	
	/**
	 * Write
	 */
	public function _write($id, $data){
		// Create time stamp
		$access = time();
		 
		// Set query
		$query = 'REPLACE INTO sessions VALUES (?, ?, ?)';
		$stmt = $this->session_db->prepare($query);
		$stmt->bind_param('sis', $id, $access, $data);
	
		// Attempt Execution
		// If successful
		if($stmt->execute()){
			// Return True
			return true;
		}
		 
		// Return False
		return false;
	}
	
	/**
	 * Destroy
	 */
	public function _destroy($id){
		// Set query
		$query = 'DELETE FROM sessions WHERE id = ?';
		$stmt = $this->session_db->prepare($query);
		$stmt->bind_param('s', $id);

		// Attempt execution
		// If successful
		if($this->execute()){
			// Return True
			return true;
		}
	
		// Return False
		return false;
	}
	
	/**
	 * Garbage Collection
	 */
	public function _gc($max){
		// Calculate what is to be deemed old
		$old = time() - $max;
	
		// Set query
		$query = 'DELETE * FROM sessions WHERE access < ?';
		$stmt = $this->session_db->prepare($query);
		$stmt->bind_param('i', $old);

		// Attempt execution
		if($stmt->execute()){
			// Return True
			return true;
		}
	
		// Return False
		return false;
	}
}

?>