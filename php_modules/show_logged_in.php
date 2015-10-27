<?php
	
	function unserialize_session_data( $serialized_string ) {
	    $variables = array();
	    $a = preg_split( "/(\w+)\|/", $serialized_string, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE );
	    for( $i = 0; $i<count($a); $i = $i+2 ){
	        if(isset($a[$i+1])){
	                $variables[$a[$i]] = unserialize( $a[$i+1] );
			}
	    }
	    return( $variables );
	}
	
	function get_online_users($mysqli){
		
		$sql_current_sessions = "SELECT id, data FROM sessions";
		$result = $mysqli->query($sql_current_sessions);
		
		$online_users = array($result->num_rows);
		for($i=0; $i < $result->num_rows; $i++) {
			$row = $result->fetch_assoc();
			$session_data_array = unserialize_session_data($row["data"]);
			$online_users[$i] = $session_data_array['username'];
		}
		$mysqli->close();
		return $online_users;
	}
	
?>