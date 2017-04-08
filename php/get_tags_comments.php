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

    //find id of tag in tags table
    $findTagStmt = $conn->prepare("SELECT * FROM tags WHERE name = :name LIMIT 1");
    $findTagStmt->bindParam(':name', $tag);
    $findTagStmt->execute();
    $result = $findTagStmt->fetch();
    $tagsTableId = $result["id"];

    //join cinfo and cinfo_tags
    $joinStmt = $conn->prepare("SELECT * FROM cinfo
                            INNER JOIN cinfo_tags ON cinfo_tags.id_tags = :tagsTableId");
    $joinStmt->bindParam(':tagsTableId', $tagsTableId);
    $joinStmt->execute();

    echo json_encode($joinStmt->fetchAll());
}

get_tags_comments();