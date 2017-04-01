<?php

require_once "database_connections.php";

function insert()
{
	//do search magic
	$conn = connect();
	//how the connection is really made
	if (!$conn) {
		echo "conn failed";
		return 0;
	}
	$data = json_decode(file_get_contents('php://input'));
}

insert();