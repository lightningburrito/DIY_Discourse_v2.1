//current progress

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

        $stmt = $conn->prepare("SELECT * FROM cinfo WHERE author = 'GallowBoob' LIMIT 10");
        $author = 'Here_Comes_The_King';
        $stmt->bindParam(':author', $author, PDO::PARAM_STR, 12);
        $stmt->execute();

        echo json_encode($stmt->fetchAll());

search();
