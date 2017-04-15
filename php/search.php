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
    $sql = 'SELECT * FROM cinfo WHERE';
    $firstField = 0;        //boolean flag that determines if the current field is the first one in the SQL statement

    //flags that denote if a field was added to the sql statement
    //used later when binding parameters
    $edited_flag = 0;
    $archived_flag = 0;
    $distinguished_flag = 0;
    $score_hidden_flag = 0;
    $retrieved_on_flag = 0;
    $created_utc_flag = 0;
    $upvotes_flag = 0;
    $downvotes_flag = 0;
    $score_flag = 0;
    $gilded_flag = 0;
    $controversiality_flag = 0;
    $authorFlairClass_flag = 0;
    $author_flag = 0;
    $subredditID_flag = 0;
    $authorFlairText_flag = 0;
    $name_flag = 0;
    $commentID_flag = 0;
    $subreddit_flag = 0;
    $parentID_flag = 0;
    $linkID_flag = 0;
    $keyword_flag = 0;

    //setting the input to variables
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

    //$score = 5;

	$keyword = $data->main_data->string_params[0]->keyword;
    /*foreach ($data->main_data->string_params as $param)
    {
        $not = $param->not;
        $keyword = $param->keyword;
        $type = $param->type;
    }*/
/*    foreach ($data->main_data->num_params as $param)
    {
        $operator = $param->operator;
        $number = $param->number;
        $type = $param->type;
    }*/

    //checks if each field should be added to the sql select statement
    //sets a flag equal to true for binding purposes later
    if (strcmp($edited, 'yes') == 0)
    {
        if ($firstField == 0)
        {
            $sql .= " edited != 'false'";
            $firstField = 1;
        }
        else
            $sql .= " AND edited != 'false'";
    }
    else if (strcmp($edited, 'no') == 0)
    {
        $edited = 'false';
        if ($firstField == 0)
        {
            $sql .= ' edited = :edited';
            $firstField = 1;
        }
        else
            $sql .= ' AND edited = :edited';
        $edited_flag = 1;
    }
    else
	{
		if ($firstField == 0)
		{
			$sql .= " edited='true' OR edited='false'";
			$firstField = 1;
		}
		else
			$sql .= " AND edited='true' OR edited='false'";
		$edited_flag = 0;
	}
    if (strcmp($archived, 'yes') == 0)
    {
        if ($firstField == 0)
        {
            $sql .= " archived != 'false'";
            $firstField = 1;
        }
        else
            $sql .= " AND archived != 'false'";
    }
    else if (strcmp($archived, 'no') == 0)
    {
        $archived = 'false';
        if ($firstField == 0)
        {
            $sql .= ' archived = :archived';
            $firstField = 1;
        }
        else
            $sql .= ' AND archived = :archived';
        $archived_flag = 1;
    }
    if (strcmp($distinguished, 'yes') == 0)
    {
        if ($firstField == 0)
        {
            $sql .= " distinguished != 'null'";
            $firstField = 1;
        }
        else
            $sql .= " AND distinguished != 'null'";
    }
    else if (strcmp($distinguished, 'no') == 0)
    {
        $distinguished = 'null';
        if ($firstField == 0)
        {
            $sql .= ' distinguished = :distinguished';
            $firstField = 1;
        }
        else
            $sql .= ' AND distinguished = :distinguished';
        $distinguished_flag = 1;
    }
    if (strcmp($scoreHidden, 'yes') == 0)
    {
        if ($firstField == 0)
        {
            $sql .= " score_hidden != 'false'";
            $firstField = 1;
        }
        else
            $sql .= " AND score_hidden != 'false'";
    }
    else if (strcmp($scoreHidden, 'no') == 0)
    {
        $scoreHidden = 'false';
        if ($firstField == 0)
        {
            $sql .= ' score_hidden = :scoreHidden';
            $firstField = 1;
        }
        else
            $sql .= ' AND score_hidden = :scoreHidden';
        $score_hidden_flag = 1;
    }
    if (strlen($retrievedOn) > 0)
    {
        if ($firstField == 0)
        {
            $sql .= ' retrieved_on = :retrievedOn';
            $firstField = 1;
        }
        else
            $sql .= ' AND retrieved_on = :retrievedOn';
        $retrieved_on_flag = 1;
    }

    //$createdUTC = '1/15/15';
    if (strlen($createdUTC) > 0)
    {
        $createdUTC = strtotime($createdUTC);
        $endRange = strtotime("+1 day", $createdUTC);
        if ($firstField == 0)
        {
            $sql .= ' (created_utc BETWEEN :createdUTC AND :endRange)';
            $firstField = 1;
        }
        else
            $sql .= ' AND (created_utc BETWEEN :createdUTC AND :endRange)';
        $created_utc_flag = 1;
    }
    if (strlen($upvotes) > 0)
    {
        if ($firstField == 0)
        {
            $sql .= ' ups = :upvotes';
            $firstField = 1;
        }
        else
            $sql .= ' AND ups = :upvotes';
        $upvotes_flag = 1;
    }
    if (strlen($downvotes) > 0)
    {
        if ($firstField == 0)
        {
            $sql .= ' downs = :downvotes';
            $firstField = 1;
        }
        else
            $sql .= ' AND downs = :downvotes';
        $downvotes_flag = 1;
    }
    if (strlen($score) > 0)
    {
        if ($firstField == 0)
        {
            $sql .= ' score = :score';
            $firstField = 1;
        }
        else
            $sql .= ' AND score = :score';
        $score_flag = 1;
    }
    if (strlen($gilded) > 0)
    {
        if ($firstField == 0)
        {
            $sql .= ' gilded = :gilded';
            $firstField = 1;
        }
        else
            $sql .= ' AND gilded = :gilded';
        $gilded_flag = 1;
    }
    if (strlen($controversiality) > 0)
    {
        if ($firstField == 0)
        {
            $sql .= ' controversiality = :controversiality';
            $firstField = 1;
        }
        else
            $sql .= ' AND controversiality = :controversiality';
        $controversiality_flag = 1;
    }
    if (strlen($subreddit) > 0)
    {
        if ($firstField == 0)
        {
            $sql .= ' subreddit = :subreddit';
            $firstField = 1;
        }
        else
            $sql .= ' AND subreddit = :subreddit';
        $subreddit_flag = 1;
    }
    if (strlen($author) > 0)
    {
        if ($firstField == 0)
        {
            $sql .= ' author = :author';
            $firstField = 1;
        }
        else
            $sql .= ' AND author = :author';
        $author_flag = 1;
    }
    if (strlen($commentID) > 0)
    {
        if ($firstField == 0)
        {
            $sql .= ' comment_id = :comment_id';
            $firstField = 1;
        }
        else
            $sql .= ' AND comment_id = :comment_id';
        $commentID_flag = 1;
    }
    if (strlen($subredditID) > 0)
    {
        if ($firstField == 0)
        {
            $sql .= ' subreddit_id = :subreddit_id';
            $firstField = 1;
        }
        else
            $sql .= ' AND subreddit_id = :subreddit_id';
        $subredditID_flag = 1;
    }
    if (strlen($parentID) > 0)
    {
        if ($firstField == 0)
        {
            $sql .= ' parent_id = :parent_id';
            $firstField = 1;
        }
        else
            $sql .= ' AND parent_id = :parent_id';
        $parentID_flag = 1;
    }
    if (strlen($linkID) > 0)
    {
        if ($firstField == 0)
        {
            $sql .= ' link_id = :link_id';
            $firstField = 1;
        }
        else
            $sql .= ' AND link_id = :link_id';
        $linkID_flag = 1;
    }
    if (strlen($name) > 0)
    {
        if ($firstField == 0)
        {
            $sql .= ' name = :name';
            $firstField = 1;
        }
        else
            $sql .= ' AND name = :name';
        $name_flag = 1;
    }
    if (strlen($authorFlairText) > 0)
    {
        if ($firstField == 0)
        {
            $sql .= ' author_flair_text = :author_flair_text';
            $firstField = 1;
        }
        else
            $sql .= ' AND author_flair_text = :author_flair_text';
        $authorFlairText_flag = 1;
    }
    if (strlen($authorFlairClass > 0))
    {
        if ($firstField == 0)
        {
            $sql .= ' author_flair_class = :author_flair_class';
            $firstField = 1;
        }
        else
            $sql .= ' AND author_flair_class = :author_flair_class';
        $authorFlairClass_flag = 1;
    }
    else if (strlen($authorFlairClass > 0))
    {
        if ($firstField == 0)
        {
            $sql .= ' author_flair_class = :author_flair_class';
            $firstField = 1;
        }
        else
            $sql .= ' AND author_flair_class = :author_flair_class';
        $authorFlairClass_flag = 1;
    }

    //$keyword = "science";
    if (strlen($keyword) > 0)
    {
        if ($firstField == 0)
        {
            $sql .= ' (body LIKE :body)';
            $firstField = 1;
        }
        else
            $sql .= ' AND (body LIKE :body)';
        $keyword = '%' . $keyword . '%';
        $keyword_flag = 1;
    }
    //else
    //{
        //echo "No keyword was received";
    //}

	$start = intval($data->request_number) * 20;
	if($data->get_all==true)
	{
		$sql .= ' LIMIT :start, 2000000000000';//2 trillion
	}
	else
	{
		$sql .= ' LIMIT :start, 20';
	}

    //echo $createdUTC;
    //echo $sql;

    //binds any parameters that have been added to the select statement
    $stmt = $conn->prepare($sql);
    if ($edited_flag == 1)
        $stmt->bindParam(':edited', $edited, PDO::PARAM_STR, 12);
    if ($archived_flag == 1)
        $stmt->bindParam(':archived', $archived, PDO::PARAM_STR, 12);
    if ($distinguished_flag == 1)
        $stmt->bindParam(':distinguished', $distinguished, PDO::PARAM_STR, 12);
    if ($score_hidden_flag == 1)
        $stmt->bindParam(':scoreHidden', $scoreHidden, PDO::PARAM_STR, 12);
    if ($retrieved_on_flag == 1)
        $stmt->bindParam(':retrievedOn', $retrievedOn, PDO::PARAM_INT);
    if ($created_utc_flag == 1) {
        $stmt->bindParam(':createdUTC', $createdUTC, PDO::PARAM_STR, 12);
        $stmt->bindParam(':endRange', $endRange, PDO::PARAM_STR, 12);
    }
    if ($upvotes_flag == 1)
        $stmt->bindParam(':upvotes', $upvotes, PDO::PARAM_INT);
    if ($downvotes_flag == 1)
        $stmt->bindParam(':downvotes', $downvotes, PDO::PARAM_INT);
    if ($score_flag == 1)
        $stmt->bindParam(':score', $score, PDO::PARAM_INT);
    if ($gilded_flag == 1)
        $stmt->bindParam(':gilded', $gilded, PDO::PARAM_INT);
    if ($controversiality_flag == 1)
        $stmt->bindParam(':controversiality', $controversiality, PDO::PARAM_INT);
    if ($subreddit_flag == 1)
        $stmt->bindParam(':subreddit', $subreddit, PDO::PARAM_STR, 12);
    if ($author_flag == 1)
        $stmt->bindParam(':author', $author, PDO::PARAM_STR, 12);
    if ($keyword_flag == 1) {
        //$stmt->bindParam(':author', $keyword, PDO::PARAM_STR, 12);
        $stmt->bindParam(':body', $keyword, PDO::PARAM_STR, 12);
        //$stmt->bindParam(':subreddit', $keyword, PDO::PARAM_STR, 12);
    }
    if($subredditID_flag == 1)
        $stmt->bindParam(':subreddit_id', $subredditID, PDO::PARAM_STR, 12);
    if($parentID_flag == 1)
        $stmt->bindParam(':parent_id', $parentID, PDO::PARAM_STR, 12);
    if($linkID_flag == 1)
        $stmt->bindParam(':link_id', $linkID, PDO::PARAM_STR, 12);
    if($name_flag == 1)
        $stmt->bindParam(':name', $name, PDO::PARAM_STR, 12);
    if($authorFlairText_flag == 1)
        $stmt->bindParam(':author_flair_text', $authorFlairText, PDO::PARAM_STR, 12);
    if($authorFlairClass_flag == 1)
        $stmt->bindParam(':author_flair_class', $authorFlairClass, PDO::PARAM_STR, 12);
    if($commentID_flag == 1)
        $stmt->bindParam(':comment_id', $commentID, PDO::PARAM_STR, 12);
    $stmt->bindParam(':start', $start, PDO::PARAM_INT);


    //echo $sql;
    $stmt->execute();
    echo json_encode($stmt->fetchAll());
}
search();