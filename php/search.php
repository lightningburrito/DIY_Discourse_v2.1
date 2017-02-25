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


    $edited = $data->main_data->edited;
    //$archived = $data->main_data->archived;
    //$distinguished = $data->main_data->distinguished;
    //$scoreHidden = $data->main_data->score_hidden;

    $retrievedOn = $data->numerical_data->retrieved_on;
    $createdUTC = $data->numerical_data->created_utc;
    $upvotes = $data->numerical_data->up_votes;
    $downvotes = $data->numerical_data->down_votes;
    //$score = $data->numerical_data->score;
    //$gilded = $data->numerical_data->gilded;
    //$controversiality = $data->numerical_data->controversiality;

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

    if (strcmp($edited, 'true'))
    {
        if ($firstField == 0)
        {
            $sql .= ' edited = :edited';
            $firstField = 1;
        }
        else
            $sql .= ' AND edited = :edited';
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
    }

    if (strlen($createdUTC) > 0)
    {
        if ($firstField == 0)
        {
            $sql .= ' created_utc = :createdUTC';
            $firstField = 1;
        }
        else
            $sql .= ' AND created_utc = :createdUTC';
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
        }
    if (strlen($comment_id) > 0)
        {
            if ($firstField == 0)
            {
                $sql .= ' comment_id = :comment_id';
                $firstField = 1;
            }
            else
                $sql .= ' AND comment_id = :comment_id';
        }
    if (strlen($subreddit_id) > 0)
        {
            if ($firstField == 0)
            {
                $sql .= ' subreddit_id = :subreddit_id';
                $firstField = 1;
            }
            else
                $sql .= ' AND subreddit_id = :subreddit_id';
        }
     if (strlen($parent_id) > 0)
        {
            if ($firstField == 0)
            {
                $sql .= ' parent_id = :parent_id';
                $firstField = 1;
            }
            else
                $sql .= ' AND parent_id = :parent_id';
        }
    if (strlen($link_id) > 0)
        {
            if ($firstField == 0)
            {
                $sql .= ' link_id = :link_id';
                $firstField = 1;
            }
            else
                $sql .= ' AND link_id = :link_id';
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
        }
    if (strlen($author_flair_text) > 0)
        {
            if ($firstField == 0)
            {
                $sql .= ' author_flair_text = :author_flair_text';
                $firstField = 1;
            }
            else
                $sql .= ' AND author_flair_text = :author_flair_text';
        }
    if (strcmp($author_flair_class, 'true'))
    {
        if ($firstField == 0)
        {
            $sql .= ' author_flair_class = :author_flair_class';
            $firstField = 1;
        }
        else
            $sql .= ' AND author_flair_class = :author_flair_class';
    }



    //if (strlen($keyword) > 0)
    //{
        //$start = intval($data->request_number) * 20;
        //$stmt = $conn->prepare('SELECT * FROM cinfo WHERE author LIKE :author OR body LIKE :body OR subreddit LIKE :subreddit LIMIT :start, 20');
        //$stmt->bindParam(':author', $keyword, PDO::PARAM_STR, 12);
        //$stmt->bindParam(':body', $keyword, PDO::PARAM_STR, 12);
        //$stmt->bindParam(':subreddit', $keyword, PDO::PARAM_STR, 12);
        //$stmt->bindParam(':start', $start, PDO::PARAM_INT);
        //$stmt->execute();

        //echo json_encode($stmt->fetchAll());
    //}

    if (strlen($keyword) > 0)
    {
        $sql .= ' author LIKE :author OR body LIKE :body OR subreddit LIKE :subreddit';
        //$sql .= ' author LIKE ' . $keyword . ' OR body LIKE ' . $keyword . ' OR subreddit LIKE ' . $keyword;

    }
    else
    {
        echo "No keyword was received";
    }

    $start = intval($data->request_number) * 20;
    $sql .= ' LIMIT :start, 20';

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':author', $keyword, PDO::PARAM_STR, 12);
    $stmt->bindParam(':body', $keyword, PDO::PARAM_STR, 12);
    $stmt->bindParam(':subreddit', $keyword, PDO::PARAM_STR, 12);
    $stmt->bindParam(':start', $start, PDO::PARAM_INT);
    //$sql .= ' LIMIT ' . $start . ', 20';
    //echo $sql;
    $stmt->execute();



    echo json_encode($stmt->fetchAll());


}

search();
