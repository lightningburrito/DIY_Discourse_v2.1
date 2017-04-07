<?php

require_once "database_connections.php";

function get_tags_comments()
{
	$conn = connect();
	//how the connection is really made
	if (!$conn) {
		echo "conn failed";
		return 0;
	}
	$data = json_decode(file_get_contents('php://input'));

	$tag = $data->tag;

	//joins the cinfo_tags and cinfo tables and gets all the comments where the id_tag is the id of the
	//tag->id
}

get_tags_comments();