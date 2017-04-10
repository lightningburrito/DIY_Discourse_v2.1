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
	//
	$stmt = $conn->prepare("SELECT COUNT(id_tags) FROM cinfo_tags WHERE id_tags=:tagId");
	$stmt->bindParam(':tagId', intval($tag->id));
	$stmt->execute();
	$limit = $stmt->fetch()[0];
    //join cinfo and cinfo_tags
    $joinStmt = $conn->prepare("SELECT cinfo.* FROM cinfo JOIN cinfo_tags ON cinfo.id=cinfo_tags.id_cinfo WHERE cinfo_tags.id_tags=:tagId LIMIT :limitNumber");
    $joinStmt->bindParam(':tagId', intval($tag->id));
    $joinStmt->bindParam(':limitNumber', intval($limit), PDO::PARAM_INT);
    $joinStmt->execute();

    echo json_encode($joinStmt->fetchAll());
}

get_tags_comments();