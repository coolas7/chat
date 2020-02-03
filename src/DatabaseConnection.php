<?php

namespace VytautasUoga\Task;
use mysqli;

class DatabaseConnection
{

	private $server_name;
	private $user_name;
	private $password;
	private $db_name;

	protected function connect()
	{
		$this->server_name = "localhost";
		$this->user_name = "debian-sys-maint";
		$this->password = "PkFGuAHUAsfFTVDt";
		$this->db_name = "task";

		$mysqli = new mysqli($this->server_name, $this->user_name, $this->password, $this->db_name);

		$mysqli->set_charset("utf8mb4");
		if ($mysqli->connect_error) {
    		die("Connection failed: " . $mysqli->connect_error);
		}	

		return $mysqli;
	}

}