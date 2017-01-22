<?php
require 'database_connections.php';
echo "hello?";
/*
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
*/
$sql = "SHOW TABLES FROM $dbname";
$result = mysql_query($sql);
if ($result)
{
echo "DB error, could not list tables\n";
echo "MySQL Error: " . mysql_error();
exit;
}
//while ($row = msql_fetch_row($result))
//{
    $data = new stdClass();
    $data->id = $row[0];
    $array = [];
	$array[] = $data;
	echo json_encode($array);
	return 0;
//}
msql_free_result($result);
?>