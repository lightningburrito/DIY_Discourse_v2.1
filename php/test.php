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

	//$stmt = $conn->prepare("SELECT * FROM cinfo WHERE id=:id LIMIT 1");
	$stmt = $conn->prepare("SELECT * FROM cinfo LIMIT 10");
	//$stmt->bindParam(":id", $id);
	$id = "cnas8zv";

	$stmt->execute();
	echo json_encode($stmt->fetchAll());
}

search();
