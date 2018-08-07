<?php
//////////////////////////////////////////////////////
//
//		The PHP RPG Project
//
//	Version		:	1.0.0a
//	Author		:	The XPHPX Team!
//
//
//////////////////////////////////////////////////////

//
//	Will allow porting to other databases more easially plus its a lot cleaner
//	looking when you write the code
//
//	By: theamazingTWOeyedman
//

class db
{
	var $db_connection;
	var $query;
	var $db;

	//
	// This function opens a connection with the mysql database
	// 
	function db($host, $user, $passwd, $database)
	{
		$this->host = $host;
		$this->user = $user;
		$this->pass = $passwd;
		$this->database = $database;

		$this->db_connection = @mysql_connect($this->host, $this->user, $this->pass) or die(mysql_error());

		if($this->db_connection)
		{
			$this->database = $database;
			$dbselect = mysql_select_db($this->database) or die(mysql_error());
			return $this->db_connection;
		}
		else
		{
			return false;
		}
	}

	//
	// This function is for basic queries
	//
	function db_query($sql)
	{
		global $num_queries, $query_text;

		$query_text .= str_replace('\n', '', $sql) . "\n";

		$this->query = mysql_query($sql, $this->db_connection) or die('<b>A query error has been returned:</b><br><br><textarea cols=40 rows=5>' . mysql_error() . '</textarea><br>Please report this to the administrator.');

		// add to the number of queries performed
		$num_queries++;

		if($this->query)
		{
			// query was successful
			return $this->query;
		}
		else
		{
			// query failed
			return false;
		}
	}

	//
	// Return an array
	//
	function db_fetch_array($query_id = '')
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}

		if($query_id)
		{
			// success
			$this->row[$query_id] = mysql_fetch_array($query_id);
			return $this->row[$query_id];
		}
		else
		{
			// failure
			return false;
		}
	}

	//
	// Get the number of rows from a successful query
	//
	function db_num_rows($handle)
	{
		if(!$handle)
		{
			$handle = $this->query_result;
		}

		$num = mysql_num_rows($handle);

		if($num)
		{
			// success
			return $num;
		}
		else
		{
			// didnt work sorry
			return false;
		}
	}
}
?>