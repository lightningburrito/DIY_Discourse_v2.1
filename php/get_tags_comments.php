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
    //join cinfo and cinfo_tags
    $joinStmt = $conn->prepare("SELECT cinfo.* FROM cinfo JOIN cinfo_tags ON cinfo.id=cinfo_tags.id_cinfo WHERE cinfo_tags.id_tags=:tagId LIMIT 2");
    $joinStmt->bindParam(':tagId', intval($tag->id));
    $joinStmt->execute();

    echo json_encode($joinStmt->fetchAll());
}

get_tags_comments();