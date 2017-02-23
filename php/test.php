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

    $data = json_decode(file_get_contents('php://input'));
    $start = intval($data->request_number)*20;
	$stmt = $conn->prepare("SELECT * FROM cinfo LIMIT :start, 20");
	$stmt->bindParam(':start', $start, PDO::PARAM_INT);
	$stmt->execute();

	echo json_encode($stmt->fetchAll());
}

search();
