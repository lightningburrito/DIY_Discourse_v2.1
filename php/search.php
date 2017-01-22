<?php
/**
 * Created by IntelliJ IDEA.
 * User: austi
 * Date: 1/16/2017
 * Time: 3:07 PM
 */

    require 'database_connections.php';

    $search = $_GET ['search'];

    $conn = connect();
    if (mysqli_connect_errno())
    {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    $sql = "SELECT * FROM cinfo WHERE author LIKE '$search' OR body LIKE '$search' OR  subreddit LIKE '$search'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0)
    {
        while ($row = $result->fetch_assoc())
        {
            echo json_encode($row);
        }
    }
    else
    {
        echo "0 results";
    }

    disconnect($conn);