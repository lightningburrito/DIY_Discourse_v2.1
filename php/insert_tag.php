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
	$id_tag = $tag->id;
	$commentsArray = $data->comments; //array of comments

	//check if tag submitted exists in the tags table. if it does, get the id. if not, insert it.
	//insert an entry into the cinfo_tags table where id_tags is the tag->id, and id_cinfo is
	//the comment id. do this for each comment

    $stmt = $conn->prepare("SELECT * FROM tags WHERE id = :id LIMIT 1");
    $stmt->bindParam(':id', $id_tag);
    $stmt->execute();

    if ($stmt->rowCount() <=0)
    {
        //tag does not yet exist in tags table
        $tagInsertStmt = $conn->prepare("INSERT INTO tags (name) VALUES (:name)");
        $tagInsertStmt->bindParam(':name', $tag->name);
        $tagInsertStmt->execute();
        $id_tag = $conn->lastInsertId();

    }
	foreach ($commentsArray as $comment)
	{
		$stmt = $conn->prepare("SELECT * FROM cinfo_tags WHERE id_cinfo = :id_cinfo AND id_tags = :id_tags");
		$stmt->bindParam(':id_cinfo', $comment->id);
		$stmt->bindParam(':id_tags', $id_tag);
		$stmt->execute();
		if($stmt->rowCount()<=0)
		{
			$cinfoTagsStmt = $conn->prepare("INSERT INTO cinfo_tags (id_cinfo, id_tags) VALUES (:id_cinfo, :id_tags)");
			$cinfoTagsStmt->bindParam(':id_cinfo', $comment->id);
			$cinfoTagsStmt->bindParam(':id_tags', $id_tag);
			$cinfoTagsStmt->execute();
		}
	}
	$stmt = $conn->prepare("SELECT * FROM tags");
	$stmt->execute();

	echo json_encode($stmt->fetchAll());
}

insert();