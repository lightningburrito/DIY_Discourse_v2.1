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

    //$stmt = $conn->prepare("SELECT * FROM cinfo WHERE author=:author LIMIT 1");
    //$stmt = $conn->prepare("SELECT * FROM cinfo LIMIT 1");
    //$stmt->bindParam(":author", $author);
    //$author = "Here_Comes_The_King";


    //$stmt = $conn->prepare("SELECT * FROM cinfo WHERE author = 'GallowBoob' LIMIT 10");
    //$author = 'Here_Comes_The_King';
    //$stmt->bindParam(':author', $author, PDO::PARAM_STR, 12);
    //$stmt->execute();

    //echo json_encode($stmt->fetchAll());

	//$data = json_decode(file_get_contents('php://input'));
    //$author = $data->special_data->author;
    //$stmt = $conn->prepare('SELECT * FROM cinfo WHERE author = ? LIMIT 5');
    //$stmt->bindParam(1, $author, PDO::PARAM_STR, 12);
    //$stmt->execute();

    //echo json_encode($stmt->fetchAll());

    $data = json_decode(file_get_contents('php://input'));

    $edited = $data->main_data->edited;
    $archived = $data->main_data->archived;
    $distinguished = $data->main_data->distinguished;
    $scoreHidden = $data->main_data->score_hidden;

    $retrievedOn = $data->numerical_data->retrieved_on;
    $createdUTC = $data->numerical_data->created_utc;
    $upvotes = $data->numerical_data->up_votes;
    $downvotes = $data->numerical_data->down_votes;
    $score = $data->numerical_data->score;
    $gilded = $data->numerical_data->gilded;
    $controversiality = $data->numerical_data->controversiality;

    $subreddit = $data->special_data->subreddit;
    $author = $data->special_data->author;
    $commentID = $data->special_data->comment_id;
    $subredditID = $data->special_data->subreddit_id;
    $parentID = $data->special_data->parent_id;
    $linkID = $data->special_data->link_id;
    $name = $data->special_data->name;
    $authorFlairText = $data->special_data->author_flair_text;
    $authorFlairClass = $data->special_data->author_flair_class;

    foreach ($data->main_data->string_params as $param)
	{
        $not = $param->not;
        $keyword = $param->keyword;
        $type = $param->type;
	}
    foreach ($data->main_data->num_params as $param)
    {
        $operator = $param->operator;
        $number = $param->number;
        $type = $param->type;
    }

    if (strlen($keyword) > 0)
    {
        $stmt = $conn->prepare('SELECT * FROM cinfo WHERE author LIKE ? OR body LIKE ? OR subreddit LIKE ? LIMIT 5');
        $stmt->bindParam(1, $keyword, PDO::PARAM_STR, 12);
        $stmt->bindParam(2, $keyword, PDO::PARAM_STR, 12);
        $stmt->bindParam(3, $keyword, PDO::PARAM_STR, 12);
        $stmt->execute();

        echo json_encode($stmt->fetchAll());
    }
    else
    {
        echo "No keyword was received";
    }


}

search();
