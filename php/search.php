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

    if (strcmp($edited, 'true') == 0)
    {
        if ($firstField == 0)
        {
            $sql .= ' edited = :edited';
            $firstField = 1;
        }
        else
            $sql .= ' AND edited = :edited';
        $edited_flag = 1;
    }
    else if (strcmp($edited, 'false') == 0)
    {
        if ($firstField == 0)
        {
            $sql .= ' edited = :edited';
            $firstField = 1;
        }
        else
            $sql .= ' AND edited = :edited';
        $edited_flag = 1;
    }

    if (strcmp($archived, 'true') == 0)
    {
        if ($firstField == 0)
        {
            $sql .= ' archived = :archived';
            $firstField = 1;
        }
        else
            $sql .= ' AND archived = :archived';
        $archived_flag = 1;
    }
    else if (strcmp($archived, 'false') == 0)
    {
        if ($firstField == 0)
        {
            $sql .= ' archived = :archived';
            $firstField = 1;
        }
        else
            $sql .= ' AND archived = :archived';
        $archived_flag = 1;
    }

    if (strcmp($distinguished, 'true') == 0)
    {
        if ($firstField == 0)
        {
            $sql .= ' distinguished = :distinguished';
            $firstField = 1;
        }
        else
            $sql .= ' AND distinguished = :distinguished';
        $distinguished_flag = 1;
    }
    else if (strcmp($distinguished, 'false') == 0)
    {
        if ($firstField == 0)
        {
            $sql .= ' distinguished = :distinguished';
            $firstField = 1;
        }
        else
            $sql .= ' AND distinguished = :distinguished';
        $distinguished_flag = 1;
    }

    if (strcmp($scoreHidden, 'true') == 0)
    {
        if ($firstField == 0)
        {
            $sql .= ' score_hidden = :scoreHidden';
            $firstField = 1;
        }
        else
            $sql .= ' AND score_hidden = :scoreHidden';
        $score_hidden_flag = 1;
    }
    else if (strcmp($scoreHidden, 'false') == 0)
    {
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

    if (strlen($createdUTC) > 0)
    {
        if ($firstField == 0)
        {
            $sql .= ' created_utc = :createdUTC';
            $firstField = 1;
        }
        else
            $sql .= ' AND created_utc = :createdUTC';
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
    if (strlen($commentID) > 0)
    {
        if ($firstField == 0)
        {
            $sql .= ' comment_id = :comment_id';
            $firstField = 1;
        }
        else
            $sql .= ' AND comment_id = :comment_id';
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
    if (strlen($authorFlairText) > 0)
    {
        if ($firstField == 0)
        {
            $sql .= ' author_flair_text = :author_flair_text';
            $firstField = 1;
        }
        else
            $sql .= ' AND author_flair_text = :author_flair_text';
    }
    if (strcmp($authorFlairClass, 'true') == 0)
    {
        if ($firstField == 0)
        {
            $sql .= ' author_flair_class = :author_flair_class';
            $firstField = 1;
        }
        else
            $sql .= ' AND author_flair_class = :author_flair_class';
    }
    else if (strcmp($authorFlairClass, 'false') == 0)
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

    //$keyword = 'GallowBoob';

    if (strlen($keyword) > 0)
    {

        if ($firstField == 0)
        {
            $sql .= ' author LIKE :author OR body LIKE :body OR subreddit LIKE :subreddit';
            $firstField = 1;
        }
        else
            $sql .= ' AND author LIKE :author OR body LIKE :body OR subreddit LIKE :subreddit';
    }
    else
    {
        echo "No keyword was received";
    }

    $start = intval($data->request_number) * 20;
    $sql .= ' LIMIT :start, 20';

    //echo $sql;

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
    if ($created_utc_flag == 1)
        $stmt->bindParam(':createdUTC', $createdUTC, PDO::PARAM_INT);
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

    $stmt->bindParam(':author', $keyword, PDO::PARAM_STR, 12);
    $stmt->bindParam(':body', $keyword, PDO::PARAM_STR, 12);
    $stmt->bindParam(':subreddit', $keyword, PDO::PARAM_STR, 12);
    $stmt->bindParam(':subreddit_id', $subredditID, PDO::PARAM_STR, 12);
    $stmt->bindParam(':parent_id', $parentID, PDO::PARAM_STR, 12);
    $stmt->bindParam(':link_id', $linkID, PDO::PARAM_STR, 12);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR, 12);
    $stmt->bindParam(':author_flair_text', $authorFlairText, PDO::PARAM_STR, 12);
    $stmt->bindParam(':author_flair_class', $authorFlairClass, PDO::PARAM_STR, 12);
    //$stmt->bindParam(':subreddit_id', $keyword, PDO::PARAM_STR, 12);
    $stmt->bindParam(':comment_id', $commentID, PDO::PARAM_STR, 12);
    //$stmt->bindParam(':author', $keyword, PDO::PARAM_STR, 12);
    //$stmt->bindParam(':subreddit', $keyword, PDO::PARAM_STR, 12);
    $stmt->bindParam(':start', $start, PDO::PARAM_INT);
    //$sql .= ' LIMIT ' . $start . ', 20';
    //echo $sql;
    $stmt->execute();

    echo json_encode($stmt->fetchAll());


}

search();
