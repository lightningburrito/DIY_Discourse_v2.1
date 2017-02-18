//current progress
//search engine
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
        $author = $data->special_data->author;
        $stmt = $conn->prepare('SELECT * FROM cinfo WHERE author = ? LIMIT 5');
        $stmt->bindParam(1, $author, PDO::PARAM_STR, 12);
        $stmt->execute();

        echo json_encode($stmt->fetchAll());

search();
