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
	$commentsArray = $data->comments; //array of comments

	//check if tag submitted exists in the tags table. if it does, get the id. if not, insert it.
	//insert an entry into the cinfo_tags table where id_tags is the tag->id, and id_cinfo is
	//the comment id. do this for each comment

    $stmt = $conn->prepare("SELECT * FROM tags WHERE name = :name LIMIT 1");
    $stmt->bindParam(':name', $tag);
    $stmt->execute();

    if ($stmt->rowCount() > 0)
    {
        //tag already exists in tags table
        $result = $stmt->fetch();
        $tagsTableId = $result["id"];
        echo json_encode($tagsTableId);

        foreach ($commentsArray as $comment)
        {
            $commentId = $comment->id;
            $cinfoTagsStmt = $conn->prepare("INSERT INTO cinfo_tags (id_cinfo, id_tags) VALUES (:commentId, :tagsTableId)");
            $cinfoTagsStmt->bindParam(':commentId', $commentId);
            $cinfoTagsStmt->bindParam(':tagsTableId', $tagsTableId);
            $cinfoTagsStmt->execute();

        }
    }
    else
    {
        //tag does not yet exist in tags table
        $tagInsertStmt = $conn->prepare("INSERT INTO tags (name) VALUES (:name)");
        $tagInsertStmt->bindParam(':name', $tag);
        $tagInsertStmt->execute();

        //find the id of the row that was just inserted
        $findTagStmt = $conn->prepare("SELECT * FROM tags WHERE name = :name LIMIT 1");
        $findTagStmt->bindParam(':name', $tag);
        $findTagStmt->execute();
        $result = $findTagStmt->fetch();
        $tagsTableId = $result["id"];


        foreach ($commentsArray as $comment)
        {
            $commentId = $comment->id;
            $cinfoTagsStmt = $conn->prepare("INSERT INTO cinfo_tags (id_cinfo, id_tags) VALUES (:commentId, :tagsTableId)");
            $cinfoTagsStmt->bindParam(':commentId', $commentId);
            $cinfoTagsStmt->bindParam(':tagsTableId', $tagsTableId);
            $cinfoTagsStmt->execute();
        }

    }

}

insert();