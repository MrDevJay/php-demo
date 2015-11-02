<?php
class Session{
	
	private $session_db;
	
	public function __construct($mysqli, $sessions_table){
		
		$this->session_db = $mysqli;
		
		$query = 'CREATE TABLE IF NOT EXISTS '.$sessions_table.' (
				id varchar(32) NOT NULL,
				access int(10) unsigned DEFAULT NULL,
				data text,
				PRIMARY KEY (id))';
		if(!$this->session_db->query($query)){
			die ("Creating sessions table failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
		session_set_save_handler(
			array($this, "sessiondb_open"),
			array($this, "sessiondb_close"),
			array($this, "sessiondb_read"),
			array($this, "sessiondb_write"),
			array($this, "sessiondb_destroy"),
			array($this, "sessiondb_gc")
		);
		register_shutdown_function('session_write_close');
		session_start();
	}
	
	public function sessiondb_open(){
		if($this->session_db){
			return true;
		}
		return false;
	}
	
	public function sessiondb_close(){
		if($this->session_db->close()){
			return true;
		}
		return false;
	}
	
	public function sessiondb_read($id){
		$query = 'SELECT data FROM sessions WHERE id = ?';
		$stmt = $this->session_db->prepare($query);
		$stmt->bind_param('s', $id);
		if($stmt->execute()){
			$stmt->bind_result($col1);
			$stmt->fetch();
			return $col1;
		} else {
			return '';
		}
	}
	
	public function sessiondb_write($id, $data){
		$access = time();
		$query = 'REPLACE INTO sessions VALUES (?, ?, ?)';
		$stmt = $this->session_db->prepare($query);
		$stmt->bind_param('sis', $id, $access, $data);
		if($stmt->execute()){
			return true;
		}
		return false;
	}
	
	public function sessiondb_destroy($id){
		$query = 'DELETE FROM sessions WHERE id = ?';
		$stmt = $this->session_db->prepare($query);
		$stmt->bind_param('s', $id);
		if($stmt->execute()){
			return true;
		}
		return false;
	}
	
	public function sessiondb_gc($max){
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