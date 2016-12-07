<?php

//require 'database_connections.php';

/*function main()
{
	$conn = connect();
	if(!$conn) {
		echo "connection failed";
		return 0;
	}
	$stmt = $conn->prepare("SELECT * FROM cinfo WHERE id LIKE '1'");
	$stmt->execute();
	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
	disconnect($conn);
	echo json_encode($result);
}
main();*/
	$data = new stdClass();
	$data->id = "42";
	$data->author = "Butters";
	$data->ups = "561";
	$data->downs = "11";
	$data->score = "550";
	$data->body = "This comment is really intellijent";
	$array = [];
	$array[] = $data;
	echo json_encode($array);
	return 0;
/*
    //$conn = new mysqli("localhost", "root", "password");
    if (mysqli_connect_errno())
    {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    //get comment with id = 1
    $sql = "SELECT * FROM cinfo WHERE id LIKE '1'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0)
    {
      while ($row = $result->fetch_assoc())
      {
          echo "gilded: " . $row["gilded"]. "<br>";
          echo "author flair text: " . $row["author_flair_text"]. "<br>";
          echo "author flair css class: " . $row["author_flair_css_class"]. "<br>";
          echo "retrieved on: " . $row["retrieved_on"]. "<br>";
          echo "ups: " . $row["ups"]. "<br>";
          echo "subreddit id: " . $row["subreddit_id"]. "<br>";
          echo "edited: " . $row["edited"]. "<br>";
          echo "controversiality: " . $row["controversiality"]. "<br>";
          echo "parent id: " . $row["parent_id"]. "<br>";
          echo "subreddit: " . $row["subreddit"]. "<br>";
          echo "body: " . $row["body"]. "<br>";
          echo "created utc: " . $row["created_utc"]. "<br>";
          echo "downs: " . $row["downs"]. "<br>";
          echo "score: " . $row["score"]. "<br>";
          echo "author: " . $row["author"]. "<br>";
          echo "archived: " . $row["archived"]. "<br>";
          echo "distinguished: " . $row["distinguished"]. "<br>";
          echo "id: " . $row["id"]. "<br>";
          echo "score hidden: " . $row["score_hidden"]. "<br>";
          echo "name: " . $row["name"]. "<br>";
          echo "link id: " . $row["link_id"]. "<br>";
          echo "tags: " . $row["tags"]. "<br>";
          echo "word count: " . $row["wordcount"]. "<br>";
          echo "lwordcount: " . $row["lwordcount"]. "<br>";
          echo "sentcount: " . $row["sentcount"]. "<br>";
          echo "lix: " . $row["lix"]. "<br>";


         echo json_encode($row);
      }
    
    }

    else
    {
        echo "0 results";
    }
    
    
    $conn->close();*/
