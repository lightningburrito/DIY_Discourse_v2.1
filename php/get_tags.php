<?php

require_once "database_connections.php";

function get_tags()
{
	$conn = connect();
	//how the connection is really made
	if (!$conn) {
		echo "conn failed";
		return 0;
	}
	$data = json_decode(file_get_contents('php://input'));

	//returns all the tags from the tags table
}

get_tags();