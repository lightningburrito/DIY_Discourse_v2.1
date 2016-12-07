<?php


function connect()
{
	$servername = "localhost";
	$username = "reddit_user";
	$password = "'r33dit IS fun!";
	$dbname = "reddit";
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	return $conn;
}
function disconnect($conn)
{
	$conn = null;
}
