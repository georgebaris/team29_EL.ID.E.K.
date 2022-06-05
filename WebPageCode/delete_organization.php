<?php
	$server = "localhost";
	$username = "root";
	$password = "";
	$db_name = "elidek";
	
	$conn = mysqli_connect($server, $username, $password, $db_name);
	$query = "";
	
	if ($_SERVER["REQUEST_METHOD"] === "POST"){
		$query = "delete from organization where name = '" . $_POST["name"] . "';";
		$result = $conn->query($query);
	}
?>