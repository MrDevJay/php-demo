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
		register_shutdown_function('session_write_close');
		session_start();
	}
	
	/**
	 * Open
	 */
	public function _open(){
		if($this->session_db){
			return true;
		}
		return false;
	}
	
	/**
	 * Close
	 */
	public function _close(){
		if($this->session_db->close()){
			return true;
		}
		return false;
	}
	
	/**
	 * Read
	 */
	public function _read($id){
		$query = 'SELECT data FROM sessions WHERE id = ?';
		$stmt = $this->session_db->prepare($query);
		$stmt->bind_param('s', $id);
		if($stmt->execute()){
			$stmt->bind_result($col1);
			$stmt->fetch();
			return $col1;
		}else{
			return '';
		}
	}
	
	/**
	 * Write
	 */
	public function _write($id, $data){
		$access = time();
		$query = 'REPLACE INTO sessions VALUES (?, ?, ?)';
		$stmt = $this->session_db->prepare($query);
		$stmt->bind_param('sis', $id, $access, $data);
		if($stmt->execute()){
			return true;
		}
		return false;
	}
	
	/**
	 * Destroy
	 */
	public function _destroy($id){
		$query = 'DELETE FROM sessions WHERE id = ?';
		$stmt = $this->session_db->prepare($query);
		$stmt->bind_param('s', $id);
		if($stmt->execute()){
			return true;
		}
		return false;
	}
	
	/**
	 * Garbage Collection
	 */
	public function _gc($max){
		$old = time()-$max;
		$query = 'DELETE FROM sessions WHERE access < ?';
		$stmt = $this->session_db->prepare($query);
		$stmt->bind_param('i', $old);
		if($stmt->execute()){
			return true;
		}
		return false;
	}
}

?>