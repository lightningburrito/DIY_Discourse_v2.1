<?php

require_once "database_connections.php";

function search()
{
	//do search magic
	$conn = connect();
	//how the connection is really made
	if(!$conn)
	{
		echo "conn failed";
		return 0;
	}

	$data = new stdClass();
	$data->id = "42";
	$data->author = "Butters";
	$data->ups = "561";
	$data->downs = "11";
	$data->score = "550";
	$data->body = "This comment is really intellijent";
	$array = [];
	$array[] = $data;
	echo json_encode($array);
	return 0;
}

search();
