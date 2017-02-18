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


    $stmt = $conn->prepare("SELECT * FROM cinfo WHERE author = :author LIMIT 10");
    $author = 'Here_Comes_The_King';
    $stmt->bindParam(':author', $author);
    $stmt->execute();

    //echo json_encode($stmt->fetchAll());

	//$data = json_decode(file_get_contents('php://input'));
    //$author = $data->special_data->author;
    //$stmt = $conn->prepare('SELECT * FROM cinfo WHERE author = ? LIMIT 5');
    //$stmt->bindParam(1, $author, PDO::PARAM_STR, 12);
    //$stmt->execute();

    //echo json_encode($stmt->fetchAll());

    $data = json_decode(file_get_contents('php://input'));
    foreach ($data->main_data->string_params as $param)
    {
    	$not = $param->not;
		$keyword = $param->keyword;
		$type = $param->type;
	}
    $keyword = $data->main_data->string_params['keyword'];
    echo $param;

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
        echo "No keyword was received";
}

search();
