<?php

require_once "database_connections.php";

function insert()
{
	$conn = connect();
	//how the connection is really made
	if (!$conn) {
		echo "conn failed";
		return 0;
	}
	$data = json_decode(file_get_contents('php://input'));
	$tag = $data->tag;
	$comments = $data->comments; //array of comments

	//check if tag submitted exists in the tags table. if it does, get the id. if not, insert it.
	//insert an entry into the cinfo_tags table where id_tags is the tag->id, and id_cinfo is
	//the comment id. do this for each comment

    $stmt = $conn->prepare("SELECT name FROM tags WHERE name = :name");
    $stmt->bindParam(':name', $tag);
    $stmt->execute();

    if ($stmt->rowCount() > 0)
    {
        //tag already exists in tags table

    }
    else
    {
        //tag does not yet exist in tag table

    }

}

insert();