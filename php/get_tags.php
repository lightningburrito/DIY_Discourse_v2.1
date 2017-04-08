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

	//returns all the tags from the tags table
    $stmt = $conn->prepare("SELECT name FROM tags");
    $stmt->execute();

    echo json_encode($stmt->fetchAll());
}

get_tags();